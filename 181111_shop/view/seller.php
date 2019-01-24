<?php
include_once '../config/Database.php';
include_once '../models/Seller.php';
  
    // Instantiate DB & connect
$database = new Database();
$db = $database->connect();
  
    // Instantiate blog post object
$seller = new Seller($db);
    
     // Blog post query
$result = $seller->read();
    // Get row count
$num = $result->rowCount();
    // index for table 
$index = 1;

    // Check if any posts
if ($num > 0) {
    $rows = $result->fetchAll(PDO::FETCH_ASSOC);
} else {
        // No Posts
    echo 'No Posts Found';
}


require('../inc/head.php');
?>



    <div class="container-fluid">
        <div class="row justify-content-center">
        <div class="col-12 text-center my-5">
        <h1 class="display-3">Satici Səhifəsi</h1>
        </div>
        <div class="col-12 mb-4">
            <button type="button" data-toggle="modal" data-target="#addSellerModal" class="btn btn-primary">Satici elave et</button>
        </div>
            <!-- table  -->
        <table class="table text-center" id="myTable" style="width:100%;">
            <thead class="thead-dark">
                <tr>
                <th scope="col">N</th>
                <th scope="col">Şirkət Adı</th>
                <th scope="col">Telefon Nömrəsi</th>
                <th scope="col">Satıcı Adı</th>
                <th>Əməliyyatlar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $col) : ?>
                <tr>
                    <td><?php echo $index++; ?></td>
                    <td><?php echo $col["company_name"] ?></td>
                    <td><?php echo $col["phone_num"] ?></td>
                    <td><?php echo $col["name"] ?></td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger mr-2 btnDeleteSeller" data-id="<?php echo $col["id"]; ?>">
                        <i class="fas fa-trash-alt "></i>
                        </button>
                        <button type="button" class="btn btn-primary mr-2 btnEditSeller" data-toggle="modal" data-target="#editSellerModal" data-id="<?php echo $col["id"]; ?>">
                        <i class="fas fa-edit "></i>
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
    </table>
        </div>
    </div>

<!-- Add seller Modal -->
<div class="modal fade" id="addSellerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Satıcı Əlavə Et</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form class="needs-validation w-75 mx-auto" novalidate>
        <div class="form-group">
            <label >Şirkət Adı</label>
            <input type="text" class="form-control" name="companyName"  placeholder="Şirkət adı Daxil edin"  required>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Tel Nömrəsi</label>
            <input type="tel" maxlength="13" class="form-control" name="phoneNum" placeholder="Telefon" required>
        </div>
        <div class="form-group">
            <label >Satıcı Adı</label>
            <input type="text" class="form-control"  name="sellerName" placeholder="Satıcı adı Daxil edin" required>
        </div>
        <button type="submit" class="btn btn-primary addSeller">Əlavə et</button>
      </form>
      </div>
    </div>
  </div>
</div>


<!-- Edit seller Modal -->
<div class="modal fade" id="editSellerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Satıcıda Düzəliş et</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form class="needs-validation w-75 mx-auto" novalidate>
        <div class="form-group">
            <label >Şirkət Adı</label>
            <input type="text" class="form-control" name="companyName"  placeholder="Şirkət adı Daxil edin" required>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Tel Nömrəsi</label>
            <input type="tel" maxlength="13" class="form-control" name="phoneNum" placeholder="Telefon" required>
        </div>
        <div class="form-group">
            <label >Satıcı Adı</label>
            <input type="text" class="form-control"   name="sellerName" placeholder="Satıcı adı Daxil edin" required>
        </div>
        <button type="submit" class="btn btn-primary editSeller">Düzəliş et</button>
      </form>
      </div>
    </div>
  </div>
</div>














    

    <script >
      $(document).ready(function(){

        function getAllSeller(){
            $.post("ajax.php" ,{
                action:'getAllSeller'
            }).done(function(data){
                $("tbody").html(data);
            })
        }

        $(".addSeller").click(function(e){
            $companyName =  $("#addSellerModal input[name='companyName']").val().trim();
            $phoneNum =  $("#addSellerModal input[name='phoneNum']").val().trim();
            $sellerName =  $("#addSellerModal input[name='sellerName']").val().trim();
            if($companyName!="" && $phoneNum!=""  && $sellerName!=""){
                e.preventDefault();
                $.post("ajax.php",{
                    companyName:$companyName,
                    phoneNum:$phoneNum,
                    sellerName:$sellerName,
                    action:"addSeller"
                }).done(function(data){
                    getAllSeller();
                    $("#addSellerModal .close").click();
                    $("#addSellerModal input").val("");
                    ActionComplated("Satıcı Əlavə edildi");
                }) 
            }
        });

        $("tbody").on("click",".btnDeleteSeller" , function(){
            if(confirm("Saticini silsez baglantili setirler silinecek.")) {
                $id = $(this).data("id");
                $btn = $(this);
                $.post("ajax.php",{
                    id:$id,
                    action:'deleteSeller'
                }).done(function(data){
                    if(data==1){
                       getAllSeller();
                       ActionComplated("Satıcı Silindi");
                    }
                    else{
                        alert("Xeta yarandı");
                    }
                }).fail(function() {
                    alert( "error" );
                 });
            }
        })

        $("tbody").on("click",".btnEditSeller",function(){
            $id =  $(this).data("id");
            $("#editSellerModal .editSeller").data("id",$id);
            $.post("ajax.php",{
                id:$id,
                action:"readSingleSeller"
            }).done(function(data){
                $seller = JSON.parse(data);
                $("#editSellerModal input[name='companyName']").val($seller["company_name"]);
                $("#editSellerModal input[name='phoneNum']").val($seller["phone_num"]);
                $("#editSellerModal input[name='sellerName']").val($seller["name"]);
            })
        });

        $("#editSellerModal .editSeller").click(function(e){
            e.preventDefault();
            $btn = $(this);
            $id =  $(this).data("id");
            $companyName =  $("#editSellerModal input[name='companyName']").val();
            $phoneNum =  $("#editSellerModal input[name='phoneNum']").val();
            $sellerName =  $("#editSellerModal input[name='sellerName']").val();
            $.post("ajax.php",{
                id:$id,
                companyName:$companyName,
                phoneNum:$phoneNum,
                sellerName:$sellerName,
                action:"editSeller"
            }).done(function(data){
                getAllSeller();
                $("#editSellerModal .close").click();
                ActionComplated("Satıcıya düzəliş edildi");
            }).fail(function(){
                alert();
            })
        })









      })
    </script>


    <?php require('../inc/footer.php'); ?>