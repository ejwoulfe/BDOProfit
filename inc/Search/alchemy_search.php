<?php
require '../connectToDatabase.php';

$search_value = $_POST['recipe_name'];
$sql_query = "SELECT * FROM alchemy_recipes_table WHERE recipe_name LIKE '%".$search_value."%'";
  $result = mysqli_query($conn, $sql_query);
  while ($row = mysqli_fetch_assoc($result)) {
    echo '<tr><td><img src="' .$row['recipe_image']. '" height="30" ></td>';
    echo "<td><a href='alchemyDetails.php?id={$row['recipe_id']}'>" .$row['recipe_name']. '</td>';

}

 ?>
