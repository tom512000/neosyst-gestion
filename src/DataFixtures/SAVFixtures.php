<?php

namespace App\DataFixtures;

use App\Repository\ClientRepository;
use App\Service\ExcelService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SAVFixtures extends Fixture
{
    private ClientRepository $clientRepository;

    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    /**
     * @throws \Exception
     */
    public function load(ObjectManager $manager): void
    {
        $excelService = new ExcelService();
        $spreadsheet = $excelService->readFile("public/upload/sav.xlsx");
        $data = $excelService->createSAVs($spreadsheet, $this->clientRepository);

        foreach ($data as $sav) {
            $manager->persist($sav);
        }

        $manager->flush();
    }
}
