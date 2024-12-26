<?php

namespace App\DataFixtures;

use App\Service\ExcelService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    /**
     * @throws \Exception
     */
    public function load(ObjectManager $manager): void
    {
        $excelService = new ExcelService();
        $spreadsheet = $excelService->readFile("public/upload/articles.xlsx");
        $data = $excelService->createArticles($spreadsheet);

        foreach ($data as $article) {
            $manager->persist($article);
        }

        $manager->flush();
    }
}
