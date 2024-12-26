<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Resources;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Pest\Support\Closure;

class ProductController extends Controller
{
    public function index()
    {
        $Product = Product::latest()->get();

        return new Resources(true, 'List data Product: ', $Product);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:0',
            'bought' => 'required|numeric|min:0',
            'year' => 'required|numeric|min:1900|max:' . date('Y'),
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $image = $request->file('image');
        $image->storeAs('public/Product', $image->hashName());

        $product = Product::create([
            'name' => $request->name,
            'brand' => $request->brand,
            'category' => $request->category,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'bought' => $request->bought,
            'year' => $request->year,
            'image' => $image->hashName(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product added successfully',
            'data' => $product,
        ], 201);
    }


    public function show($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
            ], 404);
        }

        return new Resources(true, 'Detail barang', $product);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:0',
            'bought' => 'required|numeric|min:0',
            'year' => 'required|numeric|min:1900|max:' . date('Y'),
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
            ], 404);
        }

        $data = $request->only([
            'name',
            'brand',
            'category',
            'description',
            'price',
            'stock',
            'bought',
            'year'
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($product->image) {
                Storage::delete('public/Product/' . basename($product->image));
            }

            // Simpan gambar baru
            $image = $request->file('image');
            $image->storeAs('public/Product', $image->hashName());
            $data['image'] = $image->hashName();
        }

        $product->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'data' => $product,
        ], 200);
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
            ], 404);
        }

        if ($product->image) {
            Storage::delete('public/Product/' . basename($product->image));
            // dd('File dihapus');
        }

        $product->delete();

        return new Resources(true, 'Product berhasil dihapus', null);
    }

    public function home(Request $request)
    {
        $request->validate([
            'sort_by' => 'nullable|in:year,bought',
            'order' => 'nullable|in:asc,desc',   
        ]);

        $sortBy = $request->get('sort_by', 'year'); 
        $order = $request->get('order', 'desc');

        $query = Product::select('id','name', 'image', 'stock', 'bought', 'year', 'price');

        if ($sortBy == 'year') {
            $query->orderBy('year', $order);
        } elseif ($sortBy == 'bought') {
            $query->orderBy('bought', $order);
        }

        $products = $query->paginate(5);

        return new Resources(true, 'List data Product: ', $products);
    }

    public function catalog(Request $request)
    {
        $request->validate([
            'sort_by' => 'nullable|in:year,bought', 
            'order' => 'nullable|in:asc,desc',      
        ]);

        $sortBy = $request->get('sort_by', 'year'); 
        $order = $request->get('order', 'desc');     

        $query = Product::select('id','name', 'image', 'stock', 'bought', 'year', 'price');

        if ($sortBy == 'year') {
            $query->orderBy('year', $order);
        } elseif ($sortBy == 'bought') {
            $query->orderBy('bought', $order);
        }

        $products = $query;

        return new Resources(true, 'List data Product: ', $products);
    }
}
