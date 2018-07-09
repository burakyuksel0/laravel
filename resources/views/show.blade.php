@extends('layouts.app')

@section('content')
  <body>
    <div class="container">
        @csrf
        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-6">    
                <table id="entry" style="font-size:20px">
                    <tr>
                        <td style={>Title: {{$todo->title}}</td>
                    </tr>
                    <tr style="font-size:18px">
                        <td>Due: {{Carbon\Carbon::parse($todo->due_date)->format('d-m-Y')}}</td>
                    </tr>
                    <tr style="font-size:16px">
                        <td style="white-space: pre-line">Description:<br>{{$todo->explanation}}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-2">
                <a class="btn btn-primary" href="{{action('TodoController@index')}}">Back</a>
            </div>
        </div>
    </div>
    <script type="text/javascript">  
        $('#datepicker').datepicker({ 
            autoclose: true,   
            format: 'dd-mm-yyyy'  
         });  
    </script>
  </body>
  @endsection
