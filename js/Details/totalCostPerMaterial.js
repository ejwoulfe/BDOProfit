    function costChanged(){
      console.log("Triggered");
      var rowNumber = event.target.id[event.target.id.length -1];
      let quantityAmount = document.getElementById("quantity_row_"+rowNumber).innerHTML;
      let materialCost = document.getElementById("input_field_row_"+rowNumber).value;
      let totalCost = document.getElementById("total_cost_row_"+rowNumber);
      totalCost.innerHTML = (materialCost*quantityAmount);


    }
