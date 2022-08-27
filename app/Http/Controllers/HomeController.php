<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use App\Models\Order;
use App\Models\Table;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $dishes = Dish::orderby('id','desc')->get();
        $tables = Table::all();
        $rawStatus = config('res.order_status');
        $status = array_flip($rawStatus);
        $orders = Order::where('status',4)->get();
        return view('order_form',compact('dishes','tables','orders','status'));
    }

    public function submit(Request $request)
    {
        $orderId = rand();

        $data = array_filter($request->except('_token','table'));
        // dd($request->all());
        foreach ($data as $key => $value) {
            if($value > 1){
                for ($i=0; $i <= $value; $i++) { 
                   $this->saveOrder($orderId,$key,$request);
                }
            }else{
                $this->saveOrder($orderId,$key,$request);              
            }
        }
        
        return redirect('/')->with('message','orders had been submited.');

    }

    public function saveOrder($orderId,$dish_id,$request)
    {
        $order = new Order();
        $order->order_id = $orderId;
        $order->dish_id = $dish_id;
        $order->table_id = $request->table;
        $order->status = config('res.order_status.new');

        $order->save();
    }

    public function serve(Order $order)
    {
        $order->status = config('res.order_status.done');
        $order->save();

        return redirect('/')->with('message','Order was serve to customer.');
    }
}
