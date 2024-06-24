<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index(){
        $favorites = auth()->user()->favorites;
        return view('sections.favorites.index',compact('favorites'));
    }
}
