<?php

namespace App\Drugstore;

use Symfony\Component\DomCrawler\Crawler;

class Drugstore
{

	public function getOnCallDrugstore()
	{
		$drugStores = $this->getDrugStoreArray();
		$currentDate = new \DateTime();
		$currentDate = $currentDate->format('U');

		foreach ($drugStores as $name => $drugStore) {
			foreach ($drugStore['dates'] as $dates) {
				$weekStart = $this->createDateTime($dates['start']);
				$weekEnd = $this->createDateTime($dates['end']);

				if (!$weekEnd || !$weekStart) {
					return false;
				}

				if ($currentDate >= $weekStart->format('U') && $currentDate <= $weekEnd->format('U')) {
					return $name;
				}
			}
		}

		return false;
	}

	private function createDateTime($date)
	{
		$date = trim(html_entity_decode($date), " \t\n\r\0\x0B\xC2\xA0");
		$date = rtrim($date, '.');

		if (strlen($date) === 8) {
			$dateTime = \DateTime::createFromFormat('j.n.Y', $date);
		} else {
			$dateTime = \DateTime::createFromFormat('j.n', $date);
		}

		return $dateTime;
	}

	private function getDrugStoreArray()
	{
		$contextOptions = array(
			"ssl" => array(
				"verify_peer" => false,
				"verify_peer_name" => false,
			),
		);

		$document = file_get_contents(env('DRUGSTORE_ON_CALL_SOURCE'), false, stream_context_create($contextOptions));
		$crawler = new Crawler($document);
		$crawler = $crawler->filter('body .field-type-text-with-summary p');

		$drugStores = [];
		foreach ($crawler as $domElement) {
			if (!$this->isValidParagraph($domElement->nodeValue)) {
				continue;
			}

			foreach (explode("\n", $domElement->nodeValue) as $row) {
				$row = trim($row);
				$parts = explode(" ", $row);

				if (count($parts) === 5) {
					$parts[3] = $parts[3] . " " . $parts[4];
					unset($parts[4]);
				}

				$name = $parts[3];

				if (!isset($drugStores[$name])) {
					$drugStores[$name] = [
						'dates' => [],
					];
				}

				$drugStores[$name]['dates'][] = [
					'start' => $parts[0],
					'end' => $parts[2],
				];
			}
		}

		return $drugStores;
	}

	public function isValidParagraph($text)
	{
		$text = trim($text);
		$firstDay = substr($text, 0, strpos($text, "."));

		if (strlen($firstDay) > 2) {
			return false;
		}

		if (!is_numeric($firstDay)) {
			return false;
		}

		return true;
	}
}
