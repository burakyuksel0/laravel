<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Todo;
use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use Carbon\Carbon;

class DatatablesController extends Controller
{   
    public function __construct()
    {
        $this->middleware('auth');
    }
    //
    public function getTodos(Request $request) 
    {
        $todo = Todo::where('user_id', Auth::id());
        $hideExpired = $request->get('hideExpired');
        
        if ($hideExpired == 'true') {
            $todo = $todo->whereRaw('due_date > now()');
        }
        
        return Datatables::of($todo)
            ->addColumn('title', function($todo) {
                return $todo->title;
            })
            ->addColumn('due_date', function($todo) {
                return Carbon::parse($todo->due_date)->format('d-m-Y');
            })
            ->addColumn('check', function($todo) {
                return $todo->id;
            })
            ->addColumn('warning', function($todo) {
                $date = Carbon::parse($todo->due_date)->format('d-m-Y');
                $diff = strtotime($date) - time();
                $daydiff = round($diff / (60 * 60 * 24));
                if($daydiff >= 0 && $daydiff < 3) {
                    if($daydiff == -0)
                        $daydiff = 0;

                }

                if($daydiff <= 0) {
                    return "Expired!";                    
                }
                else if($daydiff > 3)
                    return "";

                return $daydiff . " days left!";
            })->make(true);
    }
}
