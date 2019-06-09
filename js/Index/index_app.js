
$(document).ready(function () {
  $(".card").click(function() {
    if(this.id==="processing_card"){
      window.location = "../Calculator/process.php";
    }else if(this.id==="cooking_card"){
      window.location = "../Calculator/cook.php";
    }else if(this.id==="alchemy_card"){
      window.location = "../Calculator/alchemy.php";
    }

});

});
