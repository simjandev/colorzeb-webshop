<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\CustomProductParameter;

class HomeController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        return view('home');
    }

    public function dev()
    {
       
    }
}
