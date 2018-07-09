@extends("layouts.app")

@section("content")
  <script>
    document.getElementById("create_todo_button").style.visibility = "visible";
  </script>

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

      <table id="myTable" class="table table-striped">
      <thead>
        <tr>
          <th>Title</th>
          <th>Due Date</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>

        @for($i = 0; $i < sizeof($todos); $i++)
        @php
          $todo = $todos[$i];
          $date=date('Y-m-d', $todo['date']);
        @endphp
        <tr>
          <td>{{$todo['title']}}</td>
          <td>{{Carbon\Carbon::parse($todo->due_date)->format('d-m-Y')}}</td>
          <td>
            <div class="row">
              <a style="margin-left:1em" href="{{action('TodoController@show', $todo['id'])}}" class="btn btn-primary">Show</a>
              <a style="margin-left:1em" id="{{$todo['id']}}" href="#" class="btn btn-warning editButton" data-toggle="modal" data-target="#editModal">Edit</a>
              <form style="margin-left: 1em" action="{{action('TodoController@destroy', $todo['id'])}}" method="post">
                @csrf
                @method('delete')
                <button type="submit" style="margin-right:20px" class="btn btn-danger">Delete</button>
              </form>     
            </div>
          </td>
          
        </tr>
        @endfor
      </tbody>
    </table>

    <div style="text-align: center">
      {{ $todos->links() }}
    </div>

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
    $("#createButton").click(function(){
      $("#addCreate").load("/todos/create");
    });
    $(".editButton").click(function(){
      $("#addEdit").load("/todos/".concat(this.id).concat("/edit"));
    });
  </script>
@endsection