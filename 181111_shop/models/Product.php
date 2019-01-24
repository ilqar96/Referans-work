<?php 
class Product
{
    // DB stuff
  private $conn;
  private $table = 'products';

    // Properties
  public $id;
  public $name;
  public $category_id;
  public $selling_method_id;
  public $purchase_price;
  public $sale_price;
  public $seller_id;
  public $info;

    // Constructor with DB
  public function __construct($db)
  {
    $this->conn = $db;

  }

    // Get Posts
  public function read()
  {
      // Create query
    $query = 'SELECT p.id, p.name as product_name , c.name as category_name, m.method , p.purchase_price , round(((`p`.`purchase_price` * 0.10) + `p`.`purchase_price`),1) AS `suggested_price`, p.sale_price ,s.company_name, s.name as seller_name
      FROM products AS p 
      INNER JOIN category AS c ON p.category_id = c.id
      INNER JOIN selling_method AS m ON p.selling_method_id = m.id
      INNER JOIN seller AS s ON p.seller_id = s.id
      ORDER BY p.id DESC';
      
      // Prepare statement
    $stmt = $this->conn->prepare($query);

      // Execute query
    $stmt->execute();

    return $stmt;
  }

    // Get Single Post
  public function read_single()
  {
          // Create query
    $query = 'SELECT * FROM products WHERE id = ?  LIMIT 0,1';

          // Prepare statement
    $stmt = $this->conn->prepare($query);

          // Bind ID
    $stmt->bindParam(1, $this->id);

          // Execute query
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

          // Set properties
    $this->name = $row['name'];
    $this->category_id = $row['category_id'];
    $this->selling_method_id = $row['selling_method_id'];
    $this->purchase_price = $row['purchase_price'];
    $this->sale_price = $row['sale_price'];
    $this->seller_id = $row['seller_id'];
    $this->info = $row['info'];

  }

    // Create Post
  public function create()
  {
          // Create query
    $query = 'INSERT INTO ' . $this->table . ' SET name = :name, category_id= :category_id,    selling_method_id = :selling_method_id,purchase_price = :purchase_price ,sale_price = :sale_price ,seller_id = :seller_id ,info = :info';

          // Prepare statement
    $stmt = $this->conn->prepare($query);

          // Clean data
    $this->name = htmlspecialchars(strip_tags($this->name));
    $this->category_id = htmlspecialchars(strip_tags($this->category_id));
    $this->selling_method_id = htmlspecialchars(strip_tags($this->selling_method_id));
    $this->purchase_price = htmlspecialchars(strip_tags($this->purchase_price));
    $this->sale_price = htmlspecialchars(strip_tags($this->sale_price));
    $this->seller_id = htmlspecialchars(strip_tags($this->seller_id));
    $this->info = htmlspecialchars(strip_tags($this->info));

          // Bind data
    $stmt->bindParam(':name', $this->name);
    $stmt->bindParam(':category_id', $this->category_id);
    $stmt->bindParam(':selling_method_id', $this->selling_method_id);
    $stmt->bindParam(':purchase_price', $this->purchase_price);
    $stmt->bindParam(':sale_price', $this->sale_price);
    $stmt->bindParam(':seller_id', $this->seller_id);
    $stmt->bindParam(':info', $this->info);


          // Execute query
    if ($stmt->execute()) {
      return true;
    }

      // Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);

    return false;
  }

    // Update Post
  public function update()
  {
          // Create query
    $query = "UPDATE `products` SET `name`= :name ,`category_id`=:category_id,`selling_method_id`= :selling_method_id,`purchase_price`=:purchase_price,`sale_price`=:sale_price,`seller_id`=:seller_id,`info`=:info WHERE id = :id ";

          // Prepare statement
    $stmt = $this->conn->prepare($query);

         // Clean data
    $this->name = htmlspecialchars(strip_tags($this->name));
    $this->category_id = htmlspecialchars(strip_tags($this->category_id));
    $this->selling_method_id = htmlspecialchars(strip_tags($this->selling_method_id));
    $this->purchase_price = htmlspecialchars(strip_tags($this->purchase_price));
    $this->sale_price = htmlspecialchars(strip_tags($this->sale_price));
    $this->seller_id = htmlspecialchars(strip_tags($this->seller_id));
    $this->info = htmlspecialchars(strip_tags($this->info));
    $this->id = htmlspecialchars(strip_tags($this->id));

         // Bind data
    $stmt->bindParam(':name', $this->name);
    $stmt->bindParam(':category_id', $this->category_id);
    $stmt->bindParam(':selling_method_id', $this->selling_method_id);
    $stmt->bindParam(':purchase_price', $this->purchase_price);
    $stmt->bindParam(':sale_price', $this->sale_price);
    $stmt->bindParam(':seller_id', $this->seller_id);
    $stmt->bindParam(':info', $this->info);
    $stmt->bindParam(':id', $this->id);

          // Execute query
    if ($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);

    return false;
  }

    // Delete Post
  public function delete()
  {
          // Create query
    $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

          // Prepare statement
    $stmt = $this->conn->prepare($query);

          // Clean data
    $this->id = htmlspecialchars(strip_tags($this->id));

          // Bind data
    $stmt->bindParam(':id', $this->id);

          // Execute query
    if ($stmt->execute()) {
      return true;
    }

          // Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);

    return false;
  }

  public function filterAllCol($searchText)
  {

    $query = "SELECT p.id, p.name as product_name , c.name as category_name, m.method , p.purchase_price , round(((`p`.`purchase_price` * 0.10) + `p`.`purchase_price`),1) AS `suggested_price`, p.sale_price ,s.company_name, s.name as seller_name
      FROM products AS p 
      INNER JOIN category AS c ON p.category_id = c.id
      INNER JOIN selling_method AS m ON p.selling_method_id = m.id
      INNER JOIN seller AS s ON p.seller_id = s.id
      WHERE CONCAT( p.name,c.name,m.method,s.company_name,s.name)
      LIKE '%$searchText%' ";
      
      // Prepare statement
    $stmt = $this->conn->prepare($query);

      // Execute query
    $stmt->execute();

    return $stmt;
  }

}

   