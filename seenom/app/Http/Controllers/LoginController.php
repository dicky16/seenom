<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
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

    public function login()
    {
      return view('admin/login');
    }

    public function logout(Request $request)
    {
      $request->session()->flush();
      return view('admin/login');
    }

    public function cekLogin(Request $request)
    {
      // $request->session()->put('key', 'ok');
      // dd($request->session()->get('key'));
      $this->validate($request, [
        'username' => 'required',
        'password' => 'required'
      ]);

      $username = $request->input('username');
      $password = $request->input('password');

      $user = User::where('username', $username)->first();

      if(!$user) {
        dd('salah');
      }

      if(Hash::check($password, $user->password)) {
        $request->session()->put('izin', 'izin');
        return redirect('admin');
      } else {
        $request->session()->put('izin', 'tidak');
        return redirect('admin/login');
      }
    }
}
