<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class Dashboard
 * @package App\Http\Controllers
 */
class Dashboard extends Controller
{
    public function dashboard()
    {
        return view('dashboard', ['pageTitle' => 'Dashboard']);
    }
}
