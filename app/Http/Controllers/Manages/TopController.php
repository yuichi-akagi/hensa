<?php

namespace App\Http\Controllers\Manages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TopController extends Controller
{
    private $year_list = [
        '2020',
        '2021',
        '2022',
        '2023',
        '2024',
        '2025',
    ];
    public function index(Request $request)
    {
        return view('manage.index')
            ->with('year_list',$this->year_list)
        ;
    }
}
