<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use App\Models\Product;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::paginate(10);
        return view('pages.product', compact('products'));
    }

    public function fetchData(Request $request){
        // if($request->ajax()){

        // }

        $product_name =$request->product_name;
        $is_sales = $request->is_sales;
        $price_from = $request->price_from;
        $price_to = $request->price_to;

        // echo $request->email;
        
        $products = Product::select('*');

        $products = $this->filterSearch($products, $product_name, $is_sales, $price_from, $price_to);
        $products = $products->paginate(10);
        $products = $products->appends(['product_name' => $product_name,
                                    'is_sales'=> $is_sales,
                                    'price_from' => $price_from,
                                    'price_to' => $price_to   ]);

        return view('layouts.productlist', compact('products'));
        // return response()->json([
        //     $products
        // ]);
    }

    public function filterSearch($products, $product_name, $is_sales, $price_from, $price_to) 
    {
        $products = $is_sales!=null ? $products->where('is_sales', $is_sales) : $products;
        $products = $product_name!=null ? $products->where('product_name', 'like', $product_name . '%') : $products;
        $products = $price_from!=null ? $products->where('product_price', '>=', $price_from) : $products;
        $products = $price_to!=null ? $products->where('product_price', '<=', $price_to) : $products;

        return $products;
    }

    // public function postProduct(ProductRequest $request){
    //     $error_arr = [];
    //     $success_add = '';
    //     if (isset($request->validator) && $request->validator->fails()) {
    //         $error_arr[] = $request->validator->errors()->messages() ;

    //     }else {
    //         if(request()->button_action == 'insert') {
    //             $product = new Product();
    //             $product->product_name = $request->product_name;
    //             $product->product_price = $request->product_price;
    //             $product->description = $request->description;
    //             $product->is_sales = $request->is_sales;
                
    //             if($request->file('file_photo')){
    //                 $fileName = time().$request->file('file_photo')->getClientOriginalName();
    //                 $path = $request->file('file_photo')->storeAs('images', $fileName, 'public');
    //                 $product->product_image = "/storage/$path";
    //             }

    //             // $product->save();

    //             $success_add =  'Product added';
    //             // return redirect('/product')->with($success_add);
    //         }
    //         if(request()->button_action == 'update') {
    //             $product = Product::findOrFail(request()->id);
    //             $product->product_name = $request->product_name;
    //             $product->product_price = $request->product_price;
    //             $product->description = $request->description;
    //             $product->is_sales = $request->is_sales;
                
    //             if($request->file('file_photo')){
    //                 $fileName = time().$request->file('file_photo')->getClientOriginalName();
    //                 $path = $request->file('file_photo')->storeAs('images', $fileName, 'public');
    //                 $product->product_image = "/storage/$path";
    //             }

    //             // $product->save();

    //             $success_add =  'Product updated';
    //             // return redirect('/product')->with($success_add);

    //         }

    //     }
    //     $output = [
    //         'error' => $error_arr,
    //         'success' => $success_add
    //     ];
    //     return json_encode($output);
    //     // return view('layouts.postproduct', compact('output'));
    // }

    public function storeProduct(ProductRequest $request){
        $error_arr = [];
        $success_add = '';
        // dd($request->showPhoto);

        //  dd($request->file('file_photo'));
        if (isset($request->validator) && $request->validator->fails()) {
            $error_arr[] = $request->validator->errors()->messages() ;
            // return response()->json(['error' => $error_arr]);;

        }else {
            if(request()->button_action == 'insert') {
                $product = new Product();
                $subStr = substr($request->product_name,0,1);
                $newid = substr(Product::select('product_id')
                                        ->where('product_name', 'like', $subStr.'%' )
                                        ->max('product_id'),1,9) + 1;
                // dd($newid);
                $product->product_id = $subStr.$newid;
                $product->product_name = $request->product_name;
                $product->product_price = $request->product_price;
                $product->description = $request->description;
                $product->is_sales = $request->is_sales;
                $request->file('file_photo');
                if($request->file('file_photo') != null){
                    $fileName = time().$request->file('file_photo')->getClientOriginalName();
                    $path = $request->file('file_photo')->storeAs('images', $fileName, 'public');
                    $product->product_image = "/storage/$path";
                }
    
                $product->save();
                $success_add =  'Product added';
                // return redirect('/product')->with($success_add);
            }
            if(request()->button_action == 'update') {
                if(substr(request()->id,0,1) != substr($request->product_name,0,1)){

                    $old_product = Product::findOrFail(request()->id);

                    $product = new Product();
                    $subStr = substr($request->product_name,0,1);
                    $newid = substr(Product::select('product_id')
                                            ->where('product_name', 'like', $subStr.'%' )
                                            ->max('product_id'),1,9) + 1;
                    $product->product_id = $subStr.$newid;
                    $product->product_image = $old_product->product_image;
                    $old_product->delete();
                    
                }else{
                    $product = Product::findOrFail(request()->id);
                }
                $product->product_name = $request->product_name;
                $product->product_price = $request->product_price;
                $product->description = $request->description;
                $product->is_sales = $request->is_sales;
                // check first
                // dd($request->all());

                if($request->img_del == '1'){
                    $product->product_image = '';
                }
                // check second
                if($request->file('file_photo') != null){
                    $fileName = time().$request->file('file_photo')->getClientOriginalName();
                    $path = $request->file('file_photo')->storeAs('images', $fileName, 'public');
                    $product->product_image = "/storage/$path";
                }
 
                $product->save();

                $success_add =  'Update added';
                // return redirect('/product')->with($success_add);
            }
          
        }
        // if(request()->button_action == 'insert') {
        //     $success_add =  'Product added';
        // }
        // if(request()->button_action == 'update') {
        //     $success_add =  'Update added';
        // }
        $output = [
            'error' => $error_arr,
            'success' => $success_add
        ];   
        return json_encode($output);
    }

    public function getViewPost(Request $request){
        $data = [
            'action' =>$request->action,
            'id' => $request->id,
            'title' => $request->title
        ];
        // json_encode($data);
        // return $data;
        // return 1;
        return view('layouts.postproduct', compact('data'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);  
        return response()->json([
            'product' => $product
        ]);
    }



    public function delete($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        
        $output = [
            'success' => 'Product deleted'
        ];

        return json_encode($output);
    }

 
}
