<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;
use App\Http\Requests\Admin\CreateProductRequest;
use App\Http\Requests\Admin\EditProductRequest;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = $request->only('category_id', 'q');
        $products = Product::select('*');
        if (isset($filter['category_id'])) {
            $products->where('category_id', $filter['category_id']);
        }
        if (isset($filter['q'])) {
            $products->where('title', 'like', '%'.$filter['q'].'%');
        }
        $products = $products->latest()->paginate(20)->withQueryString();
        $categories = Category::all();

        return view('admin.product.index', [
            'products' => $products,
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view('admin.product.create', [
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductRequest $request)
    {
        $data = $request->validated();

        if ($request->has('thumbnail')) {
            $thumbnailPath = 'storage/'.$request->file('thumbnail')->store('products', 'public');
        } else {
            $thumbnailPath = null;
        }

        $product = new Product;
        $product->title = $data['title'];
        $product->slug = Str::slug($data['title']);
        $product->price = $data['price'];
        $product->cost = $data['cost'];
        $product->thumbnail_path = $thumbnailPath;
        $product->description = $data['description'];
        $product->category_id = $data['category_id'];
        $product->is_pinned = (bool) $data['is_pinned'];

        if ($product->is_pinned) {
            Product::where('is_pinned', 1)->update([
                'is_pinned' => 0
            ]);
        }

        $product->save();

        return back()->with('message', 'Tạo sản phẩm thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::all();
        $product = Product::findOrFail($id);

        return view('admin.product.edit', [
            'categories' => $categories,
            'product' => $product,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditProductRequest $request, $id)
    {
        $data = $request->validated();
        $product = Product::findOrFail($id);

        if ($request->has('thumbnail')) {
            Storage::disk('public')->delete($product->thumbnail_path);
            $thumbnailPath = 'storage/'.$request->file('thumbnail')->store('products', 'public');
        } else {
            $thumbnailPath = $product->thumbnail_path;
        }

        $product->title = $data['title'];
        $product->slug = Str::slug($data['title']);
        $product->category_id = $data['category_id'];
        $product->price = $data['price'];
        $product->cost = $data['cost'];
        $product->thumbnail_path = $thumbnailPath;
        $product->description = $data['description'];
        $product->is_pinned = $data['is_pinned'];

        if ($product->is_pinned) {
            Product::where('is_pinned', 1)->update([
                'is_pinned' => 0
            ]);
        }

        $product->save();
        return back()->with('message', 'Sửa sản phẩm thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products.index');
    }
}
