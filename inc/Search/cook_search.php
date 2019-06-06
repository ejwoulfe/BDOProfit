<?php
if(isset($_POST['recipe_name'])){
  require '../connectToDatabase.php';
  $recipesPerPage = 100;
  $search_value = $_POST['recipe_name'];
  $page = $_POST['page'] - 1;
  $firstLimit = ($page * $recipesPerPage);
  $secondLimit = $firstLimit+100;
  
  
  $pages_query = "SELECT * FROM cooking_recipes_table WHERE recipe_name LIKE '%{$search_value}%'";
  $pages_result = mysqli_query($conn, $pages_query);
  $totalRecipes=mysqli_num_rows($pages_result);
  $totalPages= ceil($totalRecipes/$recipesPerPage);
  

  
  for($i = 1; $i <= $totalPages; $i++){
    
    $output .= "<span class='pagination_link' style='cursor:pointer; padding:6px; border:1px sollid #ccc;' id='" .$i. "'>" .$i."</span>";
  }
  echo '  <div id="pagination_controls" style="border: none">' .$output. '</div>';
  echo '<tbody id="calculator_tbody">';
  $sql_query = "SELECT * FROM cooking_recipes_table WHERE recipe_name LIKE '%{$search_value}%' LIMIT $firstLimit, $secondLimit";
    $result = mysqli_query($conn, $sql_query);
    while ($row = mysqli_fetch_assoc($result)) {
      
      
      echo '<tr><td class="img_row"><img src="' .$row['recipe_image']. '" height="30" ></td>';
      echo "<td><a class='name_row' href='cookingDetails.php?id={$row['recipe_id']}'>" .$row['recipe_name']. '</td>';
  
  }
  echo '</tbody>';

  
  
}

?>
