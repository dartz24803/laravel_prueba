<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TrackingToken;
use Illuminate\Http\Request;

class TrackingTokenController extends Controller
{
    public function store(Request $request)
    {
        TrackingToken::upsert([
            'base' => $request->base,
            'token' => $request->token,
            'fecha' => now()
        ], ['token'], ['base','fecha']);
    }
}