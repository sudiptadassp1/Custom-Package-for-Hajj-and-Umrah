(function( $ ) {
	'use strict';
    $(document).ready(function () {
        // Show the traveler popup
        $(".no_of_travelers, #travelars_popup_button").on("click", function () {
            $(".travelars_wrap").toggle();
        });
    
        // Close the popup
        $(".close_popup_button").on("click", function () {
            $(".travelars_wrap").hide();
        });
    
        // Counter functionality
        $(".counter_wrap").on("click", ".decrease, .increase", function () {
            const counter = $(this).siblings(".counter");
            let count = parseInt(counter.text()) || 0;
    
            if ($(this).hasClass("decrease") && count > 0) {
                count--;
            } else if ($(this).hasClass("increase")) {
                count++;
            }
    
            counter.text(count);
    
            // Update total travelers
            updateTravelers();
        });
    
        // Update the "no_of_travelers" input
        function updateTravelers() {
            const adults = parseInt($(".adult .counter").text()) || 0;
            const children = parseInt($(".children .counter").text()) || 0;
            const infants = parseInt($(".infant .counter").text()) || 0;
    
            const totalTravelers = adults + children + infants;
            $(".no_of_travelers").val(totalTravelers + " Travellers");
        }

        // Transport open and close
        // Initially hide all sub-wrapper elements
        $(".sub_wrapper").hide();

        // Handle change event for all checkbox inputs
        $(".form-check-input").on("change", function () {
            var $this = $(this); // The clicked checkbox
            var parentWrapper = $this.closest(".parent-wrapper"); // Immediate parent wrapper
            var childWrapper = parentWrapper.find(".sub_wrapper").first(); // The sub_wrapper of the parent

            // If the checkbox is checked
            if ($this.prop("checked")) {
                // Show the corresponding child wrapper
                childWrapper.slideDown();
            } else {
                // If the checkbox is unchecked, hide its child wrapper and uncheck all child checkboxes
                childWrapper.slideUp(); // Hide the child wrapper
                childWrapper.find(".form-check-input").prop("checked", false); // Uncheck all child checkboxes
            }

            // Ensure that when a parent is unchecked, its children are hidden
            parentWrapper.siblings(".sub_wrapper").each(function() {
                if ($(this).closest(".parent-wrapper").find(".form-check-input").prop("checked") === false) {
                    $(this).slideUp();
                }
            });
        });
    });
    
})( jQuery );