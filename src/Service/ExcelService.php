<?php

namespace App\Service;

use App\Entity\Article;
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
}
