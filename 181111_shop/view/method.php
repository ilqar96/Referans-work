<?php
include_once '../config/Database.php';
include_once '../models/Selling_method.php';

$database = new Database();
$db = $database->connect();

$method = new Selling_method($db);
// Blog post query
$result = $method->read();
// Get row count
$num = $result->rowCount();
// index for table 
$index = 1;
// Check if any posts
if ($num > 0) {
    $rows = $result->fetchAll(PDO::FETCH_ASSOC);
} else {
    echo 'No Posts Found';
}


require('../inc/head.php');
?>



    <div class="container-fluid">
        <div class="row justify-content-center">
        <div class="col-12 text-center my-5">
        <h1 class="display-3">Satış üsulu Sehifesi</h1>
        </div>
        <div class="col-12 mb-4">
            <button type="button" data-toggle="modal" data-target="#addMethodModal" class="btn btn-primary">Satış üsulu əlavə et</button>
        </div>
            <!-- table  -->
        <table class="table text-center" id="myTable">
            <thead class="thead-dark">
                <tr>
                <th scope="col">N</th>
                <th scope="col">Satış üsulu</th>
                <th>Əməliyyatlar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $col) : ?>
                <tr>
                    <td><?php echo $index++; ?></td>
                    <td><?php echo $col["method"] ?></td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger mr-2 btnDeleteMethod" data-id="<?php echo $col["id"]; ?>">
                        <i class="fas fa-trash-alt "></i>
                        </button>
                        <button type="button" class="btn btn-primary mr-2 btnEditMethod" data-toggle="modal" data-target="#editMethodModal" data-id="<?php echo $col["id"]; ?>">
                        <i class="fas fa-edit "></i>
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
    </table>
        </div>
    </div>


<!-- Add Method Modal -->
<div class="modal fade" id="addMethodModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Satış üsulu Əlavə Et</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form class="needs-validation w-75 mx-auto" novalidate>
        <div class="form-group">
            <label >Metod adı :</label>
            <input type="text" class="form-control" name="name"  placeholder="Metod adı Daxil edin" required>
        </div>
        <button type="submit" class="btn btn-primary addMethod">Əlavə et</button>
      </form>
      </div>
    </div>
  </div>
</div>


<!-- Edit Method Modal -->
<div class="modal fade" id="editMethodModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Satış üsulunda Düzəliş Et</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form class="needs-validation w-75 mx-auto" novalidate>
        <div class="form-group">
            <label >Metod Adı :</label>
            <input type="text" class="form-control" name="name"  placeholder="Metod adı Daxil edin" required>
        </div>
        <button type="submit" class="btn btn-primary editMethod">Düzəliş et</button>
      </form>
      </div>
    </div>
  </div>
</div>




    <script>
        $(document).ready(function(){
            // Get all  start
            function getAllMethods(){
                $.post("ajax.php",{
                    action:'getAllMethods'
                }).done(function(data){
                    $("tbody").html(data);
                });
            };
            // Get all  end

            // delete start 
            $("tbody").on("click",".btnDeleteMethod" , function(){
            if(confirm("Metodu silsəz bağlantılı məhsullar silinəcək.")) {
                $id = $(this).data("id");
                $btn = $(this);
                $.post("ajax.php",{
                    id:$id,
                    action:'deleteMethod'
                }).done(function(data){
                    if(data==1){
                        $btn.parent().parent().remove();
                        ActionComplated("Satış üsulu Silindi");
                    }
                    else{
                        alert("Method silinmedi. Mehod istifade olunub.");
                    }
                }).fail(function() {
                    alert( "error" );
                 });
            }
        });
        // end Delete 

        // insert start 
        $(".addMethod").click(function(e){
           $name = $("#addMethodModal input[name='name']").val().trim();
            if($name!=""){
                e.preventDefault();
                $.post("ajax.php",{
                    name:$name,
                    action:'addMethod'
                }).done(function(data){
                    if(data==1){
                    getAllMethods();
                    $("#addMethodModal .close").click();
                    $("#addMethodModal input").val("");
                    ActionComplated("Satış üsulu əlavə edildi.");
                    }else{
                        alert("xeta yarandi");
                    }
                })
            }
        })
        // insert end

         // edit start 
        
         $("tbody").on("click",".btnEditMethod" , function(){
            $id =  $(this).data("id");
            $("#editMethodModal .editMethod").data("id",$id);
            $.post("ajax.php",{
                id:$id,
                action:"readSingleMethod"
            }).done(function(data){
                $method = JSON.parse(data);
                $("#editMethodModal input[name='name']").val($method["method"]);
            }).fail(function(){
                alert("Xeta fail");
            })
        })

        $(".editMethod").click(function(e){
            e.preventDefault();
            $id = $(this).data("id")
            $name = $("#editMethodModal input[name='name']").val().trim();

            $.post("ajax.php",{
                id:$id,
                name:$name,
                action:"editMethod"
            }).done(function(data){
                getAllMethods();
                $("#editMethodModal .close").click();
                ActionComplated("Satış üsulu dəyişdirildi");
            }).fail(function(){
                alert("Fail");
            })
        })


        //edit end


        // end jquery 
        })
    </script>


    <?php require('../inc/footer.php'); ?>