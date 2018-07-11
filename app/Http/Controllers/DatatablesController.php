<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Todo;
use Illuminate\Http\Request;

class DatatablesController extends Controller
{   
    public function __construct()
    {
        $this->middleware('auth');
    }
    //
    public function getTodos() 
    {
        $query = Todo::where('user_id', Auth::id());
        return datatables($query)->make(true);
    }
}
