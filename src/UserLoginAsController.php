<?php

namespace Ndeblauw\BlueAdmin;

use Auth;
use Session;
use App\User;
use App\Http\Controllers\Controller;

class UserLoginAsController extends Controller
{
    public function loginAs(User $user)
    {
        $current_user_id = Auth::id();
        Auth::login($user);

        Session::put('loginas', $current_user_id);
        return redirect()->route('home');
    }

    public function stopLoginAs()
    {
        $id = Session::get('loginas');
        $user = User::find($id);
        Auth::login($user);

        Session::forget('loginas');

        return redirect()->route('blueadmin.index', ['modelname' => 'users']);
    }
}
