<?php

namespace App\Controller;

use App\DrugStore\DrugStore;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $drugStore = new Drugstore();
        $storeName = $drugStore->getOnCallDrugstore();
        $monday = date('d.m', strtotime('monday this week'));
        $sunday = date('d.m', strtotime('sunday this week'));

        return $this->render('home/index.html.twig', [
            'monday' => $monday,
            'sunday' => $sunday,
            'storeName' => $storeName,
        ]);
    }
}