jQuery(document).ready(function(){
    // On page load, for every sub_wrapper, display it if any descendant checkbox is checked.
    jQuery('.sub_wrapper').each(function(){
        if(jQuery(this).find('input[type="checkbox"]:checked').length > 0){
            jQuery(this).css('display','block');
        } else {
            jQuery(this).css('display','none');
        }
    });

    // Listen for changes on any checkbox
    jQuery(document).on('change', '.form-check-input', function(){
        var $checkbox = jQuery(this);
        var isChecked = $checkbox.is(':checked');

        // Get the immediate parent wrapper for this checkbox
        var $currentParentWrapper = $checkbox.closest('.parent-wrapper');
        // Look for a direct sub_wrapper inside this parent wrapper
        var $subWrapper = $currentParentWrapper.find('> .sub_wrapper');

        // If a sub_wrapper exists:
        if($subWrapper.length){
            if(isChecked){
                // When this checkbox is checked, show its sub-wrapper
                $subWrapper.css('display','block');
            } else {
                // If unchecked, hide the sub-wrapper and uncheck all descendant checkboxes
                $subWrapper.find('input[type="checkbox"]').prop('checked', false);
                $subWrapper.css('display','none');
            }
        }

        // Update any higher-level parent checkbox if needed
        updateParentCheckbox($checkbox);
    });

    // Recursive function to update parent's checkbox state based on its descendant checkboxes
    function updateParentCheckbox($childCheckbox) {
        // Look upward: find the closest sub_wrapper that contains the child,
        // then find its parent-wrapper.
        var $parentSubWrapper = $childCheckbox.closest('.sub_wrapper');
        if($parentSubWrapper.length){
            var $parentWrapper = $parentSubWrapper.closest('.parent-wrapper');
            if($parentWrapper.length){
                var $parentCheckbox = $parentWrapper.find('> .form-check-input').first();
                // If any checkbox inside the parent's sub_wrapper is checked,
                // then check the parent and ensure its sub_wrapper is visible.
                if($parentSubWrapper.find('input[type="checkbox"]:checked').length > 0){
                    $parentCheckbox.prop('checked', true);
                    $parentSubWrapper.css('display','block');
                } else {
                    // Otherwise, uncheck the parent and hide its sub-wrapper.
                    $parentCheckbox.prop('checked', false);
                    $parentSubWrapper.css('display','none');
                }
                // Recursively update any higher-level parent.
                updateParentCheckbox($parentCheckbox);
            }
        }
    }


    // Get date object from html
    // Get the JSON string from the hidden input and parse it
    let get_date_obj = $('#hotelStayHidden').val();
    
    // Check if the value is empty or an empty array
    if(!get_date_obj || get_date_obj === "[]" ){
        console.log("No hotel stay dates provided.");
        return;
    }
    
    let hotelStay = JSON.parse(get_date_obj);
    
    // In case the parsed object is empty (or not what we expect), check its keys
    if($.isEmptyObject(hotelStay)){
        console.log("No hotel stay dates provided.");
        return;
    }
    
    // Loop through each property (location) in the hotelStay object
    for(let location in hotelStay) {
        if(hotelStay.hasOwnProperty(location)){
            let dates = hotelStay[location];
            $(`.hotel-date-range-wrap.${location} .stay-from`).val(dates.from);
            $(`.hotel-date-range-wrap.${location} .stay-to`).val(dates.to);
        }
    }
    
});
