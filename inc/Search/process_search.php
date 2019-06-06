<?php
require '../connectToDatabase.php';

$search_value = $_POST['recipe_name'];
$sql_query = "SELECT * FROM processing_recipes_table WHERE recipe_name LIKE '%".$search_value."%'";
  $result = mysqli_query($conn, $sql_query);
  while ($row = mysqli_fetch_assoc($result)) {
    $totalRecipes=mysqli_num_rows($result);
    $totalRows= ceil($rowCount/$recipesPerPage);
    if($totalRecipes < 1){
      $totalRecipes = 1;
    }
    echo '<tr><td><img src="' .$row['recipe_image']. '" height="30" ></td>';
    echo "<td><a href='processingDetails.php?id={$row['recipe_id']}'>" .$row['recipe_name']. '</td>';

}

 ?>
