<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Agriculture;
use App\User;

class SDPController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show', 'retrieveData', 'retrieveTopData']]);
    }

    //Admin Page
    public function AdminPage(){

        if(auth()->user()->user_pos == 'Admin'){
            return view('pages.AdminPage');
        }else{
            return view('inc.404');
        }
    }

    //Add Product Page
    public function AddProduct($category){
        if(auth()->user()->user_pos == 'Admin'){
            return view('pages.AdminAddProduct')->with('category', $category);
        }else{
            return view('inc.404');
        }
    }

    //Store Product to database
    public function StoreProduct(Request $request){
        $this->validate($request, [
            'productName' => 'required',
            'info' => 'required',
            'supply' => 'required',
            'demand' => 'required',
            'price' => 'required',
            'image' => 'image|nullable|max:4999'
        ]);
        
        //handle the file upload
        if($request->hasFile('image')){
            //get filename with extensions
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            //get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //get the extension
            $extension = $request->file('image')->getClientOriginalExtension();
            //filename to store
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            //upload image
            $path = $request->file('image')->storeAs('public/images', $fileNameToStore);
        }else{
            $fileNameToStore = 'noimage.jpg';
        }

        DB::table("$request->category")->insert(
            [
                'ProductName'   => $request->productName,
                'Supply'        => $request->supply,
                'Demand'        => $request->demand,
                'Price'         => $request->price,
                'Info'          => $request->info,
                'Image'         => $fileNameToStore,
                'start_year'    => 2000,
                'created_at'    => strftime("%Y-%m-%d %H:%M:%S"),
                'updated_at'    => strftime("%Y-%m-%d %H:%M:%S"),
            ]
        );

        return redirect('/../public/AdminPage')->with('success', 'Product added successfully');
    }

    //Add SDP Data to Product
    public function AddSDP($category){
        if(auth()->user()->user_pos == 'Admin'){
            //products from Database
            $DBproducts = DB::table("$category")->get();

            //products to be send
            $products = [];
            foreach($DBproducts as $product){
                $products[$product->id] = $product->ProductName;
            }

            $data = [
                'products' => $products,
                'category' => $category,
            ];

            return view('pages.AdminAddSDP')->with($data);
            
        }else{
            return view('inc.404');
        }
    }

    //Store SDP Data to Product
    public function StoreSDP(Request $request){
        $this->validate($request, [
            'productName' => 'required',
            'supply' => 'required',
            'demand' => 'required',
            'price' => 'required',
        ]);

        $product = DB::table("$request->category")->where('id', '=', $request->productName)->get();

        //supply
        $Supply = explode(",", $product[0]->Supply);
        array_push($Supply, $request->supply);
        $Supplydata = implode(",", $Supply);

        //demand
        $Demand = explode(",", $product[0]->Demand);
        array_push($Demand, $request->demand);
        $Demanddata = implode(",", $Demand);

        //price
        $Price = explode(",", $product[0]->Price);
        array_push($Price, $request->price);
        $Pricedata = implode(",", $Price);

        DB::table("$request->category")->where('id', '=', $request->productName)
                                        ->update(
                                            [
                                                'Supply' => $Supplydata,
                                                'Demand' => $Demanddata,
                                                'Price'  => $Pricedata,
                                                'updated_at'    => strftime("%Y-%m-%d %H:%M:%S"),
                                            ]
                                        );

        return redirect('/../public/AdminPage')->with('success', 'SDP Data added successfully');
    }

    //Add Admin Account to database
    public function AddAcc(Request $request){
        $this->validate($request, [
            'Name' => 'required',
            'Password' => 'required',
            'Location' => 'required',
            'Email' => 'required',
        ]);

        $user = new User();
        $user->name = $request->Name;
        $user->email = $request->Email;
        $user->password = Hash::make($request->Password);
        $user->location = $request->Location;
        $user->user_pos = 'Admin';
        $user->save();

        return redirect('/../public/AdminPage')->with('success', 'Admin Account added successfully');
    }

    //Show Products
    public function index(){
        $products = Agriculture::all();
        //this will hold the product id of top 3
        $top1 = 0; $top2 = 0; $top3 = 0;

        //this will hold the demand amount of top 3
        $data1 = 0; $data2 = 0; $data3 = 0;

        foreach($products as $product){
            $data = $product->Demand;
            $data = explode(',', $data);
            $data = intval($data[array_key_last($data)]);
            if($data>$data1){
                $top2 = $top1;
                $data2 = $data1;

                $top1 = $product->id;
                $data1 = $data;
            }else if($data>$data2){
                $top3 = $top2;
                $data3 = $data2;

                $top2 = $product->id;
                $data2 = $data;
            }else if($data>$data3){
                $top3 = $product->id;
                $data3 = $data;
            }
        }
        $data = [
            'top1' => $top1,
            'top2' => $top2,
            'top3' => $top3,
            'products' => $products,
        ];

        return view('pages.AgricultureIndex')->with($data);
    }

    public function show($id){
        $product = Agriculture::find($id);

        $data = [
            'product' => $product,
        ];

        return view('pages.AgricultureShow')->with($data);
    }

    public function retrieveData(Request $request){
        $product = Agriculture::find($request->id);

        //label of the chart
        $label = [];
        for($i=intval($product->start_year); $i<=date('Y'); $i++){
            array_push($label, (string)$i);
        }
        
        //Supply data
        $supplyDatas = explode(',', $product->Supply);
        $Supply = [];
        foreach($supplyDatas as $supplyData){
            array_push($Supply, intval($supplyData));
        }
        
        //Demand data
        $demandDatas = explode(',', $product->Demand);
        $Demand = [];
        foreach($demandDatas as $demandData){
            array_push($Demand, intval($demandData));
        }
        
        //Price data
        $priceDatas = explode(',', $product->Price);
        $Price = [];
        foreach($priceDatas as $priceData){
            array_push($Price, intval($priceData));
        }

        $data = [$label,$Supply,$Demand,$Price,];

        return $data;
    }

    public function retrieveTopData(Request $request){
        $top1 = Agriculture::find($request->top1);
        $top2 = Agriculture::find($request->top2);
        $top3 = Agriculture::find($request->top3);

        $name1 = $top1->ProductName;
        $name2 = $top2->ProductName;
        $name3 = $top3->ProductName;

        //label of the chart
        $label = [];
        for($i=intval($top1->start_year); $i<=date('Y'); $i++){
            array_push($label, (string)$i);
        }
        
        //Top1 data
        $Top1Datas = explode(',', $top1->Demand);
        $top1 = [];
        foreach($Top1Datas as $Top1Data){
            array_push($top1, intval($Top1Data));
        }
        
        //Top2 data
        $Top2Datas = explode(',', $top2->Demand);
        $top2 = [];
        foreach($Top2Datas as $Top2Data){
            array_push($top2, intval($Top2Data));
        }
        
        //Top3 data
        $Top3Datas = explode(',', $top3->Demand);
        $top3 = [];
        foreach($Top3Datas as $Top3Data){
            array_push($top3, intval($Top3Data));
        }

        $data = [$label,$top1,$top2,$top3,$name1,$name2,$name3];

        return $data;
    }
}
