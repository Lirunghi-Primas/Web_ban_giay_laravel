<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
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
        $filter = $request->only('status', 'q');
        $orders = Order::select('*');
        if (isset($filter['status'])) {
            $orders->where('status', $filter['status']);
        }
        if (isset($filter['q'])) {
            $orders->where('code', 'like', '%'.$filter['q'].'%');
            $orders->orWhere('fullname', 'like', '%'.$filter['q'].'%');
            $orders->orWhere('email', 'like', '%'.$filter['q'].'%');
            $orders->orWhere('phone_number', 'like', '%'.$filter['q'].'%');
            $orders->orWhere('address', 'like', '%'.$filter['q'].'%');
            $orders->orWhere('created_at', 'like', '%'.$filter['q'].'%');
        }
        $orders = $orders->latest()->paginate(20)->withQueryString();

        return view('admin.order.index', [
            'orders' => $orders,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::findOrFail($id);

        return view('admin.order.show', [
            'order' => $order,
            'user' => $order->user,
            'items' => $order->items
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $order = Order::findOrFail($id);

        $order->status = $request->status;
        $order->save();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('admin.orders.index');
    }
}
