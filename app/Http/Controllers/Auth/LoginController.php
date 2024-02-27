<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        if (auth()->attempt($request->only('email', 'password'))) {

            if (auth()->user()->isCustomer()) {
                return redirect(route('customer.index'));
            }

            return redirect(route('admin.dashboard.index'));
        }

        // if credentials doesn't match, and just return email input
        return back()->withErrors([
            "system" => trans('auth.failed'),
        ])->withInput($request->only('email'));
    }
}
