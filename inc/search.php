<?php
require '../Calculator/connectToDatabase.php';

if(isset($_POST['search_term']) == true && empty($_POST['search_term']) == false){
  $search_value = mysqli_real_escape_string($_POST['search_term']);
  $nav_sql_query = "SELECT recipe_name FROM cooking_recipes_table WHERE recipe_name LIKE '$search_value%' ";
  $nav_result = mysqli_query($conn, $nav_sql_query) or die("Bad Query: $nav_sql_query");
          while ($row = mysqli_fetch_assoc($nav_result) {
            echo '<li>' .$row['recipe_name'].    '</li>';
          }
}

 ?>
