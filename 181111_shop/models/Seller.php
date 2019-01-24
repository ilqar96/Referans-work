<?php
class Seller
{
    // DB Stuff
  private $conn;
  private $table = 'seller';

    // Properties
  public $id;
  public $company_name;
  public $phone_num;
  public $name;



    // Constructor with DB
  public function __construct($db)
  {
    $this->conn = $db;
  }

    // Get categories
  public function read()
  {
      // Create query
    $query = 'SELECT *  FROM ' . $this->table;

      // Prepare statement
    $stmt = $this->conn->prepare($query);

      // Execute query
    $stmt->execute();

    return $stmt;
  }

    // Get Single Category
  public function read_single()
  {
    // Create query
    $query = 'SELECT * FROM  ' . $this->table . ' WHERE id = ?  LIMIT 0,1';

      //Prepare statement
    $stmt = $this->conn->prepare($query);

      // Bind ID
    $stmt->bindParam(1, $this->id);

      // Execute query
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // set properties
    $this->id = $row['id'];
    $this->company_name = $row['company_name'];
    $this->phone_num = $row['phone_num'];
    $this->name = $row['name'];

  }

  // Create Category
  public function create()
  {
    // Create Query
    $query = 'INSERT INTO ' .
      $this->table . '
    SET
      name = :name, company_name=:company_name, phone_num = :phone_num ';

  // Prepare Statement
    $stmt = $this->conn->prepare($query);

  // Clean data
    $this->company_name = htmlspecialchars(strip_tags($this->company_name));
    $this->phone_num = htmlspecialchars(strip_tags($this->phone_num));
    $this->name = htmlspecialchars(strip_tags($this->name));

  // Bind data
    $stmt->bindParam(':company_name', $this->company_name);
    $stmt->bindParam(':phone_num', $this->phone_num);
    $stmt->bindParam(':name', $this->name);

  // Execute query
    if ($stmt->execute()) {
      return true;
    }

  // Print error if something goes wrong
    printf("Error: $s.\n", $stmt->error);

    return false;
  }

  // Update Category
  public function update()
  {
    // Create Query
    $query = 'UPDATE ' .
      $this->table . '
      SET
      name = :name, company_name=:company_name, phone_num = :phone_num 
      WHERE
      id = :id';

  // Prepare Statement
    $stmt = $this->conn->prepare($query);


  // Clean data
    $this->company_name = htmlspecialchars(strip_tags($this->company_name));
    $this->phone_num = htmlspecialchars(strip_tags($this->phone_num));
    $this->name = htmlspecialchars(strip_tags($this->name));
    $this->id = htmlspecialchars(strip_tags($this->id));

  // Bind data
    $stmt->bindParam(':company_name', $this->company_name);
    $stmt->bindParam(':phone_num', $this->phone_num);
    $stmt->bindParam(':name', $this->name);
    $stmt->bindParam(':id', $this->id);
  
  // Execute query
    if ($stmt->execute()) {
      return true;
    }

  // Print error if something goes wrong
    printf("Error: $s.\n", $stmt->error);

    return false;
  }

  // Delete Category
  public function delete()
  {
    // Create query
    $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

    // Prepare Statement
    $stmt = $this->conn->prepare($query);

    // clean data
    $this->id = htmlspecialchars(strip_tags($this->id));

    // Bind Data
    $stmt->bindParam(':id', $this->id);

    // Execute query
    if ($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: $s.\n", $stmt->error);

    return false;
  }
}
