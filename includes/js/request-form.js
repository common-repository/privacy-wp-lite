jQuery('input[name="action"]').click(function () {
	var $selected = jQuery(this).val();
	switch ($selected) {
		case 'add_export_personal_data_request':
			jQuery('#type_of_action').val('export_personal_data');
			break;
		case 'add_remove_personal_data_request':
			jQuery('#type_of_action').val('remove_personal_data');
			break;
		default:
			// Do nothing
			break;
	}
});