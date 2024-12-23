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
}
