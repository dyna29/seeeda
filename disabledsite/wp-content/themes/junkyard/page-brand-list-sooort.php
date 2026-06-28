<?php 
/*
*Template Name: Brand Listsoooort
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
			$spare_part_id_en =   pll_get_term( $id, 'en' );
			$spare_part_id_ar = pll_get_term( $id, 'ar' );
			if($action=="delete"){
			wp_delete_term( $spare_part_id_en,  'brand' );
			wp_delete_term( $spare_part_id_ar,  'brand' );
				 
				 
		$success_msg = pll__('Brand Deleted Successfully!');
			}
		}
	}
	?> 
	<div class="main-panel">
		<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
			<div class="container-fluid">
				<div class="navbar-wrapper">
					<a class="navbar-brand" href="javascript:;"><?php echo pll__('Brand');?></a>
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
						$page = get_page_by_title('Add Brand');
						$post_id = pll_get_post( $page->ID,pll_current_language() );
						$link = get_permalink($post_id);?>
						<button type="button" class="btn btn-primary pull-right add-item" onclick="location.href='<?php echo $link;?>'">+ <?php echo pll__('Add Brand');?><div class="ripple-container"></div></button> 
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
								<h4 class="card-title"><?php echo pll__('Brands');?></h4>
								<p class="card-category"></p>
							</div>
							<div class="card-body">
								<div class='filter-block'></div>
								<table id="brandsTable" class="display">
        <thead>
            <tr>
                <th>Brand Name</th>
                <th>Description</th>
                <th>Sort Order</th>
                <th>Actions</th>
            </tr>
        </thead>
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
<script>
jQuery(document).ready(function ($) {
    const table = $('#brandsTable').DataTable({
        ajax: {
            url: "<?php echo admin_url('admin-ajax.php'); ?>",
            method: "POST",
            data: {
                action: "fetch_brands"
            },
            dataSrc: ''
        },
        columns: [
            { data: 'name' },
            { data: 'description' },
            { data: 'sort_order' },
            {
                data: null,
                render: function (data, type, row) {
                    return '<button class="move-up" data-id="'+row.id+'" data-order="'+row.sort_order+'">▲</button><button class="move-down" data-id="'+row.id+'" data-order="'+row.sort_order+'">▼</button>';
                }
            }
        ],
		order: [[2, 'asc']], 
    });

    // Handle sorting with up and down buttons
    $('#brandsTable').on('click', '.move-up, .move-down', function () {
        const isUp = $(this).hasClass('move-up');
        const rowId = $(this).data('id');
        const currentOrder = $(this).data('order');
        const newOrder = isUp ? currentOrder - 1 : currentOrder + 1;

        $.ajax({
            url: "<?php echo admin_url('admin-ajax.php'); ?>",
            method: "POST",
            data: {
                action: "update_brand_sort_order",
                term_id: rowId,
                sort_order: newOrder,
                currentOrder: currentOrder,
                nonce: "<?php echo wp_create_nonce('update_sort_order'); ?>"
            },
            success: function (response) {
                if (response.success) {
                    alert(response.data.message);
                    table.ajax.reload(); // Reload table data
                } else {
                    alert(response.data.message);
                }
            }
        });
    });
});
</script>