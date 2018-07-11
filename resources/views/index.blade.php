@extends("layouts.app")

@section("content")
  <script>
    document.getElementById("create_todo_button").style.visibility = "visible";
  </script>
  <style>
    #check-column {
      width: 100px;
    }
    #title-column {
      width: 300px;
    }
    #date-column {
      width: 200px;
    }

    .btn-gray {
      background-color: lightgray;
      color: black;
    }
  </style>

  <body>
    <div class="container">
      <br />
      @if (\Session::has('success'))
        <div class="alert alert-success">
          <p>{{ \Session::get('success') }}</p>
        </div><br />
      @endif

      @if (\Session::has('warning'))
        <div class="alert alert-danger">
          <p>{{ \Session::get('warning') }}</p> 
        </div><br />
      @endif

      <div style="text-align: right;">
        <form id="expired_form" method="GET">
          <input name="expired" value="no" {{ ($isExpired=="no") ? 'checked="checked"': ''}} id="hide_expired_todos" type="checkbox">Don't show expired todos</input>
        </form>
      </div>
      <br />

      <table id="todoTable">
        <thead>
          <tr>
            <th>Title</th>
            <th>Due Date</th>   
          </tr>
        </thead>
      </table>

      <table id="" class="table table-striped">
      <thead>
        <tr>
          <th>Check</th>
          <th>Title</th>
          <th>Due Date</th>
          <th>Action</th>
          <th>Warning</th>
        </tr>
      </thead>
      <tbody>

        @foreach($todos as $i => $todo)
          <tr>
            <td id="check-column">
              <form action="{{action('TodoController@destroy', $todo['id'])}}" method="post">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-success">✓</button>
              </form>            
            </td>
            <td id="title-column">{{$todo['title']}}</td>
            <td id="date-column">{{Carbon\Carbon::parse($todo->due_date)->format('d-m-Y')}}</td>
            <td id="action-column">
              <div class="row">
                <a href="{{action('TodoController@show', $todo['id'])}}" class="btn btn-gray">Show</a>
                <a style="margin-left:1em" id="{{$todo['id']}}" href="#" class="btn btn-warning editButton" data-toggle="modal" data-target="#editModal">Edit</a>     
              </div>
            </td>
            <td id="warning-column" style="color: red; font-weight: bold">
              @php
                $date = Carbon\Carbon::parse($todo->due_date)->format('d-m-Y');
                $diff = strtotime($date) - time();
                $daydiff = round($diff / (60 * 60 * 24));
                if($daydiff >= 0 && $daydiff < 3) {
                  if($daydiff == -0)
                    $daydiff = 0;
                  echo $daydiff . " days left!";
                }
              @endphp
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <div class="modal fade" id="createModal" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div id="addCreate">
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="editModal" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div id="addEdit">
          </div>
        </div>
      </div>
    </div>

  </div>
  </body>

  <script>
  
    $(document).ready( function () {
        $('#todoTable').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": {
              "url": "/getTodos"
            },
            "columns": [
              { "data" : "title" },
              { "data" : "due_date" },
            ],
        });
    } );
      
    $("#createButton").click(function(){
      $("#addCreate").load("/todos/create");
    });
    $(".editButton").click(function(){
      $("#addEdit").load("/todos/".concat(this.id).concat("/edit"));
    });

    $("#hide_expired_todos").click(function() {
      $("#expired_form").submit();
    });

  </script>
@endsection