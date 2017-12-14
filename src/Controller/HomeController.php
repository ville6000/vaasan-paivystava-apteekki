<?php

namespace App\Controller;

use App\DrugStore\DrugStore;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Cache\Simple\FilesystemCache;

class HomeController extends Controller
{
    public function index()
    {
        $cache = new FilesystemCache();
        $cacheKey = 'drugstore-name';

        if (!$cache->has($cacheKey)) {
            $drugStore = new Drugstore();
            $storeName = $drugStore->getOnCallDrugstore();

            $cache->set($cacheKey, $storeName, 60 * 60);
        } else {
            $storeName = $cache->get($cacheKey);
        }

        $monday = date('d.m', strtotime('monday this week'));
        $sunday = date('d.m', strtotime('sunday this week'));

        return $this->render('home/index.html.twig', [
            'monday' => $monday,
            'sunday' => $sunday,
            'storeName' => $storeName,
        ]);
    }
}