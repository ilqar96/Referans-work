<?php 

include_once '../config/Database.php';
include_once '../models/Product.php';
include_once '../models/Seller.php';



// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

$product = new Product($db);
$seller = new Seller($db);



$querySeller = $seller->read();

$rowsSeller = $querySeller->fetchAll(PDO::FETCH_ASSOC);


if (isset($_POST["submit"])) {
  $product->name = $_POST["product_name"];
  $product->category_id = $_POST["category_id"];
  $product->selling_method_id = $_POST["selling_method_id"];
  $product->purchase_price = $_POST["purchase_price"];
  $product->sale_price = $_POST["sale_price"];
  $product->seller_id = $_POST["seller_id"];
  $product->info = $_POST["info"];

  if ($product->create()) {
    header('Location: /projects/181111_shop/view/productAddEdit.php');
  } else {
    echo "Xəta !!";
  }
}


require('../inc/head.php');

?>


<div class="container-fluid p-5 bg-dark text-light">
<div class="row">
<div class="col-12">
  <h1 class="display-3 text-center">
    Məhsul Əlavə Et
  </h1>
</div>
<form class="needs-validation w-75 mx-auto" novalidate action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
  <div class="form-group">
    <label for="exampleFormControlInput1">Məhsul Adı :</label>
    <input required type="text" class="form-control"  placeholder="Məhsul Adı" name="product_name" value="<?php echo $product->name; ?>">
  </div>
  <div class="form-group position-relative" >
    <label for="exampleFormControlSelect1">Kategoriya</label>
    <select required class="form-control" name="category_id">
    <!-- filled with ajax -->
    </select>
    <div class="addElement">
      <i class="fas fa-plus fa-2x"  data-target ="#addCategory"  data-toggle="modal"></i>
    </div>
  </div>
  <div class="form-group position-relative">
    <label for="exampleFormControlSelect1">Satış üsulu:</label>
    <select required class="form-control" name="selling_method_id">
      <!-- filled with ajax  -->
    </select>
    <div class="addElement">
      <i class="fas fa-plus fa-2x"  data-target ="#addMethod"  data-toggle="modal"></i>
    </div>
  </div>
  <div class="form-group">
    <label for="exampleFormControlInput1">Alış qiyməti :</label>
    <input required  step="0.01" type="number" class="form-control" id="purchasePrice"   name="purchase_price">
  </div>
  <div class="form-group">
    <label for="exampleFormControlInput1">Təklif olunan Qiyməti:</label>
    <input  type="number" step="0.01" class="form-control" id="suggestedPrice" readonly>
  </div>
  <div class="form-group">
    <label for="exampleFormControlInput1">Satış Qiyməti:</label>
    <input required  step="0.01" type="number" class="form-control"   name="sale_price">
  </div>
  <div class="form-group">
    <label for="exampleFormControlSelect1">Satıcı Firma</label>
    <select required class="form-control" name="seller_id">
      <?php foreach ($rowsSeller as $col) : ?>
        <option value="<?php echo $col['id'] ?>"><?php echo $col["company_name"] ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="form-group">
    <label >Məlumat :</label>
    <textarea required class="form-control"rows="3" name="info"></textarea>
  </div>

  <button class="btn btn-primary w-100 my-4 py-3" type="submit"  name="submit">Təsdiqlə</button>
</form>
</div>
</div>


<!-- modal for category add  -->
<div class="modal fade" id="addCategory" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title mx-auto" id="exampleModalLabel">Kategoriya əlavə et</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="needs-validation ">
          <div class="form-group">
            <label  class="col-form-label">Kategoriya adı:</label>
            <input type="text" class="form-control" name="name"  required>
          </div>
          <div class="form-group">
            <label  class="col-form-label">Məlumat:</label>
            <textarea class="form-control" name="info"></textarea>
          </div>
          <button type="submit"  class="btn btn-primary w-100 addCategory">Təsdiqlə</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- modal for method add  -->
<div class="modal fade" id="addMethod" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title mx-auto" >Metod əlavə et</h5>
        <button type="button" class="close" data-dismiss="modal" >
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="needs-validation" >
          <div class="form-group">
            <label  class="col-form-label">Satış Forması:</label>
            <input type="text" class="form-control" name="method"  required>
          </div>

          <button type="submit"  class="btn btn-primary w-100 my-4 addMethod">Təsdiqlə</button>
        </form>
      </div>
    </div>
  </div>
</div>



<script>
  $(document).ready(function(){

    // method 
      $(".addMethod").click(function(e){
        $name = $("#addMethod input[name='method']").val().trim();
            if($name!=""){
                e.preventDefault();
                $.post("ajax.php",{
                    name:$name,
                    action:'addMethod'
                }).done(function(data){
                    if(data==1){
                    $("#addMethod .close").click();
                    $("#addMethod input").val("");
                    getAllMethodOptions();
                    ActionComplated("Satış üsulu əlavə edildi.");
                    }else{
                        alert("xeta yarandi");
                    }
                })
            }
      })
      // add method end

      // get options method start
      function getAllMethodOptions(){
                $.post("ajax.php",{
                    action:'getAllMethodOptions'
                }).done(function(data){
                    $("select[name='selling_method_id']").html(data);
                });
            };
            getAllMethodOptions();
      // get options method end

      //method end

    //Category start
    $(".addCategory").click(function(e){
        $name = $("#addCategory input[name='name']").val().trim();
        $info = $("#addCategory textarea[name='info']").val().trim();

            if($name!=""){
                e.preventDefault();
                $.post("ajax.php",{
                    name:$name,
                    info:$info,
                    action:'addCategory'
                }).done(function(data){
                    if(data==1){
                    $("#addCategory .close").click();
                    $("#addCategory input").val("");
                    getAllCategoryOptions();
                    ActionComplated("Kategoriya əlavə edildi.");
                    }else{
                        alert("xeta yarandi");
                    }
                })
            }
      })
      // add category end

      // get options Category start
      function getAllCategoryOptions(){
                $.post("ajax.php",{
                    action:'getAllCategoryOptions'
                }).done(function(data){
                    $("select[name='category_id']").html(data);
                });
            };
            getAllCategoryOptions();
      // get options Category end
    // category end



    $("#purchasePrice").keyup(function(){
      $price =  $(this).val();
      $price = parseInt($price);
      $sprice = Math.ceil($price*0.1 + $price);
      $("#suggestedPrice").val($sprice);
    })


  }); // end jquery
</script>






<?php require('../inc/footer.php'); ?>
