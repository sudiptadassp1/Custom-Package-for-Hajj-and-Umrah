(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

    // Hotel Food
    jQuery(document).ready(function($) {
        $("#hotel-container").on("change", ".food-radio", function() {
            var section = $(this).closest(".food-section"); // Find the closest food section
            var foodOptions = section.find(".food-options"); // Find the meal options within this section
    
            if ($(this).attr("id").includes("food-yes")) {
                foodOptions.show();
            } else {
                foodOptions.hide();
            }
        });

      //Setting map on onchange for makka
      $('select#makka-hotel-name-select').on('change', function(){
        var selectedOption = $(this).find('option:selected');
        
        // Retrieve the map URL from the data attribute
        var mapUrl = selectedOption.data('map-url');
        
        // Use the mapUrl as needed
        var makka_dynamic_iframe = '<iframe src="'+mapUrl+'" height="450" style="border:0; width:100%;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>'
        $('.hotel-map.makka').empty().append(makka_dynamic_iframe);
        
      })

      //Setting map on onchange for madina
      $('select#madina-hotel-name-select').on('change', function(){
        var selectedOption = $(this).find('option:selected');
        
        // Retrieve the map URL from the data attribute
        var mapUrl = selectedOption.data('map-url');
        
        // Use the mapUrl as needed
        var madina_dynamic_iframe = '<iframe src="'+mapUrl+'" height="450" style="border:0; width:100%;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>'
        $('.hotel-map.madina').empty().append(madina_dynamic_iframe);
        
      })
    });
})( jQuery );

// Appending hotel feature  and switch based on route
document.addEventListener("DOMContentLoaded", function () {
    const airRouteSelect = document.getElementById("air-route");
    const hotelContainer = document.getElementById("hotel-container");
  
    let firstFrom, firstTo, secondFrom, secondTo;
  
    // Enable first block's stay-from input and disable all others
    function resetDateFields() {
      document.querySelectorAll(".stay-input").forEach(input => {
        input.value = "";
        input.disabled = true;
      });
  
      if (firstFrom) {
        firstFrom.disabled = false;
        firstFrom.setAttribute("min", new Date().toISOString().split("T")[0]);
      }
    }
  
    // Setup dynamic date logic for the two blocks
    function setupDateLogic() {
      if (!firstFrom || !firstTo || !secondFrom || !secondTo) return;
  
      firstFrom.addEventListener("change", function () {
        if (firstFrom.value) {
          let nextDay = new Date(firstFrom.value);
          nextDay.setDate(nextDay.getDate() + 1);
          firstTo.disabled = false;
          firstTo.setAttribute("min", nextDay.toISOString().split("T")[0]);
        } else {
          firstTo.value = "";
          firstTo.disabled = true;
          secondFrom.value = "";
          secondFrom.disabled = true;
          secondTo.value = "";
          secondTo.disabled = true;
        }
      });
  
      firstTo.addEventListener("change", function () {
        if (firstTo.value) {
          let nextDay = new Date(firstTo.value);
          nextDay.setDate(nextDay.getDate() + 1);
          secondFrom.disabled = false;
          secondFrom.setAttribute("min", nextDay.toISOString().split("T")[0]);
        } else {
          secondFrom.value = "";
          secondFrom.disabled = true;
          secondTo.value = "";
          secondTo.disabled = true;
        }
      });
  
      secondFrom.addEventListener("change", function () {
        if (secondFrom.value) {
          let nextDay = new Date(secondFrom.value);
          nextDay.setDate(nextDay.getDate() + 1);
          secondTo.disabled = false;
          secondTo.setAttribute("min", nextDay.toISOString().split("T")[0]);
        } else {
          secondTo.value = "";
          secondTo.disabled = true;
        }
      });
    }
  
    // Handle air route change
    airRouteSelect.addEventListener("change", function () {
      const selectedRoute = airRouteSelect.value;
      if (!selectedRoute) return;
  
      // Assuming route is like "Makka-Madina" or "Makka-Jeddah"
      const secondStop = selectedRoute.split("-")[1].trim();
  
      // Set flex direction for visual order.
      // If second stop is "Madina", display order is: madina then makka;
      // otherwise, default order.
      hotelContainer.style.flexDirection = secondStop === "Madina" ? "column" : "column-reverse";
  
      // Explicitly set the active blocks based on the selected route.
      let firstBlock, secondBlock;
      if (secondStop === "Madina") {
        firstBlock = document.getElementById("madina-template");
        secondBlock = document.getElementById("makka-template");
      } else {
        firstBlock = document.getElementById("makka-template");
        secondBlock = document.getElementById("madina-template");
      }
  
      // Select the date inputs from the chosen blocks
      firstFrom = firstBlock.querySelector(".stay-from");
      firstTo = firstBlock.querySelector(".stay-to");
      secondFrom = secondBlock.querySelector(".stay-from");
      secondTo = secondBlock.querySelector(".stay-to");
  
      resetDateFields();  // Enable first block's stay-from input
      setupDateLogic();   // Attach event listeners for date logic
    });
  
    // Initial setup (default ordering in DOM: makka then madina)
    firstFrom = document.getElementById("makka-template").querySelector(".stay-from");
    firstTo = document.getElementById("makka-template").querySelector(".stay-to");
    secondFrom = document.getElementById("madina-template").querySelector(".stay-from");
    secondTo = document.getElementById("madina-template").querySelector(".stay-to");
  
    resetDateFields();
    setupDateLogic();
  });
  
