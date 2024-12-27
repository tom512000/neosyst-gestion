<?php

namespace App\DataFixtures;

use App\Service\ExcelService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ClientFixtures extends Fixture
{
    /**
     * @throws \Exception
     */
    public function load(ObjectManager $manager): void
    {
        $excelService = new ExcelService();
        $spreadsheet = $excelService->readFile("public/upload/clients.xlsx");
        $data = $excelService->createClients($spreadsheet);

        foreach ($data as $client) {
            $manager->persist($client);
        }

        $manager->flush();
    }
}
