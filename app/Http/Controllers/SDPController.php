<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Agriculture;

class SDPController extends Controller
{
    public function Agriculture(Request $request){
        $this->validate($request, [
            'productName' => 'required',
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
        }

        $product = Agriculture::find($request->productName);
        
        if($request->hasFile('image')){
            $product->Image = $fileNameToStore;
        }

        //supply
        if($product->Supply==''){
            $data = array($request->supply);
            $data = implode(",", $data);
        }else{
            $Supply = explode(",", $product->Supply);
            array_push($Supply, $request->supply);
            $data = implode(",", $Supply);
        }
        $product->Supply = $data;

        //demand
        if($product->Demand==''){
            $data = array( $request->demand);
            $data = implode(",", $data);
        }else{
            $Demand = explode(",", $product->Demand);
            array_push($Demand, $request->demand);
            $data = implode(",", $Demand);
        }
        $product->Demand = $data;

        //price
        if($product->Price==''){
            $data = array( $request->price);
            $data = implode(",", $data);
        }else{
            $Price = explode(",", $product->Price);
            array_push($Price, $request->price);
            $data = implode(",", $Price);
        }
        $product->Price = $data;

        if($request->info != ''){
            $product->Info = $request->info;
        }

        $product->save();

        return redirect('/')->with('success', 'SDP added successfully');
    }

    public function AgricultureAddData(){
        $data = Agriculture::all();
        $products = [];
        foreach($data as $product){
            $products[$product->id] = $product->ProductName;
        }
        return view('pages.AgricultureAddData')->with('products', $products);
    }

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
