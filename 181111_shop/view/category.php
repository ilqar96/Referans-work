<?php
include_once '../config/Database.php';
include_once '../models/Category.php';

$database = new Database();
$db = $database->connect();

$category = new Category($db);
// Blog post query
$result = $category->read();
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
        <h1 class="display-3">Kategoriya Sehifesi</h1>
        </div>
        <div class="col-12 mb-4">
            <button type="button" data-toggle="modal" data-target="#addCategoryModal" class="btn btn-primary">Kategoriya əlavə et</button>
        </div>
            <!-- table  -->
        <table class="table text-center" id="myTable" style="width:100%;">
            <thead class="thead-dark">
                <tr>
                <th scope="col">N</th>
                <th scope="col">Kategoriya Adı</th>
                <th scope="col">Məlumat</th>
                <th>Əməliyyatlar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $col) : ?>
                <tr>
                    <td><?php echo $index++; ?></td>
                    <td><?php echo $col["name"] ?></td>
                    <td><?php echo $col["info"] ?></td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger mr-2 btnDeleteCategory" data-id="<?php echo $col["id"]; ?>">
                        <i class="fas fa-trash-alt "></i>
                        </button>
                        <button type="button" class="btn btn-primary mr-2 btnEditCategory" data-toggle="modal" data-target="#editCategoryModal" data-id="<?php echo $col["id"]; ?>">
                        <i class="fas fa-edit "></i>
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
    </table>
        </div>
    </div>


<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Kategoriya Əlavə Et</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form class="needs-validation w-75 mx-auto" novalidate>
        <div class="form-group">
            <label >Kategoriya Adı :</label>
            <input type="text" class="form-control" name="name"  placeholder="Kategoriya adı Daxil edin" required>
        </div>
        <div class="form-group">
            <label >Məlumat :</label>
            <textarea name="info"  class="form-control" rows="3" ></textarea>
        </div>
        <button type="submit" class="btn btn-primary addCategory">Əlavə et</button>
      </form>
      </div>
    </div>
  </div>
</div>


<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Kategoriyada Düzəliş Et</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form class="needs-validation w-75 mx-auto" novalidate>
        <div class="form-group">
            <label >Kategoriya Adı :</label>
            <input type="text" class="form-control" name="name"  placeholder="Kategoriya adı Daxil edin" required>
        </div>
        <div class="form-group">
            <label >Məlumat :</label>
            <textarea name="info"  class="form-control" rows="3" ></textarea>
        </div>
        <button type="submit" class="btn btn-primary editCategory">Düzəliş et</button>
      </form>
      </div>
    </div>
  </div>
</div>


    <script>
        $(document).ready(function(){
        // Get all  start
            function getAllCategories(){
                $.post("ajax.php",{
                    action:'getAllCategories'
                }).done(function(data){
                    $("tbody").html(data);
                });
            };
        // Get all  end

        // delete start
            $("tbody").on("click",".btnDeleteCategory" , function(){
            if(confirm("Kategoriyanı silmek isteyirsiz ?")) {
                $id = $(this).data("id");
                $btn = $(this);
                $.post("ajax.php",{
                    id:$id,
                    action:'deleteCategory'
                }).done(function(data){
                    if(data==1){
                        getAllCategories();
                        ActionComplated("Kategoriya Silindi");
                    }
                    else{
                        alert("Xeta !.Bu kategoriya diger cedvelde istifade olunub.");
                    }
                }).fail(function() {
                    alert( "error" );
                 });
            }
        });
        // end Delete 

        // Add start
        $(".addCategory").click(function(e){
           $name = $("#addCategoryModal input[name='name']").val().trim();
            $info =$("#addCategoryModal textarea[name='info']").val().trim();
            if($name!=""){
                e.preventDefault();
                $.post("ajax.php",{
                    name:$name,
                    info:$info,
                    action:'addCategory'
                }).done(function(){
                    getAllCategories();
                    $("#addCategoryModal .close").click();
                    $("#addCategoryModal input").val("");
                    $("#addCategoryModal textarea").val("");
                    ActionComplated("kategoriya əlavə edildi.");
                })

            }
        })
        // Add end

        // edit start 
        
        $("tbody").on("click",".btnEditCategory" , function(){
            $id =  $(this).data("id");
            $("#editCategoryModal .editCategory").data("id",$id);
            $.post("ajax.php",{
                id:$id,
                action:"readSingleCategory"
            }).done(function(data){
                $cat = JSON.parse(data);
                $("#editCategoryModal input[name='name']").val($cat["name"]);
                $("#editCategoryModal textarea[name='info']").val($cat["info"]);
            }).fail(function(){
                alert("fail");
            })
        })

        $(".editCategory").click(function(e){
            e.preventDefault();
            $id = $(this).data("id")
            $name = $("#editCategoryModal input[name='name']").val().trim();
            $info =$("#editCategoryModal textarea[name='info']").val().trim();

            $.post("ajax.php",{
                id:$id,
                name:$name,
                info:$info,
                action:"editCategory"
            }).done(function(data){
                getAllCategories();
                $("#editCategoryModal .close").click();
                ActionComplated("Kategoriya dəyişdirildi");
            }).fail(function(){
                alert("Fail");
            })
        })


        //edit end

        // end jquery 
        })
    </script>


    <?php require('../inc/footer.php'); ?>