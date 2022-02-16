<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomepageController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('xix-admin.dashboard', ['user' => $user]);
    }
}
