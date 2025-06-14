<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $stores = Store::all();
        return view('contact', compact('stores'));
    }
} 