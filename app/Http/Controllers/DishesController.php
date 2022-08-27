<?php

namespace App\Http\Controllers;

use App\Http\Requests\DishCreateRequest;
use App\Models\Category;
use App\Models\Dish;
use App\Models\Order;
use Illuminate\Http\Request;

class DishesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dishes = Dish::all();
        return view('kitchen.dish',compact('dishes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Category::all();
        // dd($data);
        return view('kitchen.dish_create',compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DishCreateRequest $request)
    {
        $dish = new Dish();
        $dish->name = $request->name;
        $dish->category_id = $request->category;

        //upload image
        $img_name = date('YmdHis') . "." . request()->dish_image->getClientOriginalExtension();
        //store public name with photo extension
        request()->dish_image->move(public_path('images'),$img_name);

        $dish->image = $img_name;
        $dish->save();

        return redirect('dish')->with('message','Dish successfully created to database.!');
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
    public function edit(Dish $dish)
    {
        $data = Category::all();
        // dd($data);
        return view('kitchen.dish_edit',compact('dish','data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dish $dish)
    {
        request()->validate([
            'name' => 'required',
            'category' => 'required',
        ]);

        $dish->name = $request->name;
        $dish->category_id = $request->category;

        if($request->dish_image){
            $img_name = date('YmdHis') . "." . request()->dish_image->getClientOriginalExtension();
            //store public name with photo extension
            request()->dish_image->move(public_path('images'),$img_name);
            $dish->image = $img_name;
        }

        $dish->save();
        return redirect('dish')->with('update','Dish updated successfylly.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dish $dish)
    {
        $dish->delete();
        return redirect('dish')->with('update','Dish Deleted successfully.');
    }

    /**
     * Change route list the specified resource from url.
     *
     * @return \Illuminate\Http\Response
     */
    public function order()
    {
        $rawStatus = config('res.order_status');
        $status = array_flip($rawStatus);
        $orders = Order::whereIn('status',[1,2])->get();
        return view('kitchen.order',compact('orders','status'));
    }

    public function approve(Order $order)
    {
        $order->status = config('res.order_status.processing');
        $order->save();

        return redirect('order')->with('message','Approved successfully.');
    }

    public function cancel(Order $order)
    {
        $order->status = config('res.order_status.cancel');
        $order->save();

        return redirect('order')->with('message','Canceled successfully.');
    }

    public function ready(Order $order)
    {
        $order->status = config('res.order_status.ready');
        $order->save();

        return redirect('/')->with('message','Order is Ready.');
    }
}
