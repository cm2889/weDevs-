<?php

namespace App\Http\Controllers\Api;

use DB;
use Image;
use App\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProdcutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product=DB::table('products')
            ->select('products.*')
            ->orderBy('products.id','DESC')
            ->get();
        return response()->json($product);
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_title' => 'required',
            'product_description' => 'required',
            'product_price' => 'required',

        ]);

        if($request->photo){
            $position = strpos($request->photo, ';');
            $sub=substr($request->photo, 0 ,$position);
            $ext=explode('/', $sub)[1];
            $name=time().".".$ext;
            $img=Image::make($request->photo)->resize(240,200);
            $upload_path='backend/product/';
            $image_url=$upload_path.$name;
            $img->save($image_url);

            $product = new Product;
            $product->product_title = $request->product_title;
            $product->product_description = $request->product_description;
            $product->product_price = $request->product_price;
            $product->photo =  $image_url;
            $product->save();
        }else{
            $product = new Product;
            $product->product_title = $request->product_title;
            $product->product_description = $request->product_description;
            $product->product_price = $request->product_price;
            $product->save();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product=DB::table('products')->where('id',$id)->first();
        return response()->json($product);
    }



    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'product_title' => 'required',
            'product_description' => 'required',
            'product_price' => 'required',
        ]);

        $data=array();
        $data['product_title']=$request->product_title;
        $data['product_description']=$request->product_description;
        $data['product_price']=$request->product_price;

        $photo=$request->newphoto;
        if ($photo) {
            $position = strpos($photo, ';');
            $sub=substr($photo, 0 ,$position);
            $ext=explode('/', $sub)[1];
            $name=time().".".$ext;
            $photo=Image::make($photo)->resize(240,200);
            $upload_path='backend/product/';
            $image_url=$upload_path.$name;
            $success=$photo->save($image_url);
            if  ($success) {
                $data['photo']=$image_url;
                $photo=DB::table('products')->where('id',$id)->first();
                $image_path = $photo->photo;
                $done=unlink($image_path);
                $user=DB::table('products')->where('id',$id)->update($data);
            }
        }else{
            $oldlogo=$request->photo;
            $data['photo']=$oldlogo;
            DB::table('products')->where('id',$id)->update($data);

        }
    }


    public function destroy($id)
    {
        $product=DB::table('products')->where('id',$id)->first();
        $photo=$product->photo;
        if ($photo) {
            unlink($photo);
            DB::table('products')->where('id',$id)->delete();
        }else{
            DB::table('products')->where('id',$id)->delete();
        }
    }
}
