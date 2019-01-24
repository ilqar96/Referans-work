<?php 

include_once '../config/Database.php';
include_once '../models/Product.php';
include_once '../models/Seller.php';
include_once '../models/Category.php';
include_once '../models/Selling_method.php';



if (isset($_POST["action"])) {

	$action = $_POST["action"];
	$database = new Database();
	$db = $database->connect();
 

	// crud operations for seller  start -----------------------------
	if ($action == "getAllSeller") {

		$seller = new Seller($db);

		$result = $seller->read();

		$num = $result->rowCount();

		$index = 1;

		if ($num > 0) {
			$rows = $result->fetchAll(PDO::FETCH_ASSOC);
			?>
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
<?php

} else {
	echo 'No Posts Found';
}

} elseif ($action == "deleteSeller") {

	$seller = new Seller($db);

	$seller->id = $_POST["id"];

	if ($seller->delete()) {
		echo '1';
	} else {
		echo "0";
	}

} elseif ($action == "addSeller") {
	$seller = new Seller($db);

	$seller->company_name = $_POST["companyName"];
	$seller->phone_num = $_POST["phoneNum"];
	$seller->name = $_POST["sellerName"];


	if ($seller->create()) {
		echo "Satıcı əlavə edildi";
	} else {
		echo "Xəta yarandı";
	}

} elseif ($action == "readSingleSeller") {
	$seller = new Seller($db);

	$seller->id = isset($_POST['id']) ? $_POST['id'] : die();

	$seller->read_single();

	$seller_arr = array(
		'company_name' => $seller->company_name,
		'phone_num' => $seller->phone_num,
		'name' => $seller->name
	);

	echo json_encode($seller_arr);

} elseif ($action == "editSeller") {

	$seller = new Seller($db);

	$seller->company_name = $_POST["companyName"];
	$seller->phone_num = $_POST["phoneNum"];
	$seller->name = $_POST["sellerName"];
	$seller->id = $_POST["id"];

	if ($seller->update()) {
		echo "Ugur";
	} else {
		echo "xeta";
	}

 // edit seller end 

// crud operations for seller  end ----------------------------------------


// crud operations for category  start ------------------------------------
} elseif ($action == "getAllCategories") {
	$cat = new Category($db);

	$result = $cat->read();
	$num = $result->rowCount();
	$index = 1;

	if ($num > 0) {
		$rows = $result->fetchAll(PDO::FETCH_ASSOC); ?>

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

<?php

}

} elseif($action=="getAllCategoryOptions"){
	$cat = new Category($db);

	$result = $cat->read();
	$num = $result->rowCount();
	$index = 1;

	if ($num > 0) {
		$rows = $result->fetchAll(PDO::FETCH_ASSOC); ?>

	<?php foreach ($rows as $col) : ?>
      <option value="<?php echo $col['id'] ?>"><?php echo $col["name"] ?></option>
	<?php endforeach; ?>
	
<?php
	}

} elseif ($action == "deleteCategory") {

	$cat = new Category($db);
	$cat->id = $_POST["id"];

	if ($cat->delete()) {
		echo "1";
	} else {
		echo "0";
	}

} elseif ($action == "addCategory") {

	$category = new Category($db);
	$category->name = $_POST["name"];
	$category->info = $_POST["info"];

	if ($category->create()) {
		echo "1";
	} else {
		echo "0";
	}


} elseif ($action == "editCategory") {

	$cat = new Category($db);
	$cat->name = $_POST["name"];
	$cat->info = $_POST["info"];
	$cat->id = $_POST["id"];

	if ($cat->update()) {
		echo "Ugurlu";
	} else {
		echo "xeta";
	}

} elseif ($action == "readSingleCategory") {
	$cat = new Category($db);
	$cat->id = isset($_POST['id']) ? $_POST['id'] : die();
	$cat->read_single();
	echo json_encode($cat);

//crud operations for category  End ------------------------------------
}elseif($action == "getAllMethods"){
	//crud operations for Method  start ------------------------------------

	$method = new Selling_method($db);

	$result = $method->read();
	$num = $result->rowCount();
	$index = 1;

	if ($num > 0) {
		$rows = $result->fetchAll(PDO::FETCH_ASSOC); ?>

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

<?php

}

} elseif($action=="getAllMethodOptions"){
	$method = new Selling_method($db);

	$result = $method->read();
	$num = $result->rowCount();
	$index = 1;

	if ($num > 0) {
		$rows = $result->fetchAll(PDO::FETCH_ASSOC); ?>
			
		<?php foreach ($rows as $col) : ?>
			<option value="<?php echo $col['id'] ?>">
				<?php echo $col["method"] ?>
			</option>
		<?php endforeach; ?>
<?php
	}

}elseif ($action == "deleteMethod") {

	$method = new Selling_method($db);

		  // Set ID to UPDATE
	$method->id = $_POST["id"];

		  // Delete post
	if ($method->delete()) {
		echo "1";
	} else {
		echo "0";
	}


} elseif ($action == "addMethod") {
	$method = new Selling_method($db);

	$method->method = $_POST["name"];

	if ($method->create()) {
		echo "1";
	} else {
		echo "0";
	}
	
} elseif ($action == "editMethod") {
	$method = new Selling_method($db);

	$method->method = $_POST["name"];
	$method->id = $_POST["id"];

	if ($method->update()) {
		echo "1";
	} else {
		echo "0";
	}

} elseif ($action == "readSingleMethod") {
	$method = new Selling_method($db);

	$method->id = isset($_POST['id']) ? $_POST['id'] : die();

	$method->read_single();

	echo json_encode($method);

//	crud operations for METHOD  END ------------------------------------
} elseif ($action == "deleteProduct") {
//	crud operations for PRODUCT  START ------------------------------------

	$product = new Product($db);

	$product->id = $_POST["id"];

	if ($product->delete()) {
		echo "Məhsul silindi";
	} else {
		echo "Xeta yarandi ";
	}
}
//	crud operations for PRODUCT  END ------------------------------------





// end action if 
} else {
	die();
}


?>