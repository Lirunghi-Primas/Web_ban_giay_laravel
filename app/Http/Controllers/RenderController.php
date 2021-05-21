<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;

class RenderController extends Controller
{
    public function showHomePage()
    {
        $pinnedProduct = Product::where('is_pinned', 1)->first();
        $latestProducts = Product::latest()->take(8)->get();
        $bestSellProductIds = OrderItem::select('product_id')->groupBy('product_id')->orderByRaw('SUM(qty) DESC')->take(4)->get()->pluck('product_id')->toArray();
        $bestSellProducts = [];

        $bestSellProducts = array_map(function($productId) {
            return Product::find($productId);
        }, $bestSellProductIds);

        return view('user.home', [
            'pinned_product' => $pinnedProduct,
            'latest_products' => $latestProducts,
            'best_sell_products' => $bestSellProducts,
        ]);
    }

    public function showLoginPage()
    {
        return view('user.login');
    }

    public function showRegisterPage()
    {
        return view('user.register');
    }

    public function showCartPage()
    {
        if (! session('cart')) {
            session(['cart' => []]);
        }

        $cart = session('cart');
        $bill = 0;

        foreach ($cart as $key => $item) {
            $cart[$key]['product'] = Product::where('id', $item['product_id'])->first();
            $bill += $item['qty'] * $cart[$key]['product']->price;
        }

        return view('user.cart', [
            'cart' => $cart,
            'bill' => $bill,
        ]);
    }

    public function showProductDetailPage(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $category = $product->category;
        $relatedProduct = Product::where('category_id', $category->id)->inRandomOrder()->take(8)->get();
        return view('user.product-detail', [
            'product' => $product,
            'category' => $category,
            'related' => $relatedProduct,
        ]);
    }

    public function showProductListPage(Request $request, $slug)
    {
        $filter = $request->only('price', 'category_id');

        $category = Category::where('slug', $slug)->firstOrFail();

        $categories = $category->parents();

        $hasProduct = Product::where('category_id', $category->id)->count();

        $products = Product::select('*');

        // Filter category
        if (isset($filter['category_id']) && Category::where('id', $filter['category_id'])->firstOrFail()) {
            $products->where('category_id', $filter['category_id']);
        } else {
            $products->where(function ($query) use ($category) {
                $query->where('category_id', $category->id);
                $query->orWhereIn('category_id', $category->children()->get()->pluck('id'));
            });

            $hasProduct = $products->count();
        }

        // Filter price
        if (isset($filter['price']) && array_key_exists($filter['price'], config('price_filter'))) {
            $price = explode('-', $filter['price']);
            if (count($price) == 2) {
                $minPrice = (int) $price[0];
                $maxPrice = (int) $price[1];
                $products->whereBetween('price', [$minPrice, $maxPrice]);
            } else {
                $products->where('price', '>=', (int) $price[0]);
            }
        }

        $products = $products->latest()->paginate(18)->withQueryString();

        if ($request->page && $request->page > Product::paginate()->lastPage()) {
            abort(404);
        }

        return view('user.product-list', [
            'category' => $category,
            'products' => $products,
            'has_product' => $hasProduct,
            'categories' => $categories,
        ]);
    }

    public function showAboutUsPage()
    {
        return view('user.about-us');
    }

    public function showPolicyPage()
    {
        return view('user.policy');
    }

    public function showTermOfUsePage()
    {
        return view('user.term-of-use');
    }

    public function showProfilePage()
    {
        $user = auth()->user();
        return view('user.profile', [
            'user' => $user,
        ]);
    }

    public function showOrderPage(Request $request)
    {
        $filter = $request->only('status', 'q');
        $orders = Order::select('*');
        if (isset($filter['status'])) {
            $orders->where('status', $filter['status']);
        }
        if (isset($filter['q'])) {
            $orders->where(function($query) use ($filter) {
                $query->where('code', 'like', '%'.$filter['q'].'%');
                $query->orWhere('fullname', 'like', '%'.$filter['q'].'%');
                $query->orWhere('email', 'like', '%'.$filter['q'].'%');
                $query->orWhere('phone_number', 'like', '%'.$filter['q'].'%');
                $query->orWhere('address', 'like', '%'.$filter['q'].'%');
                $query->orWhere('created_at', 'like', '%'.$filter['q'].'%');
            });
            
        }

        $orders = $orders->where('user_id', auth()->user()->id)->orderBy('id', 'desc')->paginate(20)->withQueryString();

        return view('user.order', [
            'orders' => $orders
        ]);
    }

    public function showOrderDetailPage(Request $request, $order)
    {
        $order = Order::findOrFail($order);

        return view('user.order-detail', [
            'order' => $order,
            'items' => $order->items
        ]);
    }

    public function showSearchPage(Request $request)
    {
        $filter = $request->only('price', 'category_id', 'q');
        $categories = Category::whereNotNull('parent_id')->get();
      
        $products = Product::select('*');

         // Filter keyword
         if (isset($filter['q'])) {
            $products->where('title', 'like', '%'.$filter['q'].'%');
        }

        $hasProduct = $products->count();

        // Filter category
        if (isset($filter['category_id']) && Category::where('id', $filter['category_id'])->firstOrFail()) {
            $products->where('category_id', $filter['category_id']);
        } 

        // Filter price
        if (isset($filter['price']) && array_key_exists($filter['price'], config('price_filter'))) {
            $price = explode('-', $filter['price']);
            if (count($price) == 2) {
                $minPrice = (int) $price[0];
                $maxPrice = (int) $price[1];
                $products->whereBetween('price', [$minPrice, $maxPrice]);
            } else {
                $products->where('price', '>=', (int) $price[0]);
            }
        }

        $products = $products->latest()->paginate(18)->withQueryString();

        if ($request->page && $request->page > Product::paginate()->lastPage()) {
            abort(404);
        }

        return view('user.search', [
            'categories' => $categories,
            'products' => $products,
            'has_product' => $hasProduct,
        ]);
    }

    public function showForgotPasswordPage()
    {
        return view('user.forgot-password');
    }

    public function showResetPasswordPage()
    {
        return view('user.reset-password');
    }
}
