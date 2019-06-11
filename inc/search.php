<?php
include('connectToDatabase.php');
if(isset($_POST['q'])){
  $nav_search_value=$_POST['q'];
  $nav_sql_query = "SELECT recipe_id, recipe_name, recipe_image, 'cooking_recipes_table' AS  table_name FROM cooking_recipes_table WHERE recipe_name LIKE '%{$nav_search_value}%'
  UNION
  SELECT recipe_id, recipe_name, recipe_image, 'alchemy_recipes_table' AS  table_name FROM alchemy_recipes_table WHERE recipe_name LIKE '%{$nav_search_value}%'
  UNION
  SELECT recipe_id, recipe_name, recipe_image, 'processing_recipes_table' AS  table_name FROM processing_recipes_table WHERE recipe_name LIKE '%{$nav_search_value}%'";
  $nav_result = mysqli_query($conn, $nav_sql_query);
  if(mysqli_num_rows($nav_result) > 0){
  while ($nav_row = mysqli_fetch_assoc($nav_result)) {$nav_row['table_name'];
    if($nav_row['table_name']=='cooking_recipes_table'){
    $output .= '<li class="list_item"><span class="dropdown_list_overlay"><img src="' .$nav_row['recipe_image']. '" height="30" >' . "<a href='/Calculator/cookingDetails.php?id={$nav_row['recipe_id']}'>" .$nav_row["recipe_name"]. "</a></span></li>";
  }else if($nav_row['table_name']=='alchemy_recipes_table'){
    $output .= '<li class="list_item"><span class="dropdown_list_overlay"><img src="' .$nav_row['recipe_image']. '" height="30" >' . "<a href='/Calculator/alchemyDetails.php?id={$nav_row['recipe_id']}'>" .$nav_row["recipe_name"]. "</a></span></li>";
  }else if($nav_row['table_name']=='processing_recipes_table'){
    $output .= '<li class="list_item"><span class="dropdown_list_overlay"><img src="' .$nav_row['recipe_image']. '" height="30" >' . "<a href='/Calculator/processingDetails.php?id={$nav_row['recipe_id']}'>" .$nav_row["recipe_name"]. "</a></span></li>";
  }


  }
}else{
    $output .= '<p>Recipe Not Found</p>';
}
echo $output;
}
?>
