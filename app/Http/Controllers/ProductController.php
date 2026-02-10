<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

   // passing products and subTotal to the view
    public function index(): View
    {
        $products = $this->fetch();
        $subTotal = 0;

        foreach($products as $product){
            $subTotal = $subTotal + ($product->quantity * $product->price);

        }
        return view('products', compact(['products', 'subTotal']));

    }
    
    //fetching all the products from 
    public function fetch(){
        $fileName = 'data.json';
        $rawData = (File::get(public_path($fileName)));
        $products_array = json_decode($rawData);
        return $products_array;
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    // https://laravel.com/docs/12.x/filesystem
    //https://laracasts.com/discuss/channels/general-discussion/public-path-upload-image-issue

    //adding new products to the json file
    public function store(ProductRequest $request): void
    {
       //updatig the file with a new object
        $products_array = $this->fetch();
        array_push($products_array,$request->validated());
        $filename  = 'data.json';
        File::put(public_path($filename),json_encode($products_array));
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */

    //passing a filtered product to the view
    public function edit($index): View
    {
        $products = $this->fetch();
        $product;

        //Filter for the product that is of the index
        foreach($products as $filteredproduct){
            //https://www.geeksforgeeks.org/php/how-to-find-the-index-of-an-element-in-an-array-using-php/
            if(array_search($filteredproduct,$products) == $index){
                $product = $filteredproduct;
            }
        }
        return view('products.edit',compact(['product','index']));
    }

    /**
     * Update the specified resource in storage.
     */


    //updating a filtered product and pushing it to the json file without it loosing it position
    public function update(ProductUpdateRequest $request): RedirectResponse
    {
        $valid = $request->validated(); 
        $products = $this->fetch();
        $product;

        //creating a filter
        foreach($products as $filteredproduct){
            //https://www.geeksforgeeks.org/php/how-to-find-the-index-of-an-element-in-an-array-using-php/
            if(array_search($filteredproduct,$products) == $valid['index']){
                $product = $filteredproduct;
            }
        }

        //creating a payload for the form
        $payload =  [];
        $batch = [];
        $payload['name'] = $valid['name'] ?  $valid['name'] : $product->name;
        $payload['quantity'] = $valid['quantity'] ?  $valid['quantity']  : $product->quantity;
        $payload['price'] = $valid['price'] ?  $valid['price'] : $product->price;
        $payload['created_at'] = $product->created_at;

        //pushing the exiting objects to the batch
        $data = $this->fetch();
        foreach($data as $record){
            array_push($batch,$record);
        }

        //updating the batch
        $batch[$valid['index']] = $payload;

        //updating the json file
        $filename  = 'data.json';
        File::put(public_path($filename),json_encode($batch));
        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(string $id)
    {
        //
    }
}
