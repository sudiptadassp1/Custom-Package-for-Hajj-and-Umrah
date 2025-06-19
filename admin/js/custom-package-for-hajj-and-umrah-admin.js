//JS code for settings page tab
// Ensure DOM is loaded before running the script
document.addEventListener("DOMContentLoaded", () => {
	const tabs = document.querySelectorAll('.settings_tab');
	const contents = document.querySelectorAll('.settings_content');

	tabs.forEach(tab => {
		tab.addEventListener('click', () => {
		// Remove active class from all tabs and contents
		tabs.forEach(t => t.classList.remove('active'));
		contents.forEach(c => c.classList.remove('active'));

		// Add active class to clicked tab and its content
		tab.classList.add('active');
		document.getElementById(`settings_tab-${tab.dataset.tab}`).classList.add('active');
		});
	});
});


(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
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


	
	$(document).ready(function () {
		function save_settings_date_via_ajax(name, data){
			// Send data via AJAX
            $.ajax({
                url: adminAjax.ajaxurl,
                method: 'POST',
                data: {
                    action: 'save_package_options',
                    name: name,
                    data: data,
                    package_nonce: adminAjax.nonce
                },
                success: function (response) {
                    if (response.success) {
						$('.'+name+".notification_success").empty().append('Data saved successfully');
						location.reload();
                    } else {
						$('.'+name+".notification_error").empty().append('Failed to save options');
                    }
                },
                error: function () {
                    alert('AJAX request failed');
                }
            });
			
		};

		//Get all the options
		$('.save_settings_option').on('click', function () {
			const selectedOptions = {};
            
            // Get all checked checkboxes
            $('input[name="package_option"]:checked').each(function () {
                const value = $(this).val();        // Get the value
                selectedOptions[value] = true;        // Add to the object
            });

            save_settings_date_via_ajax("selected_options", selectedOptions);
		});

		//Get all the settings
		$('.save_settings_settings').on('click', function () {
			const selectedSettings = {};
			const transportUseSettings = {};
            
            // Get all checked checkboxes
            $('input[name="package_settings"]:checked').each(function () {
                const value = $(this).val();        // Get the value
                selectedSettings[value] = true;        // Add to the object
            });

			$('input[name="trnsport_settings"]:checked').each(function () {
                const value = $(this).val();        // Get the value
                transportUseSettings[value] = true;        // Add to the object
            });


            save_settings_date_via_ajax("selected_settings", selectedSettings);
            save_settings_date_via_ajax("transport_seater", $('#settings-car-seater-option').val());
            save_settings_date_via_ajax("transport_use_settings", transportUseSettings);
            save_settings_date_via_ajax("edit-url", $('#edit-url-input').val());
		});

		// Show modal
		$('.custom_package_view_details').click(function() {
			var id = $(this).data('id');
			$('.' + id).fadeIn();
			$('.' + id).find('.custom-model-inner').addClass('model-open');
		});
	
		// Close modal
		$(document).on('click', '.close-btn, .bg-overlay', function() {
			$(this).closest('.custom-model-main').fadeOut();
		});
	
		// Prevent closing when clicking inside modal content
		$(document).on('click', '.custom-model-wrap', function(e) {
			e.stopPropagation();
		});

		$('.backend_custom_package_status').on('change', function(){
			$.ajax({
                url: adminAjax.ajaxurl,
                method: 'POST',
                data: {
                    action: 'save_submitted_package_status',
                    data: {
						status: $(this).val(),
						package_id: $(this).data('id')
					}
                },
                success: function (response) {
					alert(response.data);
                },
                error: function () {
                    alert('AJAX request failed');
                }
            });
			
		})
	});

	

})( jQuery );


