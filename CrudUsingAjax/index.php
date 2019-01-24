<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>


<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" id="add" data-target="#addModal">
  Add 
</button>

  <table class="table">
  <thead>
  <tr>
      <th>Name</th>
      <th>surname</th>
      <th>age</th>
      <th>edit</th>
      <th>delete</th>

    </tr>
  </thead>
    <tbody id="fillForm">
       

    </tbody>
   
  </table>






















<!--  add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form id="myform"  >
        name:
            <input type="text" class="inputName" name="name">
            surname:
            <input type="text" name="surname" >
            age:
            <input type="number" name="age" >
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" form="myform" name="submit" class="btn btn-primary btnAdd">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- edit modal -->
<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <!-- form start  -->
        <form id="myform"  >
        name:
            <input type="text" class="inputName" name="name">
            surname:
            <input type="text" name="surname" >
            age:
            <input type="number" name="age" >
        </form>
      </div>
      <div class="modal-footer">
      <!-- submit button  -->
        <button type="submit" form="myform" name="submit" class="btn btn-primary btnEdit">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- delete modal  -->
<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <p class="deleteName"></p>


      
      <div class="modal-footer">
        <button type="submit"   name="submit" class="btn btn-primary btndelete">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>






<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <script src="js/jquery.js"></script>
<script>
$(document).ready(function(){
  // fill table with data 
  function selectTable(){
    $.post("ajax.php" ,{
      p: "select"
    }).done(function(data){
      $("#fillForm").html(data);
    })
  }
  selectTable();
    // delete button click
    $("#fillForm").on("click", ".delete",  function(){
      $id = $(this).data("id");
      
      $("#deleteModal .btndelete").data("id",$id);
      $("#deleteModal .deleteName").html($id);

    });
    // delete modal btn
    $("#deleteModal .btndelete").click(function(e){
      e.preventDefault();
      $id =$("#deleteModal .btndelete").data("id");
      $.post("ajax.php" ,{
      id:$id,
      p:"delete"
    }).done(function(){
      selectTable();
      $("#deleteModal .close").click()
    })
    })
    // edit button click 
    $("#fillForm").on("click", ".edit",  function(){
      $id = $(this).data("id");
      $("#editModal .btnEdit").data("id",$id);
      $.post("ajax.php" , {
        id:$id,
        p:"selectFirst"
      }).done(function(data){
        var $array = JSON.parse(data);
        $("#editModal input[name=name]").val($array["name"]);
        $("#editModal input[name=surname]").val($array["surname"]);
        $("#editModal input[name=age]").val($array["age"]);
      });
    })
    // edit modal btn click
    $("#editModal .btnEdit").click(function(e){
      e.preventDefault();
        $name =  $("#editModal input[name=name]").val();
        $surname =  $("#editModal input[name=surname]").val();
        $age =  $("#editModal input[name=age]").val();
        $id = $(this).data("id");

        $.post("ajax.php" , {
          name:$name,
          surname:$surname,
          age:$age,
          id:$id,
          p:"edit"
        }).done(function(data){
          selectTable();
          $("#editModal .close").click()
        })
    });

    $("#addModal .btnAdd").click(function(e){
          e.preventDefault();
          $name =  $("#addModal input[name=name]").val();
          $surname =  $("#addModal input[name=surname]").val();
          $age =  $("#addModal input[name=age]").val();

          $("#addModal input").val("");

          $.post("ajax.php" , {
          name:$name,
          surname:$surname,
          age:$age,
          p:"add"
        }).done(function(data){
          selectTable();
          $("#addModal .close").click()
        });
        })





  })

</script>



    
</body>
</html>