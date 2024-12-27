<?php

namespace App\Service;

use App\Entity\Article;
use App\Entity\Client;
use PhpOffice\PhpSpreadsheet\Reader\Csv as ReaderCsv;
use PhpOffice\PhpSpreadsheet\Reader\Ods as ReaderOds;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as ReaderXlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ExcelService
{
    /**
     * @throws \Exception
     */
    public function readFile(string $filepath): Spreadsheet
    {
        $filename = pathinfo($filepath, PATHINFO_BASENAME);
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $reader = match ($extension) {
            'ods' => new ReaderOds(),
            'xlsx' => new ReaderXlsx(),
            'csv' => new ReaderCsv(),
            default => throw new \Exception('Invalid extension'),
        };
        $reader->setReadDataOnly(true);

        return $reader->load($filepath);
    }

    public function createArticles(Spreadsheet $spreadsheet): array
    {
        $articles = [];
        foreach ($spreadsheet->getWorksheetIterator() as $worksheet) {
            foreach ($worksheet->getRowIterator() as $rowIndex => $row) {
                $worksheetTitle = $worksheet->getTitle();
                if ($rowIndex > 1) {
                    $cellIterator = $row->getCellIterator();
                    $cellIterator->setIterateOnlyExistingCells(false);

                    $data = [];
                    foreach ($cellIterator as $cell) {
                        $data[] = $cell->getValue();
                    }

                    if (count($data) >= 3) {
                        $article = new Article();
                        $article->setCode($data[0]);
                        $article->setDescription($data[1]);
                        $article->setPrice($data[2]);
                        $article->setSpreadsheetName($worksheetTitle);

                        $articles[] = $article;
                    }
                }
            }
        }

        return $articles;
    }

    public function createClients(Spreadsheet $spreadsheet): array
    {
        $clients = [];
        foreach ($spreadsheet->getWorksheetIterator() as $worksheet) {
            foreach ($worksheet->getRowIterator() as $rowIndex => $row) {
                $worksheetTitle = $worksheet->getTitle();
                if ($rowIndex > 1) {
                    $cellIterator = $row->getCellIterator();
                    $cellIterator->setIterateOnlyExistingCells(false);

                    $data = [];
                    foreach ($cellIterator as $cell) {
                        $data[] = $cell->getValue();
                    }

                    if (count($data) >= 5 && $data[0] !== null) {
                        $client = new Client();
                        $client->setCode($data[0]);
                        if ($data[1] !== null) {
                            $client->setName($data[1]);
                        }
                        if ($data[2] !== null) {
                            $phoneNumber = preg_replace('/\D/', '', $data[2]);
                            if ($phoneNumber > 10) {
                                $phoneNumber = substr($phoneNumber, 0, 10);
                            }

                            $client->setPhoneNumber($phoneNumber);
                        }
                        if ($data[3] !== null) {
                            $mobileNumber = preg_replace('/\D/', '', $data[3]);
                            if ($mobileNumber > 10) {
                                $mobileNumber = substr($mobileNumber, 0, 10);
                            }

                            $client->setMobileNumber($mobileNumber);
                        }
                        if ($data[4] !== null) {
                            $faxNumber = preg_replace('/\D/', '', $data[4]);
                            if ($faxNumber > 10) {
                                $faxNumber = substr($faxNumber, 0, 10);
                            }

                            $client->setFaxNumber($faxNumber);
                        }
                        $client->setSpreadsheetName($worksheetTitle);

                        $clients[] = $client;
                    }
                }
            }
        }

        return $clients;
    }
}
