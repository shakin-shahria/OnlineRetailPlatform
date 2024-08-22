<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; // Import the base Controller class
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        //echo "Admin Dashboard";
        return view('admin.dashboard'); // Return a view instead of echoing directly
    }
}
