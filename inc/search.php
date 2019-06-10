<?php
include('connectToDatabase.php');
if(isset($_POST['q'])){
  $nav_search_value=$_POST['q'];
  $nav_sql_query = "SELECT recipe_id, recipe_name FROM cooking_recipes_table WHERE recipe_name LIKE '{$nav_search_value}%'
  UNION
  SELECT recipe_id, recipe_name FROM alchemy_recipes_table WHERE recipe_name LIKE '{$nav_search_value}%'
  UNION
  SELECT recipe_id, recipe_name FROM processing_recipes_table WHERE recipe_name LIKE '{$nav_search_value}%'";
  // $nav_sql_query = "Select * FROM cooking_recipes_table WHERE recipe_name LIKE '{$nav_search_value}%'";
  $nav_result = mysqli_query($conn, $nav_sql_query);
  $output = '<ul class="list-unstyled">';
  if(mysqli_num_rows($nav_result) > 0){
  while ($nav_row = mysqli_fetch_assoc($nav_result)) {
    
    $output .= '<li>' .$nav_row['recipe_name']. '</li>';
    
    
    // if($nav_row['table_name']=='cooking_recipes_table'){
    //   header('Location: ../Calculator/cookingDetails.php?id=' .$nav_row['recipe_id']);
    // }else if($nav_row['table_name']=='processing_recipes_table'){
    //   header('Location: ../Calculator/processingDetails.php?id=' .$nav_row['recipe_id']);
    // }else if($nav_row['table_name']=='alchemy_recipes_table'){
    //   header('Location: ../Calculator/alchemyDetails.php?id=' .$nav_row['recipe_id']);
    // }
  }
}else{
    $output .= '<li>Recipe Not Found</li>';
}
$output .= '</ul>';
echo $output;
}
?>