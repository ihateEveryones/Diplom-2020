<?php


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use  App\Notifications\InvoicePaid;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes(['verify' => true]);
Route::get('/', function () {





    $topcategories = DB::table('categories')->get();
    $products = DB::table('products')->get();
   /* if (!Session::has('id'))
    {
        DB::table('basket')->insert(['id_basket'=>0,'count_product'=>0,'id_product'=>-1,'total_price'=>0,'id_user'=>0]);
        $id=DB::table('basket')->where('id_product','=','-1')->select('id')->get();
        Session::put('id',$id[0]->id-1);
        DB::table('basket')->where('id_product', '=', -1)->delete();

    }*/
    return view('/main',compact('topcategories','products'));
});

/*Route::get('/', function () {
    $topcategories = DB::table('categories')->get();
    $products = DB::table('products')->get();

        DB::table('orders')->insert(['id_order'=>0,'id_product'=>-1,'orders_price'=>0,'id_user'=>0]);
        $id=DB::table('orders')->where('id_product','=','-1')->select('id')->get();
        Session::put('id_orders',$id[0]->id-1);
        DB::table('orders')->where('id_product', '=', -1)->delete();


    return view('/main',compact('topcategories','products'));
});*/
Route::get('/order', 'AllController@order');
Route::get('/afterorder', 'AllController@afterorder');
Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');

Route::get('/main', 'AllController@mains');

Route::get('/settingsprofile', 'AllController@settings');
Route::get('/top', 'AllController@top');
Route::get('/search', 'AllController@search');
Route::get('/searchFilter', 'AllController@searchFilter');
Route::get('/footer', 'AllController@footer');
Route::get('/test', 'AllController@test');
/*Route::get('/product', 'HomeController@product');*/
Route::get('/orderbasket', 'AllController@orderbasket');
Route::get('basket+', 'AllController@plus');
Route::get('/admin', 'AllController@admin');
Route::post('/addproduct', 'AllController@addproduct');
Route::get('/addproduct', 'AllController@addproduct');
Route::get('/addparameters', 'AllController@addparameters');
Route::get('/giveorder', 'AllController@giveorders');
Route::get('/orders', 'AllController@orders');
Route::get('basket-', 'AllController@minus');
Route::get('ordersuser', 'AllController@ordersuser');
Route::get('basketdelete', 'AllController@delete');
Route::get('products/id_categories={id_categories}', 'AllController@products')->name('products');
Route::get('filters', 'AllController@filters');
Route::get('/buy', 'AllController@buy');
Route::post('/home', 'AllController@avatars');
Route::get('/basket/emailbasket={emailbasket}', 'AllController@basket');
Route::get('product/id_product={id_product}', 'AllController@product');



