<?php 
  include_once '../../config/Database.php';
  include_once '../../models/Category.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate category object
  $category = new Category($db);

  // Category read query
  $result = $category->read();
  
  // Get row count
  $num = $result->rowCount();

  // Check if any categories
  if($num > 0) {

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
          extract($row);
          echo $id;

          // Push to "data"
          // array_push($cat_arr['data'], $cat_item);
        }
  } else {
        // No Categories
       echo "no categorys found";
  }
