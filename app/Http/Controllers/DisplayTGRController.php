<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DisplayTGRController extends Controller
{
    public function index()
    {
        $banners = DB::table('banners')
            ->where('active', 1)
            ->where('type', 'tgr')
            ->orderBy('order')
            ->get();

        return view('display-tgr', compact('banners'));
    }
}
