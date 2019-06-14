<?php
if(isset($_GET['id'])){
  // Get all rows from table based on the incoming ID.
  $ID = mysqli_real_escape_string($conn, $_GET['id']);
  $sql = "SELECT * FROM cooking_recipes_table WHERE recipe_id = '$ID' ";
  
  $result = mysqli_query($conn, $sql) or die("Bad Query: $sql");
  $row = mysqli_fetch_array($result);
  
  // Sub ID will give us the foreign key to gather all sub material data.
  $subID = $row['sub_materials_id'];
  // Query to grab all sub material information for the recipe page. For each sub material grab its ID and quantitiy.
  $subSql = "SELECT material1_quantity, material1_id, material2_quantity, material2_id,
  material3_quantity, material3_id, material4_quantity, material4_id, material5_quantity,
  material5_id, rewards_id
  FROM cooking_sub_materials_table
  WHERE sub_materials_id = $subID";
  $subResult = mysqli_query($conn, $subSql) or die("Bad Query: $subSql");
  $subRow = mysqli_fetch_array($subResult);

  // Rewards ID will give us the foreign key to gather all rewards material data.
  $rewardID = $subRow['rewards_id'];
  $rewardSql = "SELECT material1_quantity,
  material1_id,
  material2_quantity,
  material2_id
  FROM cooking_rewards_table
  WHERE reward_id = $rewardID";
  
  
  $rewardResult = mysqli_query($conn, $rewardSql) or die("Bad Query: $rewardSql");
  $rewardRow = mysqli_fetch_array($rewardResult);
  
  /* Query that will check if the recipe will reward 1 item or a possibility of a 2nd.
  * Every succesfful find will increase sum_of_rewards by one, letting us know how many rewards there are.
  */ 
  $rewardAmountSql = "SELECT
  ((CASE WHEN material1_quantity IS NOT NULL THEN 1 ELSE 0 END)
  + (CASE WHEN material1_id IS NOT NULL THEN 1 ELSE 0 END)
  + (CASE WHEN material2_quantity IS NOT NULL THEN 1 ELSE 0 END)
  + (CASE WHEN material2_id IS NOT NULL THEN 1 ELSE 0 END)) AS sum_of_rewards
  FROM cooking_rewards_table
  WHERE reward_id = $rewardID";

  
  $rewardAmountResult = mysqli_query($conn, $rewardAmountSql) or die("Bad Query: $rewardAmountSql");
  $rewardAmountRow = mysqli_fetch_array($rewardAmountResult);

  /* Query that will check if the amount of sub materials it has.
  * Every succesfful find will increase sum_of_sub_materialss by one, letting us know how many sub materials there are.
  */
  $nullSql = "SELECT
  ((CASE WHEN material1_quantity IS NOT NULL THEN 1 ELSE 0 END)
  + (CASE WHEN material1_id IS NOT NULL THEN 1 ELSE 0 END)
  + (CASE WHEN material2_quantity IS NOT NULL THEN 1 ELSE 0 END)
  + (CASE WHEN material2_id IS NOT NULL THEN 1 ELSE 0 END)
  + (CASE WHEN material3_quantity IS NOT NULL THEN 1 ELSE 0 END)
  + (CASE WHEN material3_id IS NOT NULL THEN 1 ELSE 0 END)
  + (CASE WHEN material4_quantity IS NOT NULL THEN 1 ELSE 0 END)
  + (CASE WHEN material4_id IS NOT NULL THEN 1 ELSE 0 END)
  + (CASE WHEN material5_quantity IS NOT NULL THEN 1 ELSE 0 END)
  + (CASE WHEN material5_id IS NOT NULL THEN 1 ELSE 0 END)) AS sum_of_sub_materials
  FROM cooking_sub_materials_table
  WHERE sub_materials_id = $subID";
  
  $nullResult = mysqli_query($conn, $nullSql) or die("Bad Query: $nullSql");
  $nullRow = mysqli_fetch_array($nullResult);

  // Function to get the material name given the material ID, parameter to connect to the database.
  function getMaterialName($sent_material_id, $connection){

    $materialSql = "SELECT material_name FROM materials_table WHERE material_id = $sent_material_id";
    $materialResult = mysqli_query($connection, $materialSql) or die("Bad Query: $materialSql");
    $materialRow = mysqli_fetch_array($materialResult);
    return $materialRow['material_name'];
  }
  // Function to get the materialiamge given the material ID, parameter to connect to the database.
  function getMaterialImage($sent_material_id, $connection){
    $materialSql = "SELECT material_image FROM materials_table WHERE material_id = $sent_material_id";
    $materialResult = mysqli_query($connection, $materialSql) or die("Bad Query: $materialSql");
    $materialRow = mysqli_fetch_array($materialResult);
    return $materialRow['material_image'];
  }
  
}
?>