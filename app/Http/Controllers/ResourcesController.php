<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResourcesController extends Controller
{
    public function index() {
        return response()->json([
            [
                'id' => 1, 
                'title' => 'Github',
                'url' => 'github.com',
                'description' => 'Github is great!',
                'user_id' => 1
            ]
        ], 200);
    }
}
