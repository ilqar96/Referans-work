<?php
include_once '../config/Database.php';
include_once '../models/Product.php';
  
    // Instantiate DB & connect
$database = new Database();
$db = $database->connect();
  
    // Instantiate blog post object
$post = new Product($db);
    
     // Blog post query
$result = $post->read();
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

if (isset($_POST["submit"])) {
    $database = new Database();
    $db = $database->connect();
    $valueToSearch = $_POST["searchT"];
    $query = $post->filterAllCol($valueToSearch);
    $rows = $query->fetchAll(PDO::FETCH_ASSOC);
}

require('../inc/head.php');
?>



    <div class="container-fluid">
        <div class="row">
        <div class="col-12 text-center my-5">
        <h1 class="display-3">Ana Səhifə</h1>
        </div>
        <!-- search input  -->
                <form class="input-group m-5" method="POST" action="<?php echo $_SERVER["PHP_SELF"] ?>">
                    <input type="text" class="form-control" name="searchT" >
                    <div class="input-group-append">
                        <button type="submit" name="submit" class="btn btn-outline-secondary">Axtarış Et</button>
                    </div>
                </form>

                <div class="ml-auto">
                <a href="productAddEdit.php" class="btn btn-primary mb-2  mr-4  ">Mehsul elave et</a>
                
                </div>

            <!-- table  -->
                <table class="table">
            <thead class="thead-dark">
                <tr>
                <th scope="col">N</th>
                <th scope="col">Məhsul Adı</th>
                <th scope="col">Kategoriya</th>
                <th scope="col">Satış Üsulu</th>
                <th scope="col">Alış Qiy</th>
                <th scope="col">Təklif olunan satış Qiy</th>
                <th scope="col">Satış Qiy</th>
                <th scope="col">Satıcı Firma</th>
                <th scope="col">Satıcı Adı</th>
                <th>Əməliyyatlar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $col) : ?>
                <tr>
                    <td><?php echo $index++; ?></td>
                    <td><?php echo $col["product_name"] ?></td>
                    <td><?php echo $col["category_name"] ?></td>
                    <td><?php echo $col["method"] ?></td>
                    <td><?php echo $col["purchase_price"] ?></td>
                    <td><?php echo $col["suggested_price"] ?></td>
                    <td><?php echo $col["sale_price"] ?></td>
                    <td><?php echo $col["company_name"] ?></td>
                    <td><?php echo $col["seller_name"] ?></td>
                    <td class="text-center">
                        <button class=" btn btn-danger mr-2 btnDeleteProduct" data-id="<?php echo $col["id"]; ?>" type="button" >
                        <i class="fas fa-trash-alt"></i>
                        </button>
                        <a href="productEdit.php?id=<?php echo $col["id"] ?>">
                            <i class="fas fa-edit btn btn-primary"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
</table>
        </div>
    </div>
    

    <script >
      $(document).ready(function(){
        $("tbody").on("click",".btnDeleteProduct" , function(){

            if(confirm("Məhsulu silmək istəyirsiz ?")) {
                $id = $(this).data("id");
                $btn = $(this);
                $.post("ajax.php",{
                    id:$id,
                    action:'deleteProduct'
                }).done(function(data){
                    $btn.parent().parent().remove();
                    ActionComplated("Mehsul sinlindi")
                });
            }

        })


      })
    </script>




    <?php require('../inc/footer.php'); ?>