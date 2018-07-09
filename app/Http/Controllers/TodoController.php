<?php

namespace App\Http\Controllers;
    
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TodoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('user_check');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $todos=\App\Todo::where('user_id', Auth::id())->orderBy('due_date')->paginate(5);
        

        return view('index',compact('todos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $todo = new \App\Todo;
        $todo->user_id = Auth::id();
        $todo->title = $request->get('title');
        $todo->explanation = $request->get('explanation');
        $todo->due_date = Carbon::createFromFormat('d-m-Y', $request->get('due_date'));
        $todo->save();

        return redirect('todos')->with('success', 'Information has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $todo = \App\Todo::find($id);
        if($todo->user_id != Auth::id()) 
            return redirect('todos')->with('warning', 'Unauthorized operation');

        return view('show', compact('todo', 'id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $todo = \App\Todo::find($id);
        if($todo->user_id != Auth::id()) 
            return redirect('todos')->with('warning', 'Unauthorized operation');

        return view('edit', compact('todo', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $todo = \App\Todo::find($id);
        if($todo->user_id != Auth::id())
        {
            return redirect('todos')->with('warning', 'Unauthorized operation');
        }

        $todo->title = $request->get('title');
        $todo->explanation = $request->get('explanation');
        $todo->due_date = Carbon::createFromFormat('d-m-Y', $request->get('due_date'));
        $todo->save();

        return redirect('todos');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $todo = \App\Todo::find($id);
        if($todo->user_id == Auth::id())
            $todo->delete();
        else {
            return redirect('todos')->with('warning', 'Unauthorized operation');
        }
        
        return redirect('todos')->with('success', 'Information has been deleted');
    }
}
