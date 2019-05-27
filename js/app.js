
$(document).ready(function () {
  console.log("Ready");
  $(".card").click(function() {
    if(this.id==="processing_card"){
      window.location = "../Calculator/process.php";
    }else if(this.id==="cooking_card"){
      window.location = "../Calculator/cook.php";
    }else if(this.id==="alchemy_card"){
      window.location = "../Calculator/alchemy.php";
    }
});

$('.autosuggest').keyup(function(){

  var search_term = $(this).val();
  $.post('../inc/search.php',{search_term: search_term}, function(data){
    console.log(data);
  });

});

});
