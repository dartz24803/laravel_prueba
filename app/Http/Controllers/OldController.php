<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OldController extends Controller
{
    function index()
    {
        return view('index_old');
    }
}
