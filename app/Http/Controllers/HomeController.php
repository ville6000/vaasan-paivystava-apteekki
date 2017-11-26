<?php

namespace App\Http\Controllers;

use App\Drugstore\Drugstore;

class HomeController extends Controller
{
    public function index()
    {
        $drugStore = new Drugstore();
        $storeName = $drugStore->getOnCallDrugstore();

        return view('home.index', [
            'storeName' => $storeName
        ]);
    }
}
