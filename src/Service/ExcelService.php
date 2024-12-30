<?php

namespace App\Service;

use App\Entity\Article;
use App\Entity\Client;
use App\Entity\SAV;
use App\Repository\ClientRepository;
use PhpOffice\PhpSpreadsheet\Reader\Csv as ReaderCsv;
use PhpOffice\PhpSpreadsheet\Reader\Ods as ReaderOds;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as ReaderXlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Shared\Date;

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
                        $article->disableTracking();
                        $article->setCode($data[0]);
                        $article->setDescription($data[1]);
                        $article->setPrice($data[2]);
                        $article->setSpreadsheetName($worksheetTitle);
                        $article->enableTracking();

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

    public function createSavs(Spreadsheet $spreadsheet, ClientRepository $clientRepository): array
    {
        $savs = [];
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

                    if (count($data) >= 13 && $data[0] !== null) {
                        $sav = new SAV();
                        if ($data[1] !== null) {
                            $createdDate = Date::excelToDateTimeObject($data[1]);
                            $sav->setCreatedDate($createdDate);
                        }
                        if ($data[5] !== null) {
                            $sav->setRepresentative($data[5]);
                        }
                        if ($data[6] !== null) {
                            $breakdown = $data[6];
                            if (strlen($breakdown) > 255) {
                                $breakdown = substr($breakdown, 0, 252);
                                $breakdown .= "...";
                            }

                            $sav->setBreakdown($breakdown);
                        }
                        if ($data[7] !== null) {
                            $endDate = Date::excelToDateTimeObject($data[7]);
                            $sav->setEndDate($endDate);
                        }
                        if ($data[8] !== null) {
                            $sav->setRepairedBy($data[8]);
                        }
                        if ($data[9] !== null) {
                            $repairs = $data[9];
                            if (strlen($repairs) > 255) {
                                $repairs = substr($repairs, 0, 252);
                                $repairs .= "...";
                            }

                            $sav->setRepairs($repairs);
                        }
                        if ($data[10] !== null) {
                            $sav->setComments($data[10]);
                        }
                        if ($data[11] !== null) {
                            $sav->setCharge($data[11]);
                        }
                        if ($data[12] !== null) {
                            $code = $data[12];
                            $sav->setCode($code);

                            $client = $clientRepository->findOneBy(['code' => $code]);
                            $client->addSAV($sav);
                        }
                        $sav->setSpreadsheetName($worksheetTitle);

                        $savs[] = $sav;
                    }
                }
            }
        }

        return $savs;
    }
}
