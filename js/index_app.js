$(".card").on("click", function(){
  if(this.id==="cooking_card"){
    window.location.href = "../Calculator/Search Page/cooking_recipes.php";
  }else if(this.id==="processing_card"){
    window.location.href = "../Calculator/Search Page/processing_recipes.php";
  }else if(this.id==="alchemy_card"){
    window.location.href = "../Calculator/Search Page/alchemy_recipes.php";
  }
  
  
  
});