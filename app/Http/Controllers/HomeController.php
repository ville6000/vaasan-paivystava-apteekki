<?php

namespace App\Http\Controllers;

use App\Drugstore\Drugstore;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        $drugStore = new Drugstore();
        $storeName = Cache::get('store');

        if (!$storeName) {
            $storeName = $drugStore->getOnCallDrugstore();
	        Cache::put('store', $storeName, 60);
        }

        $monday = date('d.m', strtotime('monday this week'));
        $sunday = date('d.m', strtotime('sunday this week'));

        return view('home.index', [
            'storeName' => $storeName,
            'monday'    => $monday,
            'sunday'    => $sunday,
        ]);
    }
}
