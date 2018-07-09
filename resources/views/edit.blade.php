<br />
<div class="container">
  <form method="post" action="{{action('TodoController@update', $id)}}">
    @csrf
    <div class="row">
      <div class="col-md-2"></div>
      <div class="form-group col-md-6">
        <strong>Title:</strong>  
        <input class="form-control" type="text" name="title" autocomplete="off" value="{{$todo->title}}" autofocus>   
      </div>
    </div>
    <div class="row">
      <div class="col-md-2"></div>
      <div class="form-group col-md-7">
        <strong>Description:</strong><br>
      <textarea class="form-control" rows="10" name="explanation">{{$todo->explanation}}</textarea>
      </div>
    </div>
    <div class="row">
      <div class="col-md-2"></div>
      <div class="form-group col-md-4">
        <strong>Due Date:</strong>  
        <input class="date form-control" type="text" id="datepicker" autocomplete="off" textmode="date" name="due_date" value={{Carbon\Carbon::parse($todo->due_date)->format('d-m-Y')}}>   
      </div>
    </div>
    
    <div class="modal-footer">
      <button style="margin-right:10px" type="submit" class="btn btn-success">Submit</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
  </form>
</div>
