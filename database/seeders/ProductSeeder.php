<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('products')->insert([
            [
                'name' => 'Moto razer',
                'price' => '300',
                'category' => 'mobile',
                'description' => '智慧型手機，有256GB',
                'gallery' => 'https://axiang.cc/wp-content/uploads/2014/q3/20190205181539_78.jpg',
            ],
            [
                'name' => '小米',
                'price' => '400',
                'category' => 'mobile',
                'description' => '智慧型手機，有64GB',
                'gallery' => 'https://axiang.cc/wp-content/uploads/2014/q3/20190108175517_80.jpg',
            ],
            [
                'name' => 'Drawing Tablet',
                'price' => '750',
                'category' => 'tablet ',
                'description' => '智慧型平板，有256GB',
                'gallery' => 'https://a.rimg.com.tw/s9/ebay/847/41b/qhby-8%40ebay/a/87/13/4a27a2d1ef57f3ae6af311adb119cdb4_30203414853395_m.jpg',
            ],
            [
                'name' => 'KM-55X9000H',
                'price' => '850',
                'category' => 'tv',
                'description' => '智慧型電視',
                'gallery' => 'https://img.ruten.com.tw/s2/c/90/a2/22031995215010_815.jpg',
            ],
            [
                'name' => 'MATE X2',
                'price' => '500',
                'category' => 'mobile',
                'description' => '智慧型手機，有256GB',
                'gallery' => 'https://axiang.cc/wp-content/uploads/2020/10/20201015041919_68.jpg',
            ]
        ]);
    }
}
