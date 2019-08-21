<!DOCTYPE html>

<?php require_once('../../Includes/header.php');?>


<body>
  <?php require_once('../../Includes/navigation.php');?>

  <!-- Jumbotron -->
  <div id="calc_jum" class="jumbotron ">
    <h1 class="display-4 text-center">Cooking Calculator</h1>
    <p class="h5 text-center">What are you looking to cook?</p>
    
    <!-- Search Bar -->
    <div id="calc_search_bar" class="col-md-8">
      <form action="" class="form-inline" id="cooking_form">
        <div class="input-group mb-3" >
          <input id="bar" type="text" class="form-control" placeholder="Search for Recipe" aria-label="cook search" aria-describedby="basic-addon2">
        </div>
      </form>
    </div>
    <!-- Search Bar End -->
    
  </div>
  <!-- Jumbotron End -->


  <!-- Recipes Table -->
  <div id="calculator_main_content" class="container-fluid">

  </div>
  <!-- Recipes Table End -->



  <script  src="https://code.jquery.com/jquery-3.4.1.js"  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="cooking_search.js"></script>
</body>
</html>
