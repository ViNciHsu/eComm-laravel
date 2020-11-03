<?php

namespace App\Http\Controllers;

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
}
