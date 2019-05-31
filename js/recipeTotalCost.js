
const subMaterialsTotalCosts = document.getElementsByClassName("total_cost_sub_material");
const costs = [];
for(var z=0; z<subMaterialsTotalCosts.length; z++) {
  costs.push(parseInt(subMaterialsTotalCosts[z].innerHTML.trim()));
}


function calculateRecipeTotalCost(arr){
  let total = 0;
  for(var i=0; i<arr.length; i++) {
    total+=arr[i];
  }
  return total;
}

let totalCost = document.getElementById("total_recipe_cost");
totalCost.innerHTML = calculateRecipeTotalCost(costs);

function myFunction(){
  console.log("Changed");
}
