<?php 
/*
*Template Name: Edit Spare Part Sub Type Template
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
		$spare_part_type_id_en =  pll_get_term($_REQUEST["id"], 'en'); 
	    $spare_part_type_id_ar =  pll_get_term($_REQUEST["id"], 'ar');   


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
	  
	if(isset($_REQUEST['save_spare_part_type'])){  
		
		$spare_part_type = sanitize_text_field($_REQUEST['spare_part_type']);
		$spare_part_sub_type_name_en = sanitize_text_field($_REQUEST['spare_part_type_name']);
		$spare_part_sub_type_name_ar = sanitize_text_field($_REQUEST['spare_part_type_name_ar']);
 	  $ar_spare_part_type_spare = pll_get_term($spare_part_type, 'ar');	
	  	  $en_spare_part_type_spare = pll_get_term($spare_part_type, 'en');	

// Update the term itself
$args = array(
    'name' => $spare_part_sub_type_name_en,
	'parent'=>$en_spare_part_type_spare,
);
$updated_term = wp_update_term( $spare_part_type_id_en, 'spare-part-type', $args );
 
 
 
 // Update the term itself
$args = array(
    'name' => $spare_part_sub_type_name_ar,
	'parent'=>$ar_spare_part_type_spare,
);
$updated_term = wp_update_term( $spare_part_type_id_ar, 'spare-part-type', $args );
  wp_update_term(
	$spare_part_type_id_ar,
				$spare_part_type_name_ar, // Term name
				'spare-part-type', // Taxonomy name
				[
				   
					'parent' => $spare_part_type_spare, // Set parent term ID if needed; 0 means top-level
				]
			);

  
		 
		$success_msg = 'Spare Part Sub Type Updated Successfully';
	} 

	if ($spare_part_type_id_en) {
		$term = get_term($spare_part_type_id_en, 'spare-part-type'); // Replace 'spare-part-sub-type' with your actual taxonomy name if different
		if ($term && !is_wp_error($term)) {
		   $spare_part_typeen_term  = $term->name; // Outputs the translated term name
		}   
	
			} 
		$spare_part_sub_type_term  = pll_get_term($_REQUEST["id"], pll_current_language()); 
		$spare_part_sub_type_term= get_term($spare_part_sub_type_term, 'spare-part-type'); 
		$spare_part_sub_type_term_parent_term  = $spare_part_sub_type_term->parent; 
	 $ar_term = pll_get_term($_REQUEST["id"], 'ar');	
	if ($spare_part_type_id_ar) {
		$term = get_term($spare_part_type_id_ar, 'spare-part-type'); // Replace 'spare-part-sub-type' with your actual taxonomy name if different
		if ($term && !is_wp_error($term)) {
		   $spare_part_typear_term  = $term->name; // Outputs the translated term name
			}   
	
					} 
	$spare_part_type_term  = pll_get_term($_REQUEST["id"], pll_current_language()); 
	$spare_part_type_term = get_term($spare_part_type_term, 'spare-part-type'); 
	$spare_part_type_parent_term  = $spare_part_type_term->parent; 
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
					<a class="navbar-spare-part-sub-type" href="javascript:;"><?php echo pll__('Add Customer');?></a>
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
							<h4 class="card-title"><?php echo pll__('Edit Spare Part Sub Type');?></h4>
							<p class="card-category"></p>
						</div> 
						<div class="card-body">
							<form action='' method='post' class='frm-addeditspare_part_type'    enctype='multipart/form-data'>
							
						 	<div class="row">
	
		<div class="col-md-12">
		<div class="form-group">
		<label class="bmd-label-floating"><?php echo pll__('Spare Part Type');?></label>
	<select class="form-control  "  name="spare_part_type"id='spare_part_type' >
		<option value="0"></option> 
		<?php
// Get all terms from the 'spare_part_type' taxonomy at the top level (parent terms)
$spare_part_type_terms = get_terms(array(
    'taxonomy' => 'spare-part-type',
    'parent'   => 0, // Get only top-level terms
    'hide_empty' => false, // Show terms even if they have no posts
));

if (!empty($spare_part_type_terms) && !is_wp_error($spare_part_type_terms)) :
    foreach ($spare_part_type_terms as $parent_term) {
        // Display the parent term name
        $spare_part_type = esc_html($parent_term->name) ;
        $spare_part_type_id = esc_html($parent_term->term_id) ;
        
       
     
				?>
		<option value="<?php echo $spare_part_type_id;?>" <?php if( $spare_part_type_id == $spare_part_sub_type_term_parent_term) { ?>selected<?php } ?>><?php echo $spare_part_type;?></option> 
		<?php
		 
		
		
    }
 
endif;
?>
		</select>
		</div>
		</div>
		 
	
	 
	</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="bmd-label-floating"><?php echo pll__('Spare Part Sub Type name');?>(EN)</label>
											<input type="text" class="form-control  "  name="spare_part_type_name" id='spare_part_type_name' value="<?php echo $spare_part_typeen_term;?>" >
										</div>
									</div> 
									<div class="col-md-6">
										<div class="form-group">
											<label class="bmd-label-floating"><?php echo pll__('Spare Part Sub Type name');?>(AR)</label>
											<input type="text" class="form-control  "  name="spare_part_type_name_ar" id='spare_part_type_name_ar' value="<?php echo $spare_part_typear_term;?>" >
										</div>
									</div> 
	
	 
 
		 
	 

	 
 

	 


		</div>

	 
								<button type="submit" class="btn btn-primary pull-right" id="save-spare-part-sub-type" name="save_spare_part_type" onclick ='return validate_form_spare_part_type()'  ><?php echo pll__('Save Spare Part Sub Type');?></button>
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
function  validate_form_spare_part_type(){
		 error = 0

		 $('.error').remove()
 spare_part_type_name = jQuery('#spare_part_type_name').val()
  spare_part_type_name_ar = jQuery('#spare_part_type_name_ar').val()
				 if(spare_part_type_name==""){
				jQuery('#spare_part_type_name').parent().append("<span class='error'><?php echo pll__('Please Enter Spare Part Sub Type Name In English !');?></span>")
				jQuery('#spare_part_type_name').focus();
				error = 1;
			}
				 if(spare_part_type_name_ar==""){
				jQuery('#spare_part_type_name_ar').parent().append("<span class='error'><?php echo pll__('Please Enter Spare Part Sub Type Name In Arabic !');?></span>")
				jQuery('#spare_part_type_name_ar').focus();
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
    $('#spare_part_type_spare-part-sub-type').select2();
    $('#junkyard-select').select2();
   $('#spare-part-sub-type_year').select2();
 
});
</script>
