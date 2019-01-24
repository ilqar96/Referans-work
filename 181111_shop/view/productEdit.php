<?php 

include_once '../config/Database.php';
include_once '../models/Product.php';
include_once '../models/Category.php';
include_once '../models/Seller.php';
include_once '../models/Selling_method.php';



// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

$product = new Product($db);
$category = new Category($db);
$seller = new Seller($db);
$selling_method = new Selling_method($db);

$queryCat = $category->read();
$querySeller = $seller->read();
$queryMethod = $selling_method->read();

$rowsCat = $queryCat->fetchAll(PDO::FETCH_ASSOC);
$rowsSeller = $querySeller->fetchAll(PDO::FETCH_ASSOC);
$rowsMethod = $queryMethod->fetchAll(PDO::FETCH_ASSOC);

//read single row from products
if (isset($_GET["id"])) {
  $product->id = $_GET['id'];
  $product->read_single();
}

if (isset($_POST["submit"])) {
  $product->id = $_POST["prodID"];
  $product->name = $_POST["product_name"];
  $product->category_id = $_POST["category_id"];
  $product->selling_method_id = $_POST["selling_method_id"];
  $product->purchase_price = $_POST["purchase_price"];
  $product->sale_price = $_POST["sale_price"];
  $product->seller_id = $_POST["seller_id"];
  $product->info = $_POST["info"];

  if ($product->update()) {
    header('Location:index.php');
  } else {
    echo "Xəta !!";
  }
}

if (isset($_POST["addCategory"])) {
  $category->name = $_POST["category_name"];
  $category->info = $_POST["category_info"];
  if ($category->create()) {
    header("Location: /projects/181111_shop/view/productEdit.php?$product->id");
  } else {
    echo "Xəta !!";
  }

}

if (isset($_POST["addMethod"])) {
  $selling_method->method = $_POST["method"];
  if ($selling_method->create()) {
    header("Location: /projects/181111_shop/view/productEdit.php?$product->id");
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
    Məhsulu Dəyişdir
  </h1>
</div>
<form class="needs-validation w-75 mx-auto" novalidate action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
  <div class="form-group">
    <label for="exampleFormControlInput1">Məhsul Adı :</label>
    <input required type="text" class="form-control"  placeholder="Məhsul Adı" name="product_name" value="<?php echo $product->name; ?>">
  </div>
  <div class="form-group position-relative" >
    <label for="exampleFormControlSelect1">Kategoriya</label>
    <select required class="form-control" id="category"  name="category_id">
    <?php foreach ($rowsCat as $col) : ?>
      <option value="<?php echo $col['id'] ?>"><?php echo $col["name"] ?></option>
    <?php endforeach; ?>
    </select>
  </div>
  <div class="form-group position-relative">
    <label for="exampleFormControlSelect1">Satış üsulu:</label>
    <select required class="form-control" id="method" name="selling_method_id">
      <?php foreach ($rowsMethod as $col) : ?>
        <option value="<?php echo $col['id'] ?>"><?php echo $col["method"] ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="form-group">
    <label for="exampleFormControlInput1">Alış qiyməti :</label>
    <input required  step="0.01" type="number" class="form-control" value="<?php echo $product->purchase_price; ?>"   name="purchase_price">
  </div>
  <div class="form-group">
    <label for="exampleFormControlInput1">Təklif olunan Qiyməti:</label>
    <input  type="number" step="0.01" class="form-control" readonly>
  </div>
  <div class="form-group">
    <label for="exampleFormControlInput1">Satış Qiyməti:</label>
    <input required  step="0.01" type="number" class="form-control"  value="<?php echo $product->sale_price; ?>"  name="sale_price">
  </div>
  <div class="form-group">
    <label for="exampleFormControlSelect1">Satıcı Firma</label>
    <select required class="form-control" id="company" name="seller_id">
      <?php foreach ($rowsSeller as $col) : ?>
        <option value="<?php echo $col['id'] ?>"><?php echo $col["company_name"] ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="form-group">
    <label >Məlumat :</label>
    <textarea required class="form-control"rows="3" name="info"><?php echo $product->info; ?></textarea>
  </div>
  <input type="hidden" name="prodID" value="<?php echo $product->id; ?>">

  <button class="btn btn-primary w-100 my-4 py-3" type="submit"  name="submit">Təsdiqlə</button>
</form>
</div>
</div>


   
    <script >
      $(document).ready(function(){
        $('#category option[value="<?php echo $product->category_id; ?>"]').attr("selected","true");
        $('#method option[value="<?php echo $product->selling_method_id; ?>"]').attr("selected","true");
        $('#company option[value="<?php echo $product->seller_id; ?>"]').attr("selected","true");
      })
    </script>




<?php require('../inc/footer.php'); ?>
