<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function findSimilarArticles(string $description, int $limit = 5, int $currentArticleId = null): array
    {
        $articles = $this->createQueryBuilder('a')
            ->where('a.id != :currentId')
            ->setParameter('currentId', $currentArticleId)
            ->getQuery()
            ->getResult();

        $results = [];
        foreach ($articles as $article) {
            $distance = levenshtein($description, $article->getDescription());
            $results[] = ['article' => $article, 'score' => $distance];
        }

        usort($results, fn($a, $b) => $a['score'] <=> $b['score']);

        return array_slice(array_column($results, 'article'), 0, $limit);
    }

    public function findBySearchQuery(?string $query): array
    {
        return $this->createQueryBuilder('a')
            ->where('a.code LIKE :query OR a.description LIKE :query')
            ->setParameter('query', '%'.$query.'%')
            ->getQuery()
            ->getResult();
    }

    public function lastsCreatedArticles(): array
    {
        return $this->createQueryBuilder('a')
            ->orWhere('a.createdDate IS NOT NULL')
            ->andWhere('a.spreadsheetName IS NULL')
            ->orderBy('a.id', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }

    public function lastsEditedArticles(): array
    {
        return $this->createQueryBuilder('a')
            ->orWhere('a.editedDate IS NOT NULL')
            ->andWhere('a.spreadsheetName IS NULL')
            ->orderBy('a.id', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }
}
