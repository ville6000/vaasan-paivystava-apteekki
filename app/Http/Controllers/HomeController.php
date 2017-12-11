<?php

namespace App\Http\Controllers;

use App\Drugstore\Drugstore;

class HomeController extends Controller
{
    public function index()
    {
        $drugStore = new Drugstore();
        $storeName = $drugStore->getOnCallDrugstore();

        $monday = date('d.m', strtotime('monday this week'));
        $sunday = date('d.m', strtotime('sunday this week'));

        return view('home.index', [
            'storeName' => $storeName,
            'monday'    => $monday,
            'sunday'    => $sunday,
        ]);
    }
}
