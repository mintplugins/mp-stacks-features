jQuery(document).ready(function($){
	
	mp_features_reset_icon_types();
		
	$("[class$='feature_icon_typeBBBBB'] select").change(function() {
		mp_features_reset_icon_types();
	});
	
	function mp_features_reset_icon_types(){
		$("[class$='feature_icon_typeBBBBB'] select>option:selected").map(function() {	
		
			var icon_type = $(this).val();
			
			//If the value of the selected option is feature_icon	
			if ( icon_type == 'feature_icon' ){
				//Show the icon field
				$(this).parent().parent().parent().find("[class$='feature_iconBBBBB']").css('display', 'block');
				//Hide the the image field
				$(this).parent().parent().parent().find("[class$='feature_imageBBBBB']").css('display', 'none');
			}
			else{
				//Hide the icon field
				$(this).parent().parent().parent().find("[class$='feature_iconBBBBB']").css('display', 'none');
				//Show the the image field
				$(this).parent().parent().parent().find("[class$='feature_imageBBBBB']").css('display', 'block');
			}
						
		});
	}
	
});