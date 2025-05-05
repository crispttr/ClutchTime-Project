<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WelcomeMessageController extends Controller
{
    public function __invoke(Request $request)
    {
        return response()->json([
            'message' => "Bienvenue, " . $request->user()->name . " ! Tu es bien authentifié."
        ]);
    }
}
