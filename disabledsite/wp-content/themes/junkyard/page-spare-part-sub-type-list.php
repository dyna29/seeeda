<?php 
/*
*Template Name: Spare Part Sub Type List
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
	if(isset($_REQUEST["success_msg"])){
		$success_msg = $_REQUEST["success_msg"];
	}
	if(isset($_REQUEST["error_msg"])){
		$error_msg = $_REQUEST["error_msg"];
	} 
	global $wpdb;
	$current_user = wp_get_current_user(); 
	$user_role = array();
	$user = new WP_User( get_current_user_id() );
	if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
		foreach ( $user->roles as $role )
			$user_role[] = $role;
	}
 
	if(isset($_REQUEST['id'])){
		if(get_current_user_id() !=0){
			$action = sanitize_text_field($_REQUEST['action']);
			$id = sanitize_text_field($_REQUEST['id']);
			$id = intval($id);
			$spare_part_id_en = pll_get_post($id,'en' );
			$spare_part_id_ar = pll_get_post($id,'ar' );
			if($action=="delete"){
				wp_update_post(array(
				'ID'    =>  $spare_part_id_en,
				'post_status'   =>  'trash'
				));
				wp_update_post(array(
				'ID'    =>  $spare_part_id_ar,
				'post_status'   =>  'trash'
				));
				update_post_meta(  $spare_part_id_en, 'deleted_'.date('d-m-Y_H_i_s'), get_current_user_id() );
				 
		$success_msg = pll__('Spare Part Sub Type Deleted Successfully!');
			}
		}
	}
	?> 
	<div class="main-panel">
		<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
			<div class="container-fluid">
				<div class="navbar-wrapper">
					<a class="navbar-spare-part-sub-type" href="javascript:;"><?php echo pll__('Spare Part Sub Type');?></a>
				</div>
				<button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
					<span class="sr-only">Toggle navigation</span>
					<span class="navbar-toggler-icon icon-bar"></span>
					<span class="navbar-toggler-icon icon-bar"></span>
					<span class="navbar-toggler-icon icon-bar"></span>
				</button>
				<div class="collapse navbar-collapse justify-content-end">
					<?php  get_template_part( 'left', 'header' );?> 
				</div>
			</div>
		</nav> 
		<div class="content">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12">
						<?php 	
						$page = get_page_by_title('Add Spare Part Sub Type');
						$post_id = pll_get_post( $page->ID,pll_current_language() );
						$link = get_permalink($post_id);?>
						<button type="button" class="btn btn-primary pull-right add-item" onclick="location.href='<?php echo $link;?>'">+ <?php echo pll__('Add Spare Part Sub Type');?><div class="ripple-container"></div></button> 
						<?php if($success_msg !='')
						{
						?>
							<div class="alert alert-success">
								<span>
									<b><?php echo $success_msg;?></b>
								</span>
							</div>
						<?php 
						} 
						?>
						<?php if($error_msg !='')
						{ 
						?>
							<div class="alert alert-danger">
								<span>
									<b><?php echo $error_msg;?></b>
								</span>
							</div>
						<?php 
						} 
						?>
						<div class="card">
							<div class="card-header card-header-primary">
								<h4 class="card-title"><?php echo pll__('Spare Part Sub Types');?></h4>
								<p class="card-category"></p>
							</div>
							<div class="card-body">
								<div class='filter-block'></div>
								<table class="display responsive nowrap canvas_div_pdf " id='property-contracts' foruser='<?php echo $user_role;?>'>
								<thead class=" text-primary">
									<tr>
										<th style='width:50px;'>
										<?php echo pll__('Logo');?>
										</th>  
										<th style='width:250px;'>
										<?php echo pll__('Spare Part Type');?>
										</th> 
										<th style='width:250px;'>
										<?php echo pll__('Spare Part Sub Type');?>
										</th>  
										<th style='width:250px;'>
										<?php echo pll__('Actions');?>
										</th> 
									</tr>
								</thead>
								<?php 
								
								$page = get_page_by_title('Edit Spare Part Sub Type');
								$post_id = pll_get_post( $page->ID,pll_current_language() );
								$link = get_permalink($post_id);
								// Get all terms where parent is 0
								$terms = get_terms(array(
									'taxonomy'   => 'spare-part-type',     // Replace 'spare_part_type' with your custom taxonomy name
									'hide_empty' => false,            // Get terms with a parent
									'orderby'    => 'parent',    // Order by the parent term ID
									'order'      => 'ASC',       // Ascending order
								));	

								// Check if terms are returned and loop through them
								if (!empty($terms) && !is_wp_error($terms)) {
									foreach ($terms as $term) { 
												 if ($term->parent != 0) { 
									$thumbnail = get_field('thumbnail', get_term($term->parent, 'spare-part-type'));
?>
										<tr>
											<td><img src="<?php echo $thumbnail;?>" class="list-thumb"></td>
											<td><?php echo get_term($term->parent, 'spare-part-type')->name;?></td>
											<td><?php echo $term->name;?></td>
									 
											<td><a href='<?php echo $link;?>?id=<?php echo $term->term_id;?>'><i class="material-icons">edit</i></a>&nbsp;<a href='<?php echo $dlink;?>?action=delete&id=<?php echo $term->term_id;?>' onclick="return confirm('Are you sure you want to delete the spare-part-sub-type?')"><i class="material-icons">cancel</i></a>
											</td>
										</tr>
										<?php 
									    }
} 
								}
								?>
								</table>  
							</div>
						</div>
					</div> 
				</div>
			</div>
		</div>
	<?php
endwhile;  
get_footer('user');?> 

<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script> 
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script> 
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/pdfMake/pdfmake.min.js"></script>
    <script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/pdfMake/vfs_fonts.js?v=7"></script>
    <script>
        pdfMake.fonts = {
            Roboto: {
                normal: 'Roboto-Regular.ttf',
                bold: 'Roboto-Regular.ttf',
                italics: 'Roboto-Regular.ttf',
                bolditalics: 'Roboto-Regular.ttf'
            },
            Amiri2: {
                normal: 'Amiri2-Regular.ttf',
                bold: 'Amiri2-Regular.ttf',
                italics: 'Amiri2-Regular.ttf',
                bolditalics: 'Amiri2-Regular.ttf'
            },
            GEDinar: {
                normal: 'GE-Dinar.ttf',
                bold: 'GE-Dinar.ttf',
                italics: 'GE-Dinar.ttf',
                bolditalics: 'GE-Dinar.ttf'
            }
        };
    </script>
<script type="text/javascript">//<![CDATA[
 
$(function () 
	{
 
	//buttons  'copy', 'csv', 'excel', 'pdf', 'print'
	var table =$('#property-contracts').DataTable({
		"order": [[1, "desc"]]
	});
	$('#parking-subscriptions').show()
	jQuery('.buttons-pdf').html('<img src="<?php echo get_stylesheet_directory_uri(); ?>/employee-portal/assets/img/pdf.png">')
	jQuery('.buttons-excel').html('<img src="<?php echo get_stylesheet_directory_uri(); ?>/employee-portal/assets/img/export.png">')
});
function validate_form(){

	if(jQuery('#from_date').val()==''|| jQuery('#to_date').val()==''){
		jQuery('.date-filter').append('<span class="input-error">Please enter from and to date</span>')
		return false;
	}

} 

//]]></script>