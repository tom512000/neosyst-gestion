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
        $filespath = [
            "public/upload/articles.xlsx",
            "public/upload/articles2.xlsx",
            "public/upload/articles3.xlsx"
        ];

        foreach ($filespath as $filepath) {
            $spreadsheet = $excelService->readFile($filepath);
            $data = $excelService->createArticles($spreadsheet);

            foreach ($data as $article) {
                $manager->persist($article);
            }
        }

        $manager->flush();
    }
}
