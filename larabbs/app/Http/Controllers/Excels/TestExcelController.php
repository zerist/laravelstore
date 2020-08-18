<?php

namespace App\Http\Controllers\Excels;

use App\Http\Controllers\Controller;
use App\Models\RonghuaCake;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TestExcelController extends Controller
{
    public function index(Request $request)
    {
        return view("excels.index");
    }

    public function import(Request $request, RonghuaCake $cake)
    {
        $cake->saveExcel($request->file('testExcel')->getRealPath());
        return redirect()->route('excels.index')->with('success', "Success import file {$request->file('testExcel')->getBasename()} !");
    }
}
