<?php 
require("conf.php");


$query = $conn->query("select * from workers ");

$row = $query->fetchAll();

$p = $_POST["p"];

if ($p == "select") { ?>
 <?php foreach ($row as $col) : ?>
        <tr>
          <td><?php echo $col["name"]; ?></td>
          <td><?php echo $col["surname"]; ?></td>
          <td><?php echo $col["age"]; ?></td>
          <td><button   data-id="<?php echo $col["id"]; ?>" type="button" class="btn btn-primary  edit" data-toggle="modal" data-target="#editModal">edit </button></td>
          <td><button  data-id="<?php echo $col["id"]; ?>"  type="button" class="btn btn-danger delete" data-toggle="modal" data-target="#deleteModal">delete</button></td>
        </tr>
<?php endforeach; ?>

<?php 
} elseif ($p == "delete") {

  $id = $_POST["id"];

  $sql = 'DELETE FROM workers WHERE id = :id';
  $stmt = $conn->prepare($sql);
  $stmt->execute(['id' => $id]);


} elseif ($p == "selectFirst") {
  $id = $_POST["id"];
  $sql = 'SELECT * FROM workers WHERE id = :id';
  $stmt = $conn->prepare($sql);
  $stmt->execute(['id' => $id]);
  $post = $stmt->fetch();

  echo json_encode($post);
  
} elseif ($p == "edit") {
  $id = $_POST["id"];
  $name = $_POST["name"];
  $surname = $_POST["surname"];
  $age = $_POST["age"];


  $sql = "UPDATE `workers` SET `name`=:name , `surname`=:surname, `age`=:age WHERE  id=:id ";
  $stmt = $conn->prepare($sql);
  $stmt->execute([
    'id' => $id,
    'name' => $name,
    'surname' => $surname,
    'age' => $age
  ]);
} elseif ($p == "add") {
  $name = $_POST["name"];
  $surname = $_POST["surname"];
  $age = $_POST["age"];

  $sql = "INSERT INTO `workers`(`name`, `surname`, `age`) VALUES (:name,:surname,:age)";
  $stmt = $conn->prepare($sql);
  $stmt->execute([
    'name' => $name,
    'surname' => $surname,
    'age' => $age
  ]);
}


?>



