<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Resources;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function index($id_customer)
    {

        $customerExists = \App\Models\Customer::where('id', $id_customer)->exists();
        if (!$customerExists) {

            return new Resources(false, 'Customer ID not found', null);
        }

        $cartItems = Cart::with('product')
            ->where('customer_id', $id_customer)
            ->get();

        if ($cartItems->isEmpty()) {

            return new Resources(false, 'Cart is empty for this customer', null);
        }
        // Format data agar lebih rapi saat dikembalikan ke frontend
        $cartData = $cartItems->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->product->name,
                'category' => $item->product->category,
                'price' => $item->product->price,
                'stok' => $item->product->stok,
                'image' => $item->product->image,
                'quantity' => $item->quantity,
                'total_price' => $item->product->price * $item->quantity,
            ];
        });


        return new Resources(true, 'List cart items', $cartData);
    }

    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);
        
        Log::info($request->all());
        
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $cart = Cart::where('customer_id', $request->customer_id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($cart) {
            $cart->quantity += $request->quantity;
            $cart->save();
        } else {
            $cart = Cart::create([
                'customer_id' => $request->customer_id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        return new Resources(true, 'Product added to cart', $cart);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $cart = Cart::find($id);
        if (!$cart) {

            return new Resources(false, 'Cart item not found', $cart);
        }

        $cart->update([
            'quantity' => $request->quantity,
        ]);


        return new Resources(true, 'Cart updated successfully', $cart);
    }

    public function destroy($id)
    {
        $cart = Cart::find($id);
        if (!$cart) {

        return new Resources(false, 'Cart item not found', $cart);
        }

        $cart->delete();

        return new Resources(false, 'Cart item deleted', $cart);
    }
}
