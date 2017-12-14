<?php

namespace App\DrugStore;

use Symfony\Component\DomCrawler\Crawler;

class DrugStore
{
    public function getOnCallDrugstore()
    {
        $drugStores = $this->getDrugStoreArray();
        $currentDate = new \DateTime();
        $currentDate = $currentDate->format('U');

        foreach ($drugStores as $drugStore) {
            foreach ($drugStore['dates'] as $dateString) {
                $datePieces = $this->splitDateString($dateString);
                $weekStart = $this->createDateTime($datePieces[0]);
                $weekEnd = $this->createDateTime($datePieces[1]);

                if ($currentDate >= $weekStart->format('U') && $currentDate <= $weekEnd->format('U')) {
                    return $drugStore['name'];
                }
            }
        }

        return false;
    }

    private function splitDateString($dateString)
    {
        $dateString = str_replace(chr(149), '-', $dateString);
        $dateString = str_replace(chr(150), '-', $dateString);
        $dateString = str_replace(chr(151), '-', $dateString);
        $dateString = str_replace('–', '-', $dateString);
        return explode('-', $dateString);
    }

    private function createDateTime($date)
    {
        $date = rtrim(trim($date), '.');

        if (strlen($date) === 8) {
            $dateTime = \DateTime::createFromFormat('j.n.Y', $date);
        } else {
            $dateTime = \DateTime::createFromFormat('j.n', $date);
        }

        return $dateTime;
    }

    private function getDrugStoreArray()
    {
        $document = file_get_contents(getenv('DRUGSTORE_ON_CALL_SOURCE'));
        $crawler = new Crawler($document);
        $crawler = $crawler->filter('body .Table tr');
        $drugStores = [];

        foreach ($crawler as $domElement) {
            $rowCrawler = new Crawler($domElement);
            $cellIdx = 0;

            foreach ($rowCrawler->filter('td') as $cell) {
                if (!isset($drugStores[$cellIdx])) {
                    $drugStores[$cellIdx] = [
                        'name' => $cell->nodeValue,
                        'dates' => [],
                    ];
                } else {
                    $drugStores[$cellIdx]['dates'][] = $cell->nodeValue;
                }

                $cellIdx++;
            }
        }

        return $drugStores;
    }
}