// custom-admin.js
 jQuery(document).ready(function($) {
            // Initialize Select2 on the brand dropdown
			if(   jQuery('#brand-dropdown').length){
            // Initialize Select2
			$('#brand-dropdown').select2({
				placeholder: "Select a Brand",
				allowClear: true,
				width: '100%'  // Ensures the dropdown uses full width of the container
			});
			}
        });

 