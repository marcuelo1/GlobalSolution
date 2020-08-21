<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function search(Request $request){
        $keyword = $request->search;
        $products = DB::table('products')->whereRaw("ProductName LIKE '%$keyword%'")->get();
        $data = [
            'keyword' => $keyword,
            'products' => $products,
        ];
        return view('pages.results')->with($data);
    }
}
