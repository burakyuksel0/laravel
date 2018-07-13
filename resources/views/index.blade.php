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

      <div style="text-align: right;">
        <form id="expired_form" method="GET">
          <input name="hideExpired" value="yes" {{ ($hideExpired=="yes") ? 'checked="checked"': ''}} id="hide_expired_todos" type="checkbox">Don't show expired todos</input>
        </form>
      </div>
      <br />

      <table id="todoTable" class="table-hover row-border">
        <thead>
          <tr>
            <th style="width: 180px">Check/Edit</th>
            <th style="max-width: 400px">Title</th>
            <th>Due Date</th>
            <th>Warning</th>
          </tr>
        </thead>
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

    <div class="modal fade" id="showModal" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div id="addShow">
            </div>
          </div>
        </div>
      </div>

  </div>
  </body>

  <script>
  
    $(document).ready( function () {
      var hideExpired = document.getElementById("hide_expired_todos").checked;

      $('#todoTable').DataTable( {
        searching: false,
        info: false,
        lengthMenu: [5, 10, 20, 50],
        order: [[2, 'asc']],
        ajax: {
          url: "/getTodos",
          data: { "hideExpired" : hideExpired }
        },
        columns: [
          { data: "check",
            render: function(data) {
              return '<form method="post" action="/todos/' + data + '/delete">'
                + '@csrf'
                + '@method("delete")'
                + '<button type="submit" class="btn btn-success d"><i style="color: white; font-size:16px; margin-top: 4px" class="material-icons">&#xe5ca;</i></button>'
                + '<a onclick="editClick(' + data + ')" style="margin-left:1em" class="editButton btn btn-warning" data-toggle="modal" data-target="#editModal"><i style="color: white; font-size:16px; margin-top: 4px" class="material-icons">&#xe254;</i></a>'
                + '<a onclick="showClick(' + data + ')" style="margin-left:1em" class="showButton btn btn-primary" data-toggle="modal" data-target="#showModal"><i style="color: white; font-size:16px; margin-top: 4px" class="material-icons">&#xe417;</i></a>'
                + '</form>';
            },
            searchable: false, orderable: false
          },
          { data: "title", },
          { data: "due_date", searchable: false },
          { data : "warning",
            render: function(data) {
              var color = "red";
              if(data == "Expired!")
                color = "gray";

              return '<span style="color:' + color + '; font-weight: bold">' + data + '</span>'
            },
            searchable: false, orderable: false
          },
        ],
      });
    } );

    $("#createButton").click(function(){
      $("#addCreate").load("/todos/create");
    });
    function editClick(id) {
      $("#addEdit").load("/todos/" + id + "/edit");
    }
    function showClick(id) {
      $("#addShow").load("/todos/" + id);
    }
    $("#hide_expired_todos").click(function() {
      $("#expired_form").submit();
    });

  </script>
@endsection