<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use App\Http\Requests\StoreOrderRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    public function index ()
    {
        $orders = DB::table('orders')->where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->where('deleted_at',NULL)->paginate(1);
        return view('orders.index', compact('orders'));
    }
    public function create ()
    {
        return view('orders.create');
    }
    public function store (StoreOrderRequest $request)
    {
        Order::create($request->all());
        return redirect()->route('orders.index')->with(['message' => 'Pomyślnie dodano zamówienie']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show ($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit ($id)
    {
        $order = Order::findOrFail($id);
        return view('orders.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreOrderRequest $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update($request->all());
        return redirect()->route('orders.index')->with(['message' => 'Zamówienie zostało pomyślnie edytowane']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy ($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()->route('orders.index')->with(['message' => 'Zamówienie zostało pomyślnie usunięte']);
    }
}

