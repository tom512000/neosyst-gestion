<?php

namespace App\DataFixtures;

use App\Service\ExcelService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $excelService = new ExcelService();


        $manager->flush();
    }
}
