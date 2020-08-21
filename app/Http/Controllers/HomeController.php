<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;

class HomeController extends Controller
{
    public function __construct(){
        $this->middleware('auth', ['except' => ['index', 'search']]);
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(auth()->guest()){
            return view('home');
        }else if(auth()->user()->user_pos == 'Admin'){
            return redirect('/../public/AdminPage');
        }
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
