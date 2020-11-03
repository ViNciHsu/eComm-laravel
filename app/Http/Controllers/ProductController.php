<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Session;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    //
    function index()
    {
        $data = Product::all();
        return view('product',['products' => $data]);
    }

    function detail($id)
    {
        $data = Product::find($id);
        return view('detail',['product' => $data]);
    }

    // 搜尋
    function search(Request $request)
    {
        // 開啟紀錄
        DB::connection()->enableQueryLog();
        // 資料庫查詢
        $data = Product::where('name', 'like', '%'.$request->input('query').'%')
            // 增加模糊搜尋
            ->orwhere('price', 'like', '%'.$request->input('query').'%')
            ->get();
        // 印出 SQL 語法
//        dd(DB::getQueryLog());
//        dd($data);
        return view('search',[
            'products' => $data
        ]);
    }

    // 加品項至購物車
    function addToCart(Request $request)
    {
        // 如果有登入
        if($request->session()->has('user'))
        {
            $cart = new Cart;
            $cart->user_id = $request->session()->get('user')['id'];
            $cart->product_id = $request->product_id;
            $cart->save();

            return redirect('/');
        }
        else
        {
            return redirect('/login');
        }

    }

    // 根據 user_id 計算購物車購買數量
    static function cartItem()
    {
        $userId = Session::get('user')['id'];
        return Cart::where('user_id',$userId)->count();
    }

    function cartList()
    {
        $userId = Session::get('user')['id'];
        $products = DB::table('cart')
            ->join('products','cart.product_id','=','products.id')
            ->where('cart.user_id',$userId)
            // 加上 cart.id as cart_id 才能在 cartlist 中取得 cart.id 用來移除購物車商品
            ->select('products.*','cart.id as cart_id')
            ->get();

        return view('cartlist', ['products' => $products]);
    }

    function removeCart($id)
    {
        Cart::destroy($id);
        return redirect('cartlist');
    }

    function orderNow()
    {
        $userId = Session::get('user')['id'];
        $total = $products = DB::table('cart')
            ->join('products','cart.product_id','=','products.id')
            ->where('cart.user_id',$userId)
            // 加上 cart.id as cart_id 才能在 cartlist 中取得 cart.id 用來移除購物車商品
            ->sum('products.price');

        return view('ordernow', ['total' => $total]);
    }

    // 用 post 執行 ordernow 的 submit
    function orderPlace(Request $request)
    {
        $userId = Session::get('user')['id'];
        $allCart = Cart::where('user_id',$userId)->get();
//        dd($allCart);
        foreach ($allCart as $cart)
        {
            $order = new Order;
            $order->product_id = $cart['product_id'];
            $order->user_id = $cart['user_id'];
            $order->status = "pending";
            $order->payment_method = $request->payment;
            $order->payment_status = "pending";
            $order->address = $request->address;
            $order->save();
            Cart::where('user_id',$userId)->delete();
        }
        $request->input();
        return redirect('/');
    }

    function myOrders()
    {
        $userId = Session::get('user')['id'];
        $orders = $products = DB::table('orders')
            ->join('products','orders.product_id','=','products.id')
            ->where('orders.user_id',$userId)
            // 加上 cart.id as cart_id 才能在 cartlist 中取得 cart.id 用來移除購物車商品
            ->get();

        return view('myorders', ['orders' => $orders]);
    }
}
