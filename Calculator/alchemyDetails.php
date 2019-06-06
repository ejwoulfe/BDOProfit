<!DOCTYPE html>

<?php require_once('../inc/header.php');
require ('../inc/connectToDatabase.php');
require ('alchemy_get.php');

?>
<body>
  <?php require_once('../inc/navigation.php');?>

  <div id="proc_rates" class="container-fluid bg-dark">
    <div id="proc_rates_row" class="row">
      <div id="craft_quantity" class"col-sm-4">
        <div class="d-inline-block">
          <p>Craft Quantity:</p>
        </div>
        <div class="d-inline-block">
          <input id="craft_quantity_input" class="test" type="number" min="1" max="999999" value="1" data-toggle="tooltip" data-placement="bottom" title="Enter a number from 0 to 99,999,999,999">
        </div>
      </div>
      <div id="tier1_proc" class"col-sm-4">
        <div class="d-inline-block">
          <p>Tier 1 Proc Rate:</p>
        </div>
        <div class="d-inline-block">
          <p id="tier1_proc_rate">2.5</p>
        </div>

      </div>
      <div id="tier2_proc" class"col-sm-4">
      <div class="d-inline-block">
      <p>Tier 2 Proc Rate:</p>
    </div>
    <div class="d-inline-block">
    <p id="tier2_proc_rate">0.3</p>
  </div>
</div>

</div>
</div>

<div id="details_jum" class="jumbotron">
  <h1 class="display-4 text-center"><?php echo $row['recipe_name']  ?></h1>
  <div id="recipeImage"><?php echo '<img src="' .$row['recipe_image']. '" class="rounded mx-auto d-block" height="50" >' ?></div>
  <div class="row">
    <div id="recipe_materials" class="flex_table container-fluid col-lg-6">
      <table class="table table-borderless text-center">
        <tbody>

          <?php
          for ($x = 0; $x < $nullRow['sum_of_nulls']; $x+=2) {
            $y = $x +1;
            echo '<tr>
            <td class="text-center"><img src="'
            .getMaterialImage($subRow[$y], $conn).
            '"  height="30"></td"><td id="material_name" >'
            .getMaterialID($subRow[$y], $conn).
            '</td><td id="recipe_quantity" class="quantity text-right">'
            .$subRow[$x].
            '</td>
            </tr>';
          }
          ?>
        </tbody>
      </table>

    </div>

  </div>
</div>


<div id="calculations_container" class="container-fluid bg-dark">
  <div class="row">
    <div class="flex_table col-lg-6 d-flex">
      <div id="first_table_container">
        <h5 class="table_title">Recipe Costs</h5>
        <table id="first_table" class="table table-borderless text-left">
          <thead>
            <th id="image_head">

            </th>
            <th class="text-center">
              Material
            </th>
            <th class="text-center">
              Quantity
            </th>
            <th class="text-left">
              Cost Per
            </th>
            <th id="total_cost_head" class="text-center">
              Total Cost
            </th>
          </thead>
          <tbody>
            <?php
            $count = 1;
            for ($x = 0; $x < $nullRow['sum_of_nulls']; $x+=2) {

              $strCount = strval($count);
              $cost_row = "row_" . $strCount;
              $cost_field = "cost_input_row_" . $strCount;
              $cost_quantity = "cost_quantity_row_" . $strCount;
              $total_cost = "total_cost_row_" . $strCount;
              $y = $x +1;
              echo '<tr id="' . $cost_row .   '">
              <td id="image_row" class="text-center"><img src="'
              .getMaterialImage($subRow[$y], $conn).
              '"  height="30"></td><td class="text-center">'
              .getMaterialID($subRow[$y], $conn).
              '</td><td style="width:1%" id="' . $cost_quantity .   '" class="quantity text-center">'
              .$subRow[$x].
              '</td><td class="align-middle">
              <input id="' . $cost_field .   '" type="number" min="1" max="9999999999" value="" data-toggle="tooltip" data-placement="bottom" title="Enter a number from 0 to 99,999,999,999">
              </td>
              <td style="width:1%" id="' . $total_cost .   '" class="text-right")">0</td>
              </tr>';
              $count+=1;
            }
            ?>
            <tr id="recipe_total_cost_row">
              <td class="filler_1 align-middle text-center">
              </td>
              <td class="align-middle text-left">
              </td>
              <td class="align-middle">
              </td>
              <td id="testing" class="align-middle text-left">
                Total Cost:
              </td>
              <td style="width:1%" id="total_recipe_cost" class="text-right">
                0
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="flex_table col-lg-6 d-flex">
      <div id="second_table_container">
        <h5 class="table_title">Profits</h5>
        <table id="second_table" class="table table-borderless text-left">
          <thead>
            <th class="text-center">
                Quantity
            </th>
            <th id="image_head">
            </th>
            <th class="text-left">
              Recipe Reward
            </th>
            <th class="text-left">
              MP Price
            </th>
            <th id="total_cost_head" class="text-center">
              Profit
            </th>
          </thead>
          <tbody>
            <?php
            $count = 1;
            for ($i = 0; $i < $rewardAmountRow['sum_of_rewards']; $i+=2) {
              $strCount = strval($count);
              $profit_row = "row_" . $strCount;
              $profit_field = "profit_input_row_" . $strCount;
              $profit_quantity = "profit_quantity_row_" . $strCount;
              $total_profit = "total_profit_row_" . $strCount;
              $y = $i +1;
              echo '<tr id="' . $profit_row .   '">
              <td style="width:1%" id="' . $profit_quantity .   '" class="reward_quantity text-right")">0</td>
              <td id="profit_image_row" class="align-middle text-center"><img src="'
              .getMaterialImage($rewardRow[$y], $conn).
              '"  height="30"></td><td class="align-middle text-left">'
              .getMaterialID($rewardRow[$y], $conn).
              '</td><td class="align-middle">
              <input id="' . $profit_field .   '" type="number" min="1" max="9999999999" value="" data-toggle="tooltip" data-placement="bottom" title="Enter a number from 0 to 99,999,999,999">
              </td>
              <td style="width:1%" id="' . $total_profit .   '" class="text-right")">0</td>';
              $count+=1;
            }
            ?>
            <tr>
              <td class="filler_1">
              </td>
              <td>
              </td>
              <td>
              </td>
              <td class="align-middle text-right">
                Total Profit:
              </td>
              <td id="total_recipe_profit" class="align-middle text-right">
                0
              </td>
            </tr>

          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>





<script  src="https://code.jquery.com/jquery-3.4.1.js"  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="../js/Details/quantities.js"></script>
<script src="../js/Details/app.js"></script>


</body>
</html>
