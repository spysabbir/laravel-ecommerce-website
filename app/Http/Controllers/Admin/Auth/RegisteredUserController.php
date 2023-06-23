<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Validator;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role' => ['required'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'indisposable', 'unique:'.Admin::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'password_confirmation' => ['required', Rules\Password::defaults()],
            'warehouse_id' => ['required'],
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            if ($request->warehouse_id == 'NULL') {
                $warehouse_id = NUll;
            } else {
                $warehouse_id = $request->warehouse_id;
            }

            Admin::insert([
                'role' => $request->role,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'warehouse_id' => $warehouse_id,
                'created_at' => Carbon::now(),
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Account create successfully',
            ]);
        }
    }
}
