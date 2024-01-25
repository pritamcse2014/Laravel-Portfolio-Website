<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    function loginIndex(){
        return view('Login');
    }

    function onLogin(Request $request){
        $userName = $request->input('userName');
        $userPassword = $request->input('userPassword');
        $countValue = AdminModel::where('admin_username', '=', $userName)->where('admin_password', '=', $userPassword)->count();

        if ($countValue == 1) {
            $request->session()->put('userName', $userName);
            return 1;
        } else {
            return 0;
        }
    }

    function onLogout(Request $request){
        $request->session()->flush();
        return redirect('/login');
    }
}
