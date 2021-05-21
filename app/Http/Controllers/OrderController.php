<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\UserOrderRequest;
use App\Models\Order;

class OrderController extends Controller
{
    public function addToCart(Request $request)
    {
        $productId = $request->query('product_id');
        $size = $request->query('size');

        if (Product::where('id', $productId)->doesntExist()) {
            abort(404);
        }

        $added = false;
        if (! session('cart')) {
            session(['cart' => []]);
        }

        $cart = session('cart');

        foreach ($cart as $key => $item) {
            if ($item['product_id'] == $productId && $item['size'] == $size) {
                $cart[$key]['qty'] = $cart[$key]['qty'] + 1;
                $added = true;
                break;
            }
        }

        if (! $added) {
            array_push($cart, [
                'product_id' => $productId,
                'size' => $size,
                'qty' => 1,
            ]);
        }

        session(['cart' => $cart]);

        if ($request->query('redirect_to_cart')) {
            return redirect()->route('cart');
        } else {
            return back()->with('just_add_to_cart', true);
        }
    }

    public function removeToCart(Request $request)
    {
        $productId = $request->query('product_id');
        $size = $request->query('size');

        if (Product::where('id', $productId)->doesntExist()) {
            abort(404);
        }

        $cart = session('cart');

        foreach ($cart as $key => $item) {
            if ($item['product_id'] == $productId && $item['size'] == $size) {
                unset($cart[$key]);
                break;
            }
        }

        session(['cart' => $cart]);

        return redirect()->route('cart');
    }

    public function updateCart(Request $request)
    {
        $productId = $request->query('product_id');
        $size = $request->query('size');
        $action = $request->query('action');

        if (Product::where('id', $productId)->doesntExist() 
        || ($action != 'plus' && $action != 'minus')) {
            abort(404);
        }

        $cart = session('cart');

        foreach ($cart as $key => $item) {
            if ($item['product_id'] == $productId && $item['size'] == $size) {
                if ($action == 'plus') {
                    $cart[$key]['qty'] = $cart[$key]['qty'] + 1;
                } else {
                    $cart[$key]['qty'] = $cart[$key]['qty'] - 1;
                }

                if ($cart[$key]['qty'] == 0) {
                    unset($cart[$key]);
                }
                break;
            }
        }

        session(['cart' => $cart]);

        return redirect()->route('cart');
    }

    public function order(UserOrderRequest $request)
    {
        $data = $request->validated();
        $cart = session('cart');
        
        // Bill
        $bill = 0;
        foreach ($cart as $key => $item) {
            $cart[$key]['product'] = Product::where('id', $item['product_id'])->first();
            $bill += $item['qty'] * $cart[$key]['product']->price;
        }
        $data['bill'] = $bill;

        $code = '';
        $numbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8',  '9'];
        for ($i = 1; $i <= 6; $i++) {
            $code .= array_rand($numbers);
        }
        $data['code'] = 'FLP-'.$code;

        // User
        $data['user_id'] = auth()->check() ? auth()->user()->id : null;

        $order = Order::create($data);
        foreach ($cart as $key => $item) {
            $product = $item['product'];
            $order->items()->create([
                'product_id' => $item['product_id'],
                'title' => $product->title,
                'thumbnail' => base64_encode(file_get_contents(
                    $product->thumbnail_path ? public_path($product->thumbnail_path) : public_path('images/no-thumbnail.png')
                )),
                'size' => $item['size'],
                'price' => $product->price,
                'qty' => $item['qty'],
            ]);
        }

        session(['cart' => []]);

        return back()->with('just_payment', true);
    }

    public function cancel(Request $requets, $order)
    {
        $order = Order::findOrFail($order);

        if ($order->status != 'pending') {
            abort(403);
        }

        $order->status = 'cancel';
        $order->save();

        return back();
    }
}
