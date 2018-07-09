<br />
<div class="container">
  <form method="post" action="{{url('/todos')}}" enctype="multipart/form-data">
    @csrf
    <div class="row">
      <div class="col-md-2"></div>
      <div class="form-group col-md-6">
        <label for="Title">Title:</label><br>
        <input class="form-control" type='text' autocomplete="off" name="title" placeholder="" autofocus>
      </div>
    </div>
    <div class="row">
      <div class="col-md-2"></div>
      <div class="form-group col-md-7">
        <label for="Explanation">Description:</label><br>
        <textarea class="form-control" rows="10" name="explanation"></textarea>
      </div>
    </div>
    <div class="row">
      <div class="col-md-2"></div>
      <div class="form-group col-md-4">
        <label for="DueDate">Due Date:</label>  
        <input class="date form-control"  type="text" autocomplete="off" textmode="date" id="datepicker" name="due_date">   
      </div>
    </div>

    <div class="modal-footer">
      <button style="margin-right:10px" type="submit" class="btn btn-success">Submit</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
      
  </form>
</div>
