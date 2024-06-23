<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(RegisterRequest $request)
    {
        DB::transaction(function () use ($request) {
            $customer = Customer::create($request->validated());

            $user = new User($request->validated());
            $user->userable()->associate($customer);
            $user->save();
        });

        return redirect(route('auth.login.index'))->with('success', 'Berhasil membuat akun, silakan login.');
    }
}
