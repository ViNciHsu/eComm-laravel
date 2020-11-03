<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Session;

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
        $data = Product::where('name', 'like', '%'.$request->input('query').'%')
            ->get();
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
}
