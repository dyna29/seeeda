<?php 
/*
*Template Name: Edit Wheel Lug Nut Template
*/ 
get_header('user');
			$user_role = array();
			$user = new WP_User( get_current_user_id() );
			if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
				foreach ( $user->roles as $role )
					$user_role[] = $role;
			}
if( !(in_array("junkyards_administrator", $user_role))   )
			{
			?> 
				<script>        
					document.location =  '<?php echo site_url('user-dashboard');?>';
				</script>
			<?php
			} 
while ( have_posts() ) : the_post(); 
	$success_msg=''; 
	$error_msg=''; 
	if(isset($_REQUEST["id"])){ 
	 	$en_term = pll_get_term($_REQUEST["id"], 'en'); 
 $ar_term = pll_get_term($_REQUEST["id"], 'ar');	

	}
	if(isset($_REQUEST["success_msg"])){
		$success_msg = $_REQUEST["success_msg"];
	}
	if(isset($_REQUEST["error_msg"])){
		$error_msg = $_REQUEST["error_msg"];
	} 
	global $wpdb;
	$current_user = wp_get_current_user(); 
	$user = new WP_User( get_current_user_id() );
	$user_role  =  array();
	if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
		foreach ( $user->roles as $role )
		$user_role[] = $role;
	}
	  
	if(isset($_REQUEST['save_wheel_lug_nut'])){  
			$wheel_lug_nut_name_en = sanitize_text_field($_REQUEST['wheel_lug_nut']);
		$wheel_lug_nut_name_ar = sanitize_text_field($_REQUEST['wheel_lug_nut_ar']);
 
 
	$args = array(
    'name' => $wheel_lug_nut_name_en,
	'parent'=>0,
);
$updated_term = wp_update_term( $en_term, 'wheel-lug-nut', $args );	
			 
	$args = array(
    'name' => $wheel_lug_nut_name_ar,
	'parent'=>0,
);
$updated_term = wp_update_term( $ar_term, 'wheel-lug-nut', $args );	

  
		 
			 
		$success_msg = 'Wheel Lug Nut Updated Successfully';
	} 
if ($en_term) {
    $term = get_term($en_term, 'wheel-lug-nut'); // Replace 'wheel_lug_nut' with your actual taxonomy name if different
    if ($term && !is_wp_error($term)) {
       $wheel_lug_nuten_term  = $term->name; // Outputs the translated term name
    }   

	} 

if ($ar_term) {
    $term = get_term($ar_term, 'wheel-lug-nut'); // Replace 'wheel_lug_nut' with your actual taxonomy name if different
    if ($term && !is_wp_error($term)) {
       $wheel_lug_nutar_term  = $term->name; // Outputs the translated term name
    }   

	} 
	?> 
	<style>
	a.view-document {
		width: 120px;
		display: block;
		font-weight: bold;
		text-transform: capitalize;
	}
	input#display_in_news ,input#display_on_banner  {
		width: 15px;
	}
	input.form-control.featured_image {
		opacity: 1;
		position: relative;
	 
		color: unset;
	}
	.document-item img {
		border-radius: 5px;
	}
	.document-item {
		margin-bottom: 15px;
		max-height: 100px;
		display: inline-block;
		border-radius: 5px;
		position: relative;
		margin-right: 15px;
	}

	a.delete-file-fp {
		color: red;
		font-weight: bold;
		text-transform: uppercase;
		font-size: 11px;
	}
	.element input[type=file] {
		position: relative;
	}
	div#moreImageUploadLink a {
		color: #fff;
	}

	div#moreImageUploadLink {
		background: #01c45f;
		width: 150px;
		color: #fff;
		text-align: center;
		font-weight: bold;
		border-radius: 5px;
	}
	input#floor_plans1 {
		margin-bottom: 15px;
	}
	a.delete-file {
		color: red;
		font-weight: bold;
		text-transform: uppercase;
		font-size: 11px; 
	}
	div#moreImageUploadgalleryLink {
		background: #01c45f;
		width: 150px;
		color: #fff;
		text-align: center;
		font-weight: bold;
		border-radius: 5px;    margin-top: 10px;
	}
	div#moreImageUploadgalleryLink a{
	   margin-top:10px;
		color: #fff;
		
	}
	.gallery-item {
		margin-bottom: 15px;
		max-height: 100px;
		display: block;
	}
	.form-group label {
		display: block;
	}
	a.delete-file-fp {
		color: red;
		font-weight: bold;
		text-transform: uppercase;
		font-size: 11px;
		position: absolute;
		z-index: 9;
		right: 5px;
		background: #fff;
		width: 15px;
		height: 15px;
		/* display: flex; */
		text-align: center;
		top: 5px;
		padding: 0;
		margin: 0;
		line-height: 1.5;
		border-radius: 9px;
		font-size: 10px;
	}
	.gallery-item {
		margin-bottom: 15px;
		max-height: 100px;
		display: inline-block;
		border-radius: 5px;
		position: relative;
		margin-right: 15px;
	}
	.gallery-item img {
		border-radius: 5px;
	}
	a.delete-file {
		color: red;
		font-weight: bold;
		text-transform: uppercase;
		font-size: 11px;
		color: red;
		font-weight: bold;
		text-transform: uppercase;
		font-size: 11px;
		position: absolute;
		z-index: 9;
		right: 5px;
		background: #fff;
		width: 15px;
		height: 15px;
		/* display: flex; */
		text-align: center;
		top: 5px;
		padding: 0;
		margin: 0;
		line-height: 1.5;
		border-radius: 9px;
		font-size: 10px;
	}
	.element.gallery-item {
		display: block;
	}

	input.form-control.featured_image {
		opacity: 1;
		position: relative;
	 
		color: unset;
	}

	.form-group img {
		border-radius: 5px;
	}
	h3 {
    font-size: 15px;
    font-weight: bold;
    text-transform: uppercase;
    margin-bottom: 30px;
    border: 1px solid #2f5eab;
    background: #2f5eab;
    color: #fff;
    padding: 5px;
}

/**/

.btn-zap { 
  display:block; 
  width:18px; height:18px; 
  line-height:18px; font-size:14px;
  border-radius:50%; 
  background:#aaa; color:#fff;
  margin:3px auto;
  text-align:center;
  padding:0;
} 
.btn-zap:disabled { 
  background:#aaa; color:#fff;
  opacity:.5; 
  cursor:default; }

.growTextarea { overflow:hidden; }

/*...*/

.table-editable { 
  width:100%; 
  background:#f2f2f2; 
  border:.9px solid #d2d2d2; 
  border-spacing:4px; border-collapse:separate;
}

.table-editable tbody tr:last-child td { 
  padding-bottom:14px;
}
.table-editable th,
.table-editable td {
  padding:0; 
}



.table-controls { 
  vertical-align:top; 
  text-align:center;
  padding-top: 2px; }
.table-zapper {
  width:30px;
}

.table-submit { 
  padding:2px 7px 8px 10px; }

table.table-editable-label {
    width: 100%;
    background: #f2f2f2;
    border: 0.9px solid #d2d2d2;
    border-spacing: 4px;
    border-collapse: separate;
}



	</style>
	<div class="main-panel">
		<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
			<div class="container-fluid">
				<div class="navbar-wrapper">
					<a class="navbar-wheel_lug_nut" href="javascript:;"><?php echo pll__('Add Customer');?></a>
				</div>
				<button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
					<span class="sr-only">Toggle navigation</span>
					<span class="navbar-toggler-icon icon-bar"></span>
					<span class="navbar-toggler-icon icon-bar"></span>
					<span class="navbar-toggler-icon icon-bar"></span>
				</button>
			 	<?php  get_template_part( 'left', 'header' );?> 
			</div>
		</nav>
		<div class="content">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12">
						<div class="alert alert-success" <?php if($success_msg  =='') { ?>style='display:none;'<?php  }  ?>>
							<span>
								<b><?php echo $success_msg;?></b>
							</span>
					</div>
					<div class="card">
						<div class="card-header card-header-primary">
							<h4 class="card-title"><?php echo pll__('Edit Wheel Lug Nut');?></h4>
							<p class="card-category"></p>
						</div>
						<?php 
						$_associated_junkyard = get_post_meta( $wheel_lug_nut_id_en,'_associated_junkyard',true);  
						$featuredimage = wp_get_attachment_image_src( get_post_thumbnail_id( $wheel_lug_nut_id_en ), 'full' ); 	
						?>
						<div class="card-body">
							<form action='' method='post' class='frm-addeditwheel_lug_nut'    enctype='multipart/form-data'>
						 
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="bmd-label-floating"><?php echo pll__('Wheel Lug Nut');?>(EN)</label>
											<input type="text" class="form-control  "  name="wheel_lug_nut" id='wheel_lug_nut' value="<?php echo $wheel_lug_nuten_term;?>" >
										</div>
									</div> 
									<div class="col-md-6">
										<div class="form-group">
											<label class="bmd-label-floating"><?php echo pll__('Wheel Lug Nut');?>(AR)</label>
											<input type="text" class="form-control  "  name="wheel_lug_nut_ar" id='wheel_lug_nut_ar' value="<?php echo $wheel_lug_nutar_term;?>" >
										</div>
									</div> 
	
	 
 
		 
	 

	 
 

	 


		</div>

	 
								<button type="submit" class="btn btn-primary pull-right" id="save-wheel_lug_nut" name="save_wheel_lug_nut" onclick ='return validate_form_wheel_lug_nut()'  ><?php echo pll__('Save Wheel Lug Nut');?></button>
								<div class="clearfix"></div>
							</div>
						</form>
						</div>
					</div>
				</div> 
			</div>
		</div>
	</div>
<?php
endwhile;  
get_footer('user');?> 
 

<script type="text/javascript">
function  validate_form_wheel_lug_nut(){
		 error = 0

		 $('.error').remove()
 wheel_lug_nut_name = jQuery('#wheel_lug_nut_name').val()
  wheel_lug_nut_name_ar = jQuery('#wheel_lug_nut_name_ar').val()
				 if(wheel_lug_nut_name==""){
				jQuery('#wheel_lug_nut_name').parent().append("<span class='error'><?php echo pll__('Please Enter Wheel Lug Nut Name In English !');?></span>")
				jQuery('#wheel_lug_nut_name').focus();
				error = 1;
			}
				 if(wheel_lug_nut_name_ar==""){
				jQuery('#wheel_lug_nut_name_ar').parent().append("<span class='error'><?php echo pll__('Please Enter Wheel Lug Nut Name In Arabic !');?></span>")
				jQuery('#wheel_lug_nut_name_ar').focus();
				error = 1;
			}
			
			 $(".contractor_no").each(function(){
        // Test if the div element is empty
        if($(this).is(":empty")){
            $(this).css("background", "yellow");
        }
			 })
     
			if(error ==0){
return true			}else{
	return false;
}
}
		 
	
	$(document).ready(function() {
		$("#approved_by").select2()
		$("input[id^='documents']").each(function() {
			var id = parseInt(this.id.replace("documents", ""));
			$("#documents" + id).change(function() {
				if ($("#documents" + id).val() != "") {
					$("#moreImageUploadLink").show();
				}
			});
		});
	 
	 //delete row
$(".btnDeleteRow").click(function() {
	console.log('btnDeleteRow ')
  var rowCount = $(this).closest('table').find('tbody').length;
  if (rowCount > 1) {
    $(this).closest('tbody').remove(); 
  } 
  rowCount --; 
  if (rowCount <= 1) { 
    $(document).find('.btnDeleteRow').prop('disabled', true);  
  }
});

//add row
$(".btnAddRow").click(function() { 
  var table = $(this).closest('table');
  var lastRow = table.find('tbody').last();
  console.log(lastRow)
  var newRow = lastRow.clone(true, true); 
  newRow.find('input, textarea, select').val('');
  newRow.find('.growTextarea').css('height','auto');
  newRow.insertAfter(lastRow);
  table.find('.btnDeleteRow').removeAttr("disabled");
});



// growTextarea function: use for testing that the the javascript
// is also copied when row is cloned.  to confirm, 
// type several lines into Location, add a row, & repeat

function growTextarea (i,elem) {
    var elem = $(elem);
    var resizeTextarea = function( elem ) {
        var scrollLeft = window.pageXOffset || (document.documentElement || document.body.parentNode || document.body).scrollLeft;
        var scrollTop  = window.pageYOffset || (document.documentElement || document.body.parentNode || document.body).scrollTop;  
        elem.css('height', 'auto').css('height', elem.prop('scrollHeight') );
        window.scrollTo(scrollLeft, scrollTop);
    };

    elem.on('input', function() {
        resizeTextarea( $(this) );
    });

    resizeTextarea( $(elem) );
}

$('.growTextarea').each(growTextarea);
	});
 
	function del_uploadedfpfile(){
		jQuery('.document-item-delete').val(1)
		jQuery('.document-item').hide()
		
	}
	function del_uploadedfpfile2(){
		jQuery('.document-item-delete-2').val(1)
		jQuery('.document-item-2').hide()
		
	}
 
	
	function del_file(eleId) {
		var ele = document.getElementById("delete_file" + eleId);
		ele.parentNode.removeChild(ele);
	}

</script>
<script>
$(document).ready(function() {
    // Initialize Select2
    $('#wheel_lug_nut_model').select2();
    $('#junkyard-select').select2();
   $('#wheel_lug_nut').select2();
 
});
</script>
