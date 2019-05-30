
$(document).ready(function () {


  const elements = document.getElementsByClassName("quantity");
  const quantities = [];
  for(var i=0; i<elements.length; i++) {
      quantities.push(elements[i].innerHTML);
  }

  function calculateNewQuantity(baseQuantity, desiredQuantity){
    let result = baseQuantity * desiredQuantity;
    return result;
  }
  function changeQuantities(craftQuantity){
    let tempArr = [];
    for (var i = 0; i < quantities.length; i++) {
    tempArr.push(calculateNewQuantity(quantities[i],craftQuantity.value));
    }
    for (var j = 0; j < tempArr.length; j++) {
    elements[j].innerHTML = tempArr[j];
  }
  }

let craftQuantity = document.getElementById("craft_quantity_input");

$(craftQuantity).bind('keyup input', function(){

  if(craftQuantity.value==0||craftQuantity.value.length==0 || craftQuantity.value<0){
  }else{
    changeQuantities(craftQuantity);
}

});

});
