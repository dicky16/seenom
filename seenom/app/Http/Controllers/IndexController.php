<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
      // $count = DB::table('count_views')
      // ->value('views');
      // $newCount = $count + 1;
      // DB::table('count_views')
      // ->where('id', 1)
      // ->update(['views' => $newCount]);
      // $ipaddress = $_SERVER['REMOTE_ADDR'];
      // $ip = DB::table('uniq_visitor')->where('ip', $ipaddress)->value('ip');
      // if(!$ip) {
      //   DB::table('uniq_visitor')->insert([
      //     'ip' => $ipaddress
      //   ]);
      // }
      //
      // $uniqVisitor = DB::table('uniq_visitor')->count('id');

      return view('index');
    }

}
