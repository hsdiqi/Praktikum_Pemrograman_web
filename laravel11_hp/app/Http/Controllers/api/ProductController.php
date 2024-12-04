<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\allResource;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class ProductController extends Controller
{
    public function index()
    {
        $products = Products::latest()->paginate(5);

        return new allResource(true, 'List data products: ', $products);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'stok' => 'required',
            'brand' => 'required',
            'category' => 'required',
            'bought' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $image = $request->file('image');
        $image->storeAs('public/products', $image->hashName());

        $product = Products::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $image->hashName(),
            'stok' => $request->stok,
            'brand' => $request->brand,
            'category' => $request->category,
            'bought' => $request->bought
        ]);

        return new allResource(true, 'product baru ditambahkan', $product);
    }

    public function show($id)
    {
        $product = Products::find($id);

        return new allResource(true, 'Detail barang', $product);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'stok' => 'required',
            'brand' => 'required',
            'category' => 'required',
            'bought' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $product = Products::find($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/products/' . basename($product->image));

            Storage::delete('public/products/' . basename($product->image));

            $product->update([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'image' => $image->hashName(),
                'stok' => $request->stok,
                'brand' => $request->brand,
                'category' => $request->category,
                'bought' => $request->bought
            ]);
        } else {
            $product->update([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'stok' => $request->stok,
                'brand' => $request->brand,
                'category' => $request->category,
                'bought' => $request->bought
            ]);
        }

        return new allResource(true, 'Product di update', $product);
    }
    public function destroy($id){
        $product = Products::find($id);
        Storage::delete('public/products/' . basename($product->image));

        $product->delete();

        return new allResource(true, 'Product berhasil dihapus', null);
    }

}
