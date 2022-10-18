<?php

namespace Ndeblauw\BlueAdmin;

use Auth;
use Session;
use App\Http\Controllers\Controller;

class UserLoginAsController extends Controller
{
    public function loginAs($user)
    {
        $current_user_id = Auth::id();
        if( (int) app()->version() < 8 ) {
            $user = \App\User::findOrFail($user);
        } else {
            $user = \App\Models\User::findOrFail($user);
        }
        if( method_exists($user,'isManager') && $user->isManager()) {
            abort(403, "Het is niet mogelijk om in te loggen alsof je een andere admin bent");
        }
        Auth::login($user);

        Session::put('loginas', $current_user_id);
        return redirect()->route('home');
    }

    public function stopLoginAs()
    {
        $id = Session::get('loginas');
        if( (int) app()->version() < 8 ) {
            $user = \App\User::findOrFail($id);
        } else {
            $user = \App\Models\User::findOrFail($id);
        }
        Auth::login($user);

        Session::forget('loginas');

        return redirect()->route('blueadmin.index', ['modelname' => 'users']);
    }
}
