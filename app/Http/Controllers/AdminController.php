<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $data = $request->input();
            if (Auth::attempt(['email' => $data['email'], 'password' => $data['password'], 'admin' => '1'])) {
                Session::put('adminSession', $data['email']);
                return redirect()->action('AdminController@dashboard');
            } else {
                return redirect('/admin')->with('flash_message_error', 'Invalid Email or Password');
            }
        }
        return view('admin.admin_login');
    }

    public function dashboard()
    {
//        if (Session::has('adminSession')) {
//            return view('admin.dashboard');
//        } else {
//            return redirect('/admin')->with('flash_message_error', 'Please login to access');
//        }
        return view('admin.dashboard');
    }

    public function setting()
    {
        return view('admin.setting');
    }

    public function checkPassword(Request $request)
    {
        $data = $request->all();
        $current_pwd = $data['current_pwd'];
        $check_pwd = User::where(['admin' => '1'])->first();
        if (Hash::check($current_pwd, $check_pwd->password)) {
            echo 'true'; die;
        } else {
            echo 'false'; die;
        }
    }

    public function updatePassword(Request $request) {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $check_pwd = User::where(['email' => Auth::user()->email])->first();
            $current_pwd = $data['current_pwd'];
            if (Hash::check($current_pwd, $check_pwd->password)) {
                $password = bcrypt($data['new_pwd']);
                User::where('id', '1')->update(['password' => $password]);
                return redirect('/admin/setting')->with('flash_message_success', 'Password updated successfully');
            } else {
                return redirect('/admin/setting')->with('flash_message_error', 'Incorrect current password');
            }
        }
    }

    public function logout()
    {
        Session::flush();
        return redirect('/admin')->with('flash_message_success', 'Logged out Successfully');
    }
}
