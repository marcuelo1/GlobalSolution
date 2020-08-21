<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Product;
use App\User;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->user_pos == 'Admin'){
            return redirect('/../public/AdminPage');
        }

        $user_pos = auth()->user()->user_pos;
        if($user_pos == 'Buyer'){
            return view('inc.404');
        }else{
            $userID = auth()->user()->id;
            $products = DB::table('products')->where('Owner', '=', $userID)->get();
            return view('pages.products')->with('products', $products);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(auth()->user()->user_pos == 'Admin'){
            return redirect('/../public/AdminPage');
        }

        $user_pos = auth()->user()->user_pos;
        if($user_pos == 'Buyer'){
            return view('inc.404');
        }else{
            return view('pages.create');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validate the request data
        $this->validate($request, [
            'productName' => 'required',
            'productPrice' => 'required',
            'productCategory' => 'required',
            'productMinOrder' => 'required',
            'productPriceUnit' => 'required',
            'productMinOrderUnit' => 'required',
            'productDescription' => 'required',
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
            $fileNameToStore = 'noimage.jpeg';
        }
        
        //Saving the data to Database
        $product = new Product();
        $product->ProductName = $request->productName;
        $product->Price = $request->productPrice;
        $product->Category = $request->productCategory;
        $product->MinOrder = $request->productMinOrder;
        $product->Description = $request->productDescription;
        $product->Owner = auth()->user()->id;
        $product->Image = $fileNameToStore;
        $product->PriceUnit = $request->productPriceUnit;
        $product->MinOrderUnit = $request->productMinOrderUnit;
        $product->save();

        return redirect('/products')->with('success', 'Product Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        $seller = User::find($product->Owner);
        $data = [
            'product' => $product,
            'seller'  => $seller,
        ];
        return view('pages.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(auth()->user()->user_pos == 'Admin'){
            return redirect('/../public/AdminPage');
        }

        $user_pos = auth()->user()->user_pos;
        if($user_pos == 'Buyer'){
            return view('inc.404');
        }else{
            $product = Product::find($id);
            return view('pages.edit')->with('product', $product);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Validate the request data
        $this->validate($request, [
            'productName' => 'required',
            'productPrice' => 'required',
            'productCategory' => 'required',
            'productMinOrder' => 'required',
            'productPriceUnit' => 'required',
            'productMinOrderUnit' => 'required',
            'productDescription' => 'required',
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
        
        //Updating the Database
        $product = Product::find($id);
        $product->ProductName = $request->productName;
        $product->Price = $request->productPrice;
        $product->Category = $request->productCategory;
        $product->MinOrder = $request->productMinOrder;
        $product->Description = $request->productDescription;
        $product->PriceUnit = $request->productPriceUnit;
        $product->MinOrderUnit = $request->productMinOrderUnit;
        $product->Owner = auth()->user()->id;
        if($request->hasFile('image')){
            $product->Image = $fileNameToStore;
        }
        $product->save();

        return redirect('/products')->with('success', 'Product Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();

        return redirect('/products')->with('success', 'Product Deleted Successfully');
    }
}
