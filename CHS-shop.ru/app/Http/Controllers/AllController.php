<?php


namespace App\Http\Controllers;


use App\Mail\OrderMail;
use DateInterval;
use DateTime;
use Illuminate\Support\Arr;
use  App\Http\Basket;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Input;
use Auth;
use cijic\phpMorphy\Morphy;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Exception;

class AllController extends Controller
{


    public function update()
    {
        return view('products');
    }

    public function basket()
    {
        $status = DB::table('orders')->select('status')->get();
        $countorders = DB::table('users')->select('count_orders')->get();
        $topcategories = DB::table('categories')->get();
        $products = DB::table('products')->get();
        return view('basket', compact('topcategories', 'products', 'countorders', 'status'));
    }

    public function plus(Request $request)
    {
        $id_product = $request->input('id_product');
        $array = Session::get('basket');
        $array[$id_product]->count = $array[$id_product]->count + 1;
        return $this->basket();
    }

    public function minus(Request $request)
    {
        $id_product = $request->input('id_product');
        $array = Session::get('basket');
        if ($array[$id_product]->count > 1) {

            $array[$id_product]->count = $array[$id_product]->count - 1;
        }
        return $this->basket();
    }


    public function delete(Request $request)
    {
        $id_product = $request->input('id_product');

        $array = Session::get('basket');

        array_splice($array, $id_product, 1);
        Session::remove('basket');

        Session::put('basket', $array);


        return $this->basket();
    }

    public function top()
    {

        $topcategories = DB::table('categories')->get();
        $products = DB::table('products')->get();

        return view('top', compact('topcategories'));
    }

    public function products(Request $request, $id_categories)
    {
        DB::table('orders')->insert(['count_product' => 0, 'id_order' => 0, 'id_product' => -1, 'orders_price' => 0, 'id_user' => 0]);
        $id = DB::table('orders')->where('id_product', '=', '-1')->select('id')->get();
        Session::put('id_orders', $id[0]->id - 1);
        DB::table('orders')->where('id_product', '=', -1)->delete();

        $topcategories = DB::table('categories')->get();
        $minprice = DB::table('products')->where([
            ['id_categories', '=', $id_categories],
            ['id_product', '!=', -1],])->min('price');
        $maxprice = DB::table('products')->where([
            ['id_categories', '=', $id_categories],
            ['id_product', '!=', -1],])->max('price');
        $products = DB::table('products')->where([
            ['id_categories', '=', $id_categories],
            ['id_product', '!=', -1],
        ])->paginate(5);
        $vendors = DB::table('products')->distinct()
            ->where('id_categories', '=', $id_categories)
            ->groupBy('vendors')
            ->get();
        echo $request->input('id_product');
        Session::put('minprice', $minprice);
        Session::put('maxprice', $maxprice);

        Session::put('id_categories', $id_categories);
        return view('products', compact('products', 'topcategories', 'vendors', 'minprice', 'maxprice'));
    }

    public function search(Request $request)
    {
        $words = $request->input('search');

        $keywords = mb_convert_case($words, MB_CASE_UPPER, "UTF-8");
        Session::put('words', $words);
        $vendors = DB::table('products')->distinct()
            ->whereRaw("MATCH(name)AGAINST('$keywords' IN boolean MODE)")
            ->groupBy('vendors')
            ->get();

        $minprice = DB::table('products')
            ->whereRaw("MATCH(name)AGAINST('$keywords' IN boolean MODE) and id_product!=-1 ")
            ->min('price');
        $maxprice = DB::table('products')
            ->whereRaw("MATCH(name)AGAINST('$keywords' IN boolean MODE) and id_product!=-1 ")
            ->max('price');

        $products = DB::table('products')
            ->whereRaw("MATCH(name)AGAINST('$keywords' IN boolean MODE) ")
            ->paginate(5);

        $products->items();


        $topcategories = DB::table('categories')->get();

        return view('search', compact('topcategories', 'vendors', 'products', 'maxprice', 'minprice'));

    }

    public function searchFilter(Request $request)
    {

        $topcategories = DB::table('categories')->get();

        $words = $request->input('search');

        $keywords = mb_convert_case($words, MB_CASE_UPPER, "UTF-8");

        $vendors = DB::table('products')->distinct()
            ->whereRaw("MATCH(name)AGAINST('$keywords' IN boolean MODE) and id_product!=-1 ")
            /*  ->where('id_categories', '=', Session::get('id_categories'))*/
            ->groupBy('vendors')
            ->get();


        $products = DB::table('products')
            ->whereRaw("MATCH(name)AGAINST('$keywords' IN boolean MODE) and id_product!=-1 ")
            ->paginate(5);
        $filter = $request->input('filter');
        $pricefrom = $request->input('price');
        $priceup = $request->input('price1');
        $asc = $request->input('asc');
        $request->input('desc');

        /*        if ($request->has('asc')) {
                    $products = DB::table('products')
                        ->where([
                            ['id_categories', '=', Session::get('id_categories')],
                            ['id_product', '!=', -1],
                        ])
                        ->orderBy('price', 'asc')
                        ->paginate(5);
                }

                if ($request->has('desc')) {
                    $products = DB::table('products')
                        ->where([
                            ['id_categories', '=', Session::get('id_categories')],
                            ['id_product', '!=', -1],
                        ])
                        ->orderBy('price', 'desc')
                        ->paginate(5);
                }*/

        $search = array();
        foreach ($vendors as $vendor) {

            foreach ($request->input() as $requestVendor) {


                if ($vendor->vendors == $requestVendor) {

                    array_push($search, $vendor->vendors);

                    break;
                }
            }
        }

        /* $minprice = DB::table('products')->where([
             ['id_categories', '=', Session::get('id_categories')],
             ['id_product', '!=', -1],])->min('price');
         $maxprice = DB::table('products')->where([
             ['id_categories', '=', Session::get('id_categories')],
             ['id_product', '!=', -1],])->max('price');*/
        $minprice = DB::table('products')
            ->whereRaw("MATCH(name)AGAINST('$keywords' IN boolean MODE) and id_product!=-1 ")
            ->min('price');
        $maxprice = DB::table('products')
            ->whereRaw("MATCH(name)AGAINST('$keywords' IN boolean MODE) and id_product!=-1 ")
            ->max('price');
        if ($search != null) {
            $minprice = DB::table('products')
                ->whereRaw("MATCH(name)AGAINST('$keywords' IN boolean MODE) and id_product!=-1 ")
                ->whereIn('vendors', $search)
                ->min('price');
            $maxprice = DB::table('products')
                ->whereRaw("MATCH(name)AGAINST('$keywords' IN boolean MODE) and id_product!=-1 ")
                ->whereIn('vendors', $search)
                ->max('price');
        }

        if (isset($words) && $search != null && isset($priceup) && isset($pricefrom)) {

            $products = DB::table('products')
                ->where([

                    ['id_product', '!=', -1],
                ])
                ->whereRaw("MATCH(name)AGAINST('$keywords' IN boolean MODE) ")
                ->whereIn('vendors', $search)
                ->whereBetween('price', [$pricefrom, $priceup])
                ->paginate(5);

        } else
            if ($search != null && isset($priceup) && isset($pricefrom)) {
                $products = DB::table('products')
                    ->where([

                        ['id_product', '!=', -1],
                    ])
                    ->whereIn('vendors', $search)
                    ->whereBetween('price', [$pricefrom, $priceup])
                    ->paginate(5);
            } else
                if ($search == null && isset($priceup) && isset($pricefrom)) {
                    $products = DB::table('products')
                        ->where([

                            ['id_product', '!=', -1],
                        ])
                        ->whereBetween('price', [$pricefrom, $priceup])
                        ->paginate(5);
                } else
                    if ($search == null && isset($priceup) && !isset($pricefrom)) {
                        $products = DB::table('products')
                            ->where([

                                ['id_product', '!=', -1],
                            ])
                            ->whereBetween('price', [$minprice, $priceup])
                            ->paginate(5);
                    } else
                        if ($search == null && !isset($priceup) && isset($pricefrom)) {
                            $products = DB::table('products')
                                ->where([

                                    ['id_product', '!=', -1],
                                ])
                                ->whereBetween('price', [$pricefrom, $maxprice])
                                ->paginate(5);
                        } else
                            if ($search != null && !isset($priceup) && isset($pricefrom)) {
                                $products = DB::table('products')
                                    ->where([

                                        ['id_product', '!=', -1],
                                    ])
                                    ->whereBetween('price', [$pricefrom, $maxprice])
                                    ->whereIn('vendors', $search)
                                    ->paginate(5);
                            } else
                                if ($search != null && isset($priceup) && !isset($pricefrom)) {
                                    $products = DB::table('products')
                                        ->where([

                                            ['id_product', '!=', -1],
                                        ])
                                        ->whereBetween('price', [$minprice, $priceup])
                                        ->whereIn('vendors', $search)
                                        ->paginate(5);
                                } else
                                    if ($search != null && !isset($priceup) && !isset($pricefrom)) {
                                        $products = DB::table('products')
                                            ->where([

                                                ['id_product', '!=', -1],
                                            ])
                                            ->whereIn('vendors', $search)
                                            ->whereRaw("MATCH(name)AGAINST('$keywords' IN boolean MODE) ")
                                            ->paginate(5);

                                    }

        return view('search', compact('products', 'topcategories', 'vendors', 'minprice', 'maxprice'));
    }

    public function product($id_product)
    {
        $topcategories = DB::table('categories')->get();
        $products = DB::table('products')
            ->where('id_product', '=', $id_product)->get();
        $parameters = DB::table('products')
            ->join('categories', 'categories.id_categories', '=', 'products.id_categories')
            ->join('parameters', 'products.id_categories', '=', 'categories.id_categories')
            ->join('product_parameters', function ($join) {
                $join->On('parameters.id_parameters', '=', 'product_parameters.id_parameters')->On('products.id_product', '=', 'product_parameters.id_product');
            })
            ->select('categories.id_categories', 'products.name', 'parameters.parameter_name', 'parameters.parameter_value')
            ->where('products.id_product', '=', $id_product)
            ->get();

        Session::put('id_product', $id_product);
        return view('product', compact('products', 'parameters', 'topcategories'));
    }


    public function mains()
    {

        DB::table('orders')->insert(['count_product' => 0, 'id_order' => 0, 'id_product' => -1, 'orders_price' => 0, 'id_user' => 0]);
        $id = DB::table('orders')->where('id_product', '=', '-1')->select('id')->get();
        Session::put('id_orders', $id[0]->id - 1);
        DB::table('orders')->where('id_product', '=', -1)->delete();

        if (!Session::has('basket')) {
            $array = array();
            Session::put('basket', $array);
        }
        $status = DB::table('orders')->select('status')->get();
        /*$emailbasket = DB::table('basket')
            ->select('id_user')
            ->get();*/

        /*if (!$emailbasket->isEmpty()) {
            $email = DB::table('basket')
                ->select('id_user', 'count_product', 'id_product')
                ->where('id_user', '=', $emailbasket[0]->id_user)
                ->get();
        } else {
            $email = DB::table('basket')
                ->select('id_user')
                ->where('id_user', '=', '0')
                ->get();
        }*/


        $topcategories = DB::table('categories')->get();
        $products = DB::table('products')->get();
        return view('main', compact('topcategories', 'products', 'status'));

    }

    public function buy(Request $request)
    {

        $array = Session::get('basket');
        $basket = new Basket();
        $basket->idProduct = $request->input('id_product');

        $basket->price = $request->input('price');

        if (isset(Auth::user()->email)) {
            $basket->idUser = Auth::user()->id;
        } else {
            $basket->idUser = 1;
        }
        $basket->url = $request->input('url');

        $basket->name = $request->input('name');

        $array[count($array)] = $basket;

        Session::remove('basket');
        Session::put('basket', $array);


        return Redirect::back();

    }

    public function exit()
    {
        Session::put('exit', '0');
        echo '<script>location.replace("main")</script>';
    }

    public function admin()
    {
        $topcategories = DB::table('categories')->get();
        return view('admin', compact('topcategories'));
    }

    public function avatars(Request $request)
    {

        if ($request->file('avatars') == null) {
            $file = Auth::user()->avatars;
        } else {
            $file = $request->file('avatars')->store('avatars', 'public');
        }


        if ($request->input('name') != null && $request->input('email') != null && $request->input('phone') != null) {

            DB::table('users')
                ->where('id', Auth::user()->id)
                ->update(['avatars' => $file, 'name' => $request->input('name'), 'phone' => $request->input('phone'), 'email' => $request->input('email')]);

        }

        return Redirect::back();
        /*return view('/home');*/
    }

    public function addproduct(Request $request)
    {
        $products = DB::table('products')->get();
        $vendor = DB::table('products')->select('vendors')->distinct()->get();

        $topcategories = DB::table('categories')->get();
        $name = $request->input('name');
        $id_categories = $request->input('id_categories');
        $vendors = $request->input('vendors');
        $price = $request->input('price');
        $Shortdescription = $request->input('short_description');
        $description = $request->input('description');
        $count = $request->input('count');

        if ($request->file('images') == null) {
            $file = "";
        } else {
            $file = $request->file('images')->store('uploads', 'public');
        }
        if ((isset($name) && !empty($name)) && (isset($id_categories) && !empty($id_categories)) && (isset($vendors) && !empty($vendors)) && (isset($price) && !empty($price))
            && (isset($Shortdescription) && !empty($Shortdescription)) && (isset($description) && !empty($description)) && (isset($count) && !empty($count)) && (isset($file) && !empty($file))) {

            DB::table('products')->insert(
                ['id_categories' => $id_categories, 'vendors' => $vendors, 'name' => $name,
                    'price' => $price, 'url' => $file, 'short_description' => $Shortdescription, 'description' => $description, 'count' => $count]
            );
            echo "Продукт добавлен";

        }
        return view('addproduct', compact('products', 'topcategories', 'vendor'));
    }

    public function addparameters(Request $request)
    {

        $products = DB::table('products')->get();
        $parameters = DB::table('parameters')->get();
        $topcategories = DB::table('categories')->get();
        $id_product = $request->input('id_product');
        $name = $request->input('nameParameters');
        $value = $request->input('valueParameters');

        if ((isset($name) && !empty($name)) && (isset($value) && !empty($value))) {
            $id = DB::table('parameters')->insertGetId(
                ['parameter_name' => $name, 'parameter_value' => $value]
            );

            DB::table('product_parameters')->insert(
                ['id_product' => $id_product, 'id_parameters' => $id]
            );
            echo "Параметер добавлен";
        }

        /* $products_parameters=DB::table('products_parameters')->where()->get();*/
        return view('addparameters', compact('products', 'topcategories', 'parameters'));
    }


    public function orders(Request $request)
    {

        $products = DB::table('products')->get();
        $topcategories = DB::table('categories')->get();
        $orders = DB::table('orders')->paginate(7);
        $delete = $request->input('delete');
        $change=$request->input('change');
        $status=$request->input('status');
        $emailorders = $request->input('email');
        $id_orders = $request->input('id_orders');
        if (isset($delete)) {
            DB::table('orders')->where([
                ['id_order', '=', $id_orders],
                ['email', '=', $emailorders],
            ])->delete();

            echo '<script>location.replace("orders")</script>';

        }
        if(isset($change)){
            DB::table('orders')
                ->where([
                    ['id_order', '=', $id_orders],
                    ['email', '=', $emailorders],
                ])
                ->update(['status' => $status,'reserved_date'=>null]);
            echo '<script>location.replace("orders")</script>';
        }



        return view('orders', compact('products', 'topcategories', 'orders'));
    }

    public function giveorders(Request $request)
    {


        /* $order = $request->input('order');
         $price = $request->input('priceall');
         Session::put('price',$price);
         if (isset($order) && Session::has('basket')) {
             $countorders = DB::table('users')->where('email', '=', Auth::user()->email)->increment('count_orders', 1);
             $products = DB::table('users')->select('count_orders')->where('email', '=', Auth::user()->email)->get('');


             Session::remove('basket');
         }*/
        return $this->basket();
    }

    public function order(Request $request)
    {
        $mail="Exception";
        $order = $request->input('order');
        $phone = $request->input('phone');
        $email = $request->input('email');
        $topcategories = DB::table('categories')->get();
        $products = DB::table('products')->get();
        $orders = DB::table('orders')
            ->join('products', 'orders.id_product', '=', 'products.id_product')
            ->select('products.name', 'orders.orders_price', 'orders.count_product', 'products.price',
                'products.id_product', 'products.url', 'products.count', 'orders.id_user', 'orders.id_order', 'orders.order_date', 'orders.status')
            ->where('id_order', '=', Session::get('id_orders'))
            ->get();

        try {
            Mail::to($email)->send(new OrderMail());

        } catch (Exception $e) {


            return view('orderbasket',compact('mail','topcategories','products'));
        }
        if (isset($order) && Session::has('basket')) {
            $date = new DateTime();
            $date->add(new DateInterval('P3D'));
            $date->format('Y-m-d H:m');
            if (Auth::user() != null) {
                $countorders = DB::table('users')->where('email', '=', Auth::user()->email)->increment('count_orders', 1);
            }


            foreach (Session::get('basket') as $orders) {

                if (Auth::user() != null) {


                    DB::table('orders')->insert(

                        ['count_product' => $orders->count, 'id_order' => Session::get('id_orders'), 'id_user' => $orders->idUser, 'id_product' => $orders->idProduct, 'orders_price' => Session::get('orderPrice')
                            , 'phone' => $phone, 'email' => $email,'reserved_date'=>$date->format('Y-m-d H:m')]
                    );
                    DB::table('products')->where('id_product', '=', $orders->idProduct)->decrement('count', $orders->count);
                } else {
                    DB::table('orders')->insert(

                        ['count_product' => $orders->count, 'id_order' => Session::get('id_orders'), 'id_product' => $orders->idProduct, 'orders_price' => Session::get('orderPrice')
                            , 'phone' => $phone, 'email' => $email,'reserved_date'=>$date->format('Y-m-d H:m')]
                    );

                    DB::table('products')->where('id_product', '=', $orders->idProduct)->decrement('count', $orders->count);
                }

            }








            Session::remove('basket');
            Session::put('basket', []);
        }


        return Redirect::to('afterorder');
    }

    public function orderbasket()
    {

        $topcategories = DB::table('categories')->get();
        $products = DB::table('products')->get();

        return view('orderbasket', compact('topcategories', 'products'));
    }

    public function ordersuser()
    {

        $topcategories = DB::table('categories')->get();
        $ordersUser = DB::table('orders')
            ->join('products', 'orders.id_product', '=', 'products.id_product')
            ->select('products.name', 'orders.orders_price', 'orders.count_product', 'products.price',
                'products.id_product', 'products.url', 'products.count', 'orders.id_user', 'orders.id_order', 'orders.order_date', 'orders.status','orders.reserved_date')
            ->where('orders.id_user', '=', Auth::user()->id)
            ->get();
        $idOrder = DB::table('orders')->select('id_order', 'orders_price')
            ->distinct()
            ->where('orders.id_user', '=', Auth::user()->id)
            ->get();

        return view('ordersuser', compact('topcategories', 'ordersUser', 'idOrder'));
    }

    public function filters(Request $request)
    {
        $topcategories = DB::table('categories')->get();

        $vendors = DB::table('products')->distinct()
            ->where([
                ['id_categories', '=', Session::get('id_categories')],
                ['id_product', '!=', -1],
            ])
            ->groupBy('vendors')
            ->get();


        $products = DB::table('products')->where([
            ['id_categories', '=', Session::get('id_categories')],
            ['id_product', '!=', -1],
        ])->paginate(5);
        $filter = $request->input('filter');
        $pricefrom = $request->input('price');
        $priceup = $request->input('price1');
        $asc = $request->input('asc');
        $request->input('desc');

        if ($request->has('asc')) {
            $products = DB::table('products')
                ->where([
                    ['id_categories', '=', Session::get('id_categories')],
                    ['id_product', '!=', -1],
                ])
                ->orderBy('price', 'asc')
                ->paginate(5);
        }

        if ($request->has('desc')) {
            $products = DB::table('products')
                ->where([
                    ['id_categories', '=', Session::get('id_categories')],
                    ['id_product', '!=', -1],
                ])
                ->orderBy('price', 'desc')
                ->paginate(5);
        }

        $search = array();
        foreach ($vendors as $vendor) {

            foreach ($request->input() as $requestVendor) {

                if ($vendor->vendors == $requestVendor) {

                    array_push($search, $vendor->vendors);

                    break;
                }
            }
        }

        $minprice = DB::table('products')->where([
            ['id_categories', '=', Session::get('id_categories')],
            ['id_product', '!=', -1],])->min('price');
        $maxprice = DB::table('products')->where([
            ['id_categories', '=', Session::get('id_categories')],
            ['id_product', '!=', -1],])->max('price');

        if ($search != null && isset($priceup) && isset($pricefrom)) {
            $products = DB::table('products')
                ->where([
                    ['id_categories', '=', Session::get('id_categories')],
                    ['id_product', '!=', -1],
                ])
                ->whereIn('vendors', $search)
                ->whereBetween('price', [$pricefrom, $priceup])
                ->paginate(5);
        } else
            if ($search == null && isset($priceup) && isset($pricefrom)) {
                $products = DB::table('products')
                    ->where([
                        ['id_categories', '=', Session::get('id_categories')],
                        ['id_product', '!=', -1],
                    ])
                    ->whereBetween('price', [$pricefrom, $priceup])
                    ->paginate(5);
            } else
                if ($search == null && isset($priceup) && !isset($pricefrom)) {
                    $products = DB::table('products')
                        ->where([
                            ['id_categories', '=', Session::get('id_categories')],
                            ['id_product', '!=', -1],
                        ])
                        ->whereBetween('price', [$minprice, $priceup])
                        ->paginate(5);
                } else
                    if ($search == null && !isset($priceup) && isset($pricefrom)) {
                        $products = DB::table('products')
                            ->where([
                                ['id_categories', '=', Session::get('id_categories')],
                                ['id_product', '!=', -1],
                            ])
                            ->whereBetween('price', [$pricefrom, $maxprice])
                            ->paginate(5);
                    } else
                        if ($search != null && !isset($priceup) && isset($pricefrom)) {
                            $products = DB::table('products')
                                ->where([
                                    ['id_categories', '=', Session::get('id_categories')],
                                    ['id_product', '!=', -1],
                                ])
                                ->whereBetween('price', [$pricefrom, $maxprice])
                                ->whereIn('vendors', $search)
                                ->paginate(5);
                        } else
                            if ($search != null && isset($priceup) && !isset($pricefrom)) {
                                $products = DB::table('products')
                                    ->where([
                                        ['id_categories', '=', Session::get('id_categories')],
                                        ['id_product', '!=', -1],
                                    ])
                                    ->whereBetween('price', [$minprice, $priceup])
                                    ->whereIn('vendors', $search)
                                    ->paginate(5);
                            } else
                                if ($search != null && !isset($priceup) && !isset($pricefrom)) {
                                    $products = DB::table('products')
                                        ->where([
                                            ['id_categories', '=', Session::get('id_categories')],
                                            ['id_product', '!=', -1],
                                        ])
                                        ->whereIn('vendors', $search)
                                        ->paginate(5);

                                }


        return view('/products', compact('topcategories', 'products', 'vendors'));
    }

    public function footer()
    {

        return view('footer');
    }

    public function afterorder()
    {
        $topcategories = DB::table('categories')->get();
        $products = DB::table('products')->get();

        $orders = DB::table('orders')
            ->join('products', 'orders.id_product', '=', 'products.id_product')
            ->select('products.name', 'orders.orders_price', 'orders.count_product', 'products.price',
                'products.id_product', 'products.url', 'products.count', 'orders.id_user', 'orders.id_order', 'orders.order_date', 'orders.status')
            ->where('id_order', '=', Session::get('id_orders'))
            ->get();
        return view('afterorder', compact('topcategories', 'products', 'orders'));
    }

    public function settings(Request $request)
    {


        return view('settingsprofile');
    }

    public function test()
    {

        return view('test');
    }

}
