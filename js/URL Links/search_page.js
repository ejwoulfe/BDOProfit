$(document).ready(function() {
  
  function getAbsolutePath() {
      var loc = window.location;
      var pathName = loc.pathname.substring(loc.pathname.lastIndexOf('/') + 1, loc.pathname.length);

      return pathName;
  }

$(".calculator_links").click(function() {
  if(this.id==="processing_card"){
    $.ajax({
   type: 'POST',
   url: 'index.php',
   data: {sendCellValue: "Processing"}
});
    window.location.href = '../Calculator/craft_search_page.php';
  }else if(this.id==="processing_button"){
    $.ajax({
   type: 'POST',
   url: getAbsolutePath(),
   data: {sendCellValue: "Processing"}
});
  
  window.location.href = '../Calculator/craft_search_page.php';
  }else if(this.id==="cooking_card"){
    $.ajax({
   type: 'POST',
   url: 'index.php',
   data: {sendCellValue: "Cooking"}
});
    window.location.href = '../Calculator/craft_search_page.php';
  }else if( this.id==="cooking_button"){
    $.ajax({
   type: 'POST',
   url: getAbsolutePath(),
   data: {sendCellValue: "Cooking"}
});
  
  window.location.href = '../Calculator/craft_search_page.php';
}else if(this.id==="alchemy_card"){
    $.ajax({
   type: 'POST',
   url: 'index.php',
   data: {sendCellValue: "Alchemy"}
});
    window.location.href = '../Calculator/craft_search_page.php';
  }else if( this.id==="alchemy_button"){
    $.ajax({
   type: 'POST',
   url: getAbsolutePath(),
   data: {sendCellValue: "Alchemy"}
});
  
  window.location.href = '../Calculator/craft_search_page.php';
}

});


});