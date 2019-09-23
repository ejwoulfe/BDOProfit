////////////// Recipe Controller, mostly for handling the calculations. //////////////
let recipeController = (function() {
  // Object to hold the Recipes Cost
  let RecipeCosts = function(val, total) {
    this.val = val;
    this.total = total;
  };

  // Object to hold the Recipes Profits
  let RecipeProfit = function(val, total) {
    this.val = val;
    this.total = total;
  };
  // Variable that will hold the amount of sub materials the current recipe requires.
  let materialRows = $("input[id*='cost_input_row_']").length;
  // Variable that will hold the amount of reward materials when successfully crafting the current recipe.
  let rewardsRows = $("input[id*='profit_input_row_']").length;
  // Array to initialized with 0s based on the number of sub material rows.
  const costsArr = [];
  // Array to initialized with 0s based on the number of rewards rows.
  const profitsArr = [];
  for (let i = 0; i < materialRows; i++) {
    costsArr.push(0);
  }
  for (let i = 0; i < rewardsRows; i++) {
    profitsArr.push(0);
  }

  // Initialize variables to hold the quantity of crafts, the tier 1 proc rate, and the tier 2 proc rate.
  let subQuant = document.getElementsByClassName("quantity");
  let proc1 = document.getElementById("tier1_proc_rate").innerHTML;
  let proc2 = document.getElementById("tier2_proc_rate").innerHTML;

  // Array that will hold the default quantity amounts of a single craft of that recipe.
  const baseSubQuantities = [];
  const baseRewardQuantities = [];
  // When first loading the page, a recipe will be displaying the default quantity values, so grab those and store them into the corresponding array for calculations.
  for (let i = 0; i < subQuant.length; i++) {
    baseSubQuantities.push(subQuant[i].innerHTML);
  }
  baseRewardQuantities.push(proc1);
  if (rewardsRows > 1) {
    baseRewardQuantities.push(proc2);
  }

  // Data object that  will hold the recipes total cost, total profit, and the total cost/total profit from each of its materials/rewards.
  let data = {
    allItems: {
      cost: costsArr,
      profit: profitsArr
    },
    totals: {
      cost: 0,
      profit: 0
    },
    pureProfit: 0
  };
  /* Function to calculate the total cost or profit based on the corresponding material/reward.
   * Parameter type will be either a cost or a profit, to avoid mixing them and getting incorrect calculations.
   * After validating the input, we add each index's total to the final  totals within the data object.
   */
  let calculateTotal = function(type) {
    let sum = 0;
    data.allItems[type].forEach(function(index) {
      if (isNaN(index.total)) {
        sum += 0;
      } else if (!isNaN(index.total)) {
        sum += index.total;
      }
    });
    data.totals[type] = sum;
  };

  // return will be all public functions,that will be called by the App Controller
  return {
    /* Function that will create a new cost/profit based on  the parameter "type".
     * It will get which row its coming from, create a new recipe object,
     * then make the changes to the data object based off the new values.
     */
    addItem: function(type, row, val, total) {
      let newItem;
      if (type === "cost") {
        newItem = new RecipeCosts(val, total);
      } else if (type === "profit") {
        newItem = new RecipeProfit(val, total);
      }
      data.allItems[type].splice(row - 1, 1, newItem);
      return newItem;
    },
    // Function to calculate the pure profit, or the amount the user will recieve after calculating costs and profits together.
    calculateTotals: function(type) {
      // Calculate total cost of sub materials and total sale price of the recipe
      calculateTotal(type);

      // Calculate total profit
      data.pureProfit = data.totals.profit - data.totals.cost;
    },
    // Get the number of the current totals for all costs and profit
    getTotals: function() {
      return {
        costsTotal: data.totals.cost,
        marketTotal: data.totals.profit,
        profitsTotal: data.pureProfit
      };
    },
    // Calculate the new sub materials quantities based off the recipe quantity input.
    calculateSubQuantities: function(multiplier) {
      let newQuantities = [];
      for (let i = 0; i < baseSubQuantities.length; i++) {
        newQuantities.splice(i, 1, baseSubQuantities[i] * multiplier);
      }
      return newQuantities;
    },
    // Calculate the new reward materials quantities based off the recipe quantity input.
    calculateRewardQuantities: function(multiplier) {
      let newRewardQuantities = [];
      for (let i = 0; i < baseRewardQuantities.length; i++) {
        newRewardQuantities.splice(i, 1, baseRewardQuantities[i] * multiplier);
      }
      return newRewardQuantities;
    },
    // Variables that return the number of cost rows and profit rows for the current recipe.
    numOfCostRows: materialRows,
    numOfProfitRows: rewardsRows
  };
})();
////////////// End Recipe Controller //////////////

////////////// UI Controller, which will control the UI changes needed to be made //////////////
let UIController = (function() {
  // Function to change a number to a string and give it commas.
  function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  }

  return {
    // Function to get the cost input and quantity number of the row being changed.
    getInput: function(type, id) {
      let quant = document.querySelector(
        `#row_${id} #${type}_quantity_row_${id}`
      ).innerHTML;
      let cost = document.querySelector(`#row_${id} #${type}_input_row_${id}`)
        .value;
      /* Return the quantity, the cost, and the total cost of  that row.
       * Since the values for the profit rows are floats, we need to round our calculations.
       */
      return {
        quantity: quant,
        cost: cost,
        totalCost: Number(
          Math.round(parseFloat(quant) * parseInt(cost) + "e" + 0) + "e-" + 0
        )
      };
    },
    // Function that  will update current rows Total Cost/Profit HTML.
    updateRowTotal: function(type, id, total) {
      if (isNaN(total)) {
        total = 0;
      }

      document.querySelector(
        `#row_${id} #total_${type}_row_${id}`
      ).innerHTML = numberWithCommas(total);
    },
    // Function to update the sum of all costs/profits hmtl.
    updateTableTotals: function(costsTotal, marketTotal, profitsTotal) {
      document.querySelector(
        "#total_cost_profits"
      ).innerHTML = numberWithCommas(costsTotal);
      document.querySelector("#total_recipe_cost").innerHTML = numberWithCommas(
        costsTotal
      );
      document.querySelector(
        "#total_recipe_profit"
      ).innerHTML = numberWithCommas(marketTotal);
      document.querySelector(
        "#total_sales_profits"
      ).innerHTML = numberWithCommas(marketTotal);
      document.querySelector(
        "#total_profits_profits"
      ).innerHTML = numberWithCommas(profitsTotal);
    },
    // Function to update the costs quantities of the materials.
    updateSubQuantities: function(quantities) {
      let quant = document.getElementsByClassName("quantity");
      for (let i = 0; i < quantities.length; i++) {
        quant.item(i).innerHTML = quantities[i];
      }
    },
    // Function to update the profit quantities of the materials.
    updateRewardQuantities: function(quantities) {
      for (let i = 0; i < quantities.length; i++) {
        document.querySelector(
          "#profit_quantity_row_" + (i + 1)
        ).innerHTML = Number(Math.round(quantities[i] + "e" + 2) + "e-" + 2);
      }
    },
    // Function to changes the input box css when the user changes the costs/reward amount of a row.
    changeInput: function(field) {
      let row = field.id.substring(field.id.length - 1, field.id.length);

      if (field.style.backgroundColor == "") {
        field.setAttribute(
          "style",
          "background: transparent; border: none; color: transparent; outline: none; text-shadow: 0 0 0 #FA7D10;"
        );
      } else if (field.style.backgroundColor == "transparent") {
        field.setAttribute(
          "style",
          "background: default; border: default; color: default; outline: default;"
        );
      }
      $("#cost_input_row_" + row).css("width", "89%");
    },
    // Function to hide elements when user enters input, to free up space for mobile.
    hideElements: function(row) {
      var costPer = document.getElementById("cost_input_row_" + row);
      var quantity = document.getElementById("cost_quantity_row_" + row);
      var editButton = document.getElementById("edit_button_" + row);

      costPer.style.display = "none";
      quantity.style.display = "none";
      editButton.style.display = "block";

      $("#total_cost_row_" + row).animate({ right: "20%" });
    },
    // Function to show hidden elements when user presses edit button.
    showElements: function(row) {
      var costPer = document.getElementById("cost_input_row_" + row);
      var quantity = document.getElementById("cost_quantity_row_" + row);
      var editButton = document.getElementById("edit_button_" + row);

      costPer.style.display = "block";
      quantity.style.display = "block";
      editButton.style.display = "none";

      $("#cost_input_row_" + row).css("width", "89%");
      $("#total_cost_row_" + row).animate({ right: "0%" });
      $("#total_cost_row_" + row).text("0");
    },
    // Function to validate the incoming input from the costs/rewards table.
    validateInput: function(input) {
      let check = false;
      if (input === "") {
        input === 0;
      }
      if (!isNaN(input) && input.match(/^[0-9]+$/) && input <= 99999999999) {
        check = true;
      } else {
        check = false;
      }

      return check;
    }, // Function to validate the incoming input from the quantities input.
    validateCraftQuantityInput: function(input) {
      let check = false;
      if (input === "") {
        input === 0;
      }
      if (!isNaN(input) && input.match(/^[0-9]+$/) && input <= 999999) {
        check = true;
      } else {
        check = false;
      }

      return check;
    }
  };
})();
////////////// End UI Controller //////////////

////////////// App Controller, which will use both UI and Recipe Controller methods for caluclations and HTML Changes //////////////
let appController = (function(recipeCtrl, UICtrl) {
  if (
    /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
      navigator.userAgent
    )
  ) {
    //Costs
    $("input[id*='cost_input_row_']").css("width", "89%");
    $("#image_head").css("display", "none");
    $("#mat_head").text("Mats");
    $("#cost_per_head").text("Cost");
    $("#quantity_head").text("Qty");
    $("#total_cost_head").text("Total");

    // Market Place Values
    $("#quantity_head_profits").text("Qty");
    $("#reward_head").text("Rwds");
    $("#market_place_head").text("MP");
  }
  let setupEventListeners = function() {
    // Keypress Event handler for the costs tables rows input field when user presses "enter".
    $("input[id*='cost_input_row_']").on("keypress", function(event) {
      // When user presses enter, we check the validation of the input.
      if (
        (event.which === 13 || event.keyCode === 13) &&
        UICtrl.validateInput(event.target.value)
      ) {
        // Get the row number that is sending the event.
        let rowNumber = event.target.id[event.target.id.length - 1];
        // When new input, call ctrlAddRowCost to calculate the new values.
        ctrlAddRowCost(rowNumber);
        // Change the html to their new values.
        UICtrl.changeInput(event.target);
        event.target.blur();
        if (
          /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
            navigator.userAgent
          )
        ) {
          // some code..
          UICtrl.hideElements(`${rowNumber}`);
        }

        // If statement to display the tooltip when user enters in an incorrect input.
      } else if (
        (event.which === 13 || event.keyCode === 13) &&
        !UICtrl.validateInput(event.target.value)
      ) {
        let rowNumber = event.target.id[event.target.id.length - 1];
        $(`#cost_input_row_${rowNumber}`).tooltip("show");
        setTimeout(function() {
          $(`#cost_input_row_${rowNumber}`).tooltip("hide");
        }, 2000);
      }
    });

    // Click Event Listener to adjust the css based on the input fields current attributes.
    $("input[id*='cost_input_row_']").on("click", function(event) {
      if (event.target.style.backgroundColor == "transparent") {
        UICtrl.changeInput(event.target);
      }
    });

    // Focus Event Listener to change the input fields css back to normal so the user can enter in a value.
    $("input[id*='cost_input_row_']").focus(function() {
      if (event.target.style.backgroundColor == "transparent") {
        UICtrl.changeInput(event.target);
      }
    });

    $(".edit_button").click(function() {
      let rowNumber = event.target.id[event.target.id.length - 1];
      UICtrl.showElements(rowNumber);
      var inputField = $(event.target)
        .parent()
        .parent()
        .children()[2].firstElementChild;

      UICtrl.changeInput(inputField);
    });

    // Keypress Event handler for the profits tables rows input field when user presses "enter".
    $("input[id*='profit_input_row_']").on("keypress", function(event) {
      if (
        (event.which === 13 || event.keyCode === 13) &&
        UICtrl.validateInput(event.target.value)
      ) {
        // Get the row number that is sending the event.
        let rowNumber = event.target.id[event.target.id.length - 1];
        // When new input, call ctrlAddRowCost to calculate the new values.
        ctrlAddRowProfit(rowNumber);
        // Change the html to their new values.
        UICtrl.changeInput(event.target);
        event.target.blur();
        // If statement to display the tooltip when user enters in an incorrect input.
      } else if (
        (event.which === 13 || event.keyCode === 13) &&
        !UICtrl.validateInput(event.target.value)
      ) {
        let rowNumber = event.target.id[event.target.id.length - 1];
        $(`#profit_input_row_${rowNumber}`).tooltip("show");
        setTimeout(function() {
          $(`#profit_input_row_${rowNumber}`).tooltip("hide");
        }, 2000);
      }
    });

    // Click Event Listener to adjust the css based on the input fields current attributes.
    $("input[id*='profit_input_row_']").on("click", function(event) {
      if (event.target.style.backgroundColor == "transparent") {
        UICtrl.changeInput(event.target);
      }
    });

    // Focus Event Listener to change the input fields css back to normal so the user can enter in a value.
    $("input[id*='profit_input_row_']").focus(function() {
      if (event.target.style.backgroundColor == "transparent") {
        UICtrl.changeInput(event.target);
      }
    });

    //  Keypress Event Handler when the user enters a new quantitiy.
    $("#craft_quantity_input").on("keypress", function(event) {
      // Variable to hold the newly desired quantity.
      let desiredRecipeAmount = event.target.value;
      // On enter press, check the validation of the input.
      if (
        (event.which === 13 || event.keyCode === 13) &&
        UICtrl.validateCraftQuantityInput(desiredRecipeAmount)
      ) {
        // Calculate the new quantities for both costs and profits, create the appropriate recipe cost/profit object and add it to the data object.
        ctrlAddQuantities(
          recipeCtrl.calculateSubQuantities(desiredRecipeAmount),
          recipeCtrl.calculateRewardQuantities(desiredRecipeAmount)
        );
        // If statement to display the tooltip when user enters in an incorrect input.
      } else if (
        (event.which === 13 || event.keyCode === 13) &&
        !UICtrl.validateCraftQuantityInput(desiredRecipeAmount)
      ) {
        $("#craft_quantity_input").tooltip("show");
        setTimeout(function() {
          $("#craft_quantity_input").tooltip("hide");
        }, 2000);
      }
    });
  };

  /* Function to check if the recipe being looked at has a tier 2 reward to it. (Some recipes reward only 1 kind of reward, others give 2.)
   * If there is only 1 reward, hide the tier 2 proc rate display.
   */
  let checkRewardsRows = function() {
    if (recipeCtrl.numOfProfitRows === 1) {
      document
        .querySelector("#tier2_proc")
        .setAttribute("style", "display: none;");
    }
  };
  // Function to set the html values of the profit quantities, since they are based off the tier 1 and tier 2 proc rates.
  let initializeRewardQuantity = function() {
    for (let i = 1; i <= recipeCtrl.numOfProfitRows; i++) {
      document.querySelector(
        `#profit_quantity_row_${i}`
      ).innerHTML = document.querySelector(`#tier${i}_proc_rate`).innerHTML;
    }
  };

  // Function that controls all the costs calculations and UI adjustments.
  let ctrlAddRowCost = function(rowNumber) {
    let input, newItem;

    // Get the costs field input data.
    input = UICtrl.getInput("cost", rowNumber);

    if (UICtrl.validateInput(input.cost)) {
      // Add  item to recipe controller
      newItem = recipeCtrl.addItem(
        "cost",
        rowNumber,
        input.cost,
        input.totalCost
      );

      // Update the UI correspodning to the new cost and calculate the new totals.
      UICtrl.updateRowTotal("cost", rowNumber, input.totalCost);
      recipeCtrl.calculateTotals("cost");
      UICtrl.updateTableTotals(
        recipeCtrl.getTotals().costsTotal,
        recipeCtrl.getTotals().marketTotal,
        recipeCtrl.getTotals().profitsTotal
      );
    }
  };

  // Function that controls all the profits calculations and UI adjustments.
  let ctrlAddRowProfit = function(rowNumber) {
    let input, newItem;

    // Get the field input data.
    input = UICtrl.getInput("profit", rowNumber);
    if (UICtrl.validateInput(input.cost)) {
      //Add  item to recipe controller
      newItem = recipeCtrl.addItem(
        "profit",
        rowNumber,
        input.cost,
        input.totalCost
      );

      // Update the UI correspodning to the new cost and calculate the new totals.
      UICtrl.updateRowTotal("profit", rowNumber, input.totalCost);
      recipeCtrl.calculateTotals("profit");
      UICtrl.updateTableTotals(
        recipeCtrl.getTotals().costsTotal,
        recipeCtrl.getTotals().marketTotal,
        recipeCtrl.getTotals().profitsTotal
      );
    }
  };

  // Function that update the UI(costs table rows and profits table rows) based on the newly calculated quantities.
  let ctrlAddQuantities = function(newSubQuantities, newRewardQuantities) {
    UICtrl.updateSubQuantities(newSubQuantities);
    UICtrl.updateRewardQuantities(newRewardQuantities);
    for (let i = 1; i <= recipeCtrl.numOfCostRows; i++) {
      ctrlAddRowCost(i);
    }
    for (let z = 1; z <= recipeCtrl.numOfProfitRows; z++) {
      ctrlAddRowProfit(z);
    }
  };

  // Initialize the App Controller with the Event Listeners, if there is a tier 2 proc, and the rewards quantities.
  return {
    init: function() {
      setupEventListeners();
      checkRewardsRows();
      initializeRewardQuantity();
    }
  };
})(recipeController, UIController);

// Start!
appController.init();
