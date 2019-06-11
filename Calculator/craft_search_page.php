<!DOCTYPE html>

<?php 
session_start();
require_once('../inc/header.php');
$craftHeader = "";
$craftTitle = "";
if($_SESSION['craftType']=="Cooking"){
    $craftTitle = "Cooking";
    $craftHeader = "cook";
}else if($_SESSION['craftType']=="Processing"){
  $craftTitle = "Processing";
  $craftHeader = "process";
}else if($_SESSION['craftType']=="Alchemy"){
  $craftTitle = "Alchemy";
$craftHeader = "mix";
}
?>


<body>
  <?php require_once('../inc/navigation.php');?>



  <div id="calc_jum" class="jumbotron ">
    <h1 class="display-4 text-center"><?php  echo $craftTitle ?> Calculator</h1>
    <p class="h5 text-center">What are you looking to <?php  echo $craftHeader ?>?</p>
    <div id="calc_search_bar" class="col-md-8">
      <form class="form-inline">
        <div class="input-group mb-3">
          <input id="bar" type="text" class="form-control" placeholder="Search for Recipe" aria-label="cook search" aria-describedby="basic-addon2">
          <!-- <div class="input-group-append">
            <button id="btn" class="btn btn-outline-secondary" type="submit">
              <i class="fa fa-search"></i>
            </button>
          </div> -->
        </div>
      </form>
    </div>
  </div>



  <div id="calculator_main_content" class="container-fluid">
    <!-- <table id="calculator_table" class="table table-borderless text-center">



    </table> -->
  </div>





  <script  src="https://code.jquery.com/jquery-3.4.1.js"  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="../js/Calc/search_page.js"></script>
</body>
</html>
