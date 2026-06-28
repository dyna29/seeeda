<?php 
/*
*Template Name: Spare Part Management
*/ 
get_header('user');
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
				 
		$success_msg = pll__('Spare Part Deleted Successfully!');
			}
		}
	}
	?> 
	<div class="main-panel">
		<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
			<div class="container-fluid">
				<div class="navbar-wrapper">
					<a class="navbar-brand" href="javascript:;"><?php echo pll__('Spare Part');?></a>
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
						$page = get_page_by_title('Add Spare Part');
						$post_id = pll_get_post( $page->ID,pll_current_language() );
						$link = get_permalink($post_id);?>
						<button type="button" class="btn btn-primary pull-right add-item" onclick="location.href='<?php echo $link;?>'">+ <?php echo pll__('Add Spare Part');?><div class="ripple-container"></div></button> 
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
								<h4 class="card-title"><?php echo pll__('Spare Parts');?></h4>
								<p class="card-category"></p>
							</div>
							<div class="card-body">
								<div class='filter-block'></div>
								<table class="display responsive nowrap canvas_div_pdf " id='seeeda-list' foruser='<?php echo $user_role;?>'>
								<thead class=" text-primary">
									<tr>
										<th style='width:250px;'>
										<?php echo pll__('Name');?>
										</th> 
										<th style='width:250px;'>
										<?php echo pll__('Brand');?>
										</th> 
										<th style='width:250px;'>
										<?php echo pll__('Model');?>
										</th> 
										<th style='width:250px;'>
										<?php echo pll__('Model Year');?>
										</th> 
										<?php if( (in_array("junkyards_administrator", $user_role)) )
										{?>
										<th style='width:250px;'>
										<?php echo pll__('Store');?>
										</th> 
										<?php } ?>
										<th style='width:250px;'>
										<?php echo pll__('Actions');?>
										</th> 
									</tr>
								</thead>
								<?php 	$page = get_page_by_title('Edit Spare Part');
								$post_id = pll_get_post( $page->ID,pll_current_language() );
								$link = get_permalink($post_id);
								$dpage = get_page_by_title('Spare Part Management');
								$dpost_id = pll_get_post( $dpage->ID,pll_current_language() );
								$dlink = get_permalink($dpost_id);
								
								 if( (in_array("junkyards_administrator", $user_role)) )
										{
								$args = array(	'post_type' => array('spare-part'),
								'posts_per_page' => -1,  
								'post_status'	=>'publish',
								'orderby'   => 'ID',
								'order' => 'DESC',
								); 
										}else{
														$associated_junkyard = get_user_meta(get_current_user_id(), '_junkyard_manager_user', true); 
												$args = array(	'post_type' => array('spare-part'),
								'posts_per_page' => -1,  
								'post_status'	=>'publish',
								 'meta_query'     => [
                [
                    'key'     => '_associated_junkyard', // The meta key
                    'value'   => $associated_junkyard,                  // The meta value
                    'compare' => '=',                   // Comparison operator
                ],
            ],
								'orderby'   => 'ID',
								'order' => 'DESC',
								); 
										}
								$loop = new WP_Query($args);
								$i=0; 
								if($loop->have_posts()) {
									$online=1;
									$show_paging = 0;
									while($loop->have_posts()) : $loop->the_post();
										$i++; 
										  $terms = get_the_terms(get_the_ID(), 'brand');
									 
											foreach ($terms as $term) {
												 
												 
												// Check if the term has a parent, if not, it’s a parent level term
												if ($term->parent == 0) {
													 
													$brand =  esc_html($term->name);
													 
												}else{
													$model =  esc_html($term->name);
													 
												}
											}
										 
											 $model_year_terms = get_the_terms(get_the_ID(), 'model-year');
											if (!empty($model_year_terms) && !is_wp_error($model_year_terms)) {
												// Assuming only one model year term per spare_part
												$model_year = $model_year_terms[0]->name;
											}
											$selected_junkyard = get_post_meta($post->ID, '_associated_junkyard', true);
											?>
										<tr>
											<td><?php echo get_the_title();?></td>
											<td><?php echo $brand;?></td>
											<td><?php echo $model;?></td>
											<td><?php echo $model_year;?></td>
											<?php if( (in_array("junkyards_administrator", $user_role)) )
										{?>
											<td><?php echo get_the_title($selected_junkyard);?></td>
											<?php } ?>
											<td><a href='<?php echo $link;?>?id=<?php echo get_the_ID();?>'><i class="material-icons">edit</i></a>&nbsp;<a href='<?php echo $dlink;?>?action=delete&id=<?php echo get_the_ID();?>' onclick="return confirm('Are you sure you want to delete the spare_part?')"><i class="material-icons">cancel</i></a>
											</td>
										</tr>
										<?php 
									endwhile;
									wp_reset_postdata(); 
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
	var table =$('#seeeda-list').DataTable( {
 "order": [[0, 'desc']],   
		dom: 'Bfrtip',
		buttons: [ {
		extend: 'excelHtml5',
		autoFilter: true,
		sheetName: '<?php echo pll__('Spare Parts');?>',
		exportOptions: {
			<?php if( (in_array("junkyards_administrator", $user_role)) )
										{?>
										 columns: [0,1,2,3,4] // Specify column indices to export (e.g., first three columns)
										<?php } else { ?>
										 columns: [0,1,2,3] // Specify column indices to export (e.g., first three columns)
										<?php }  ?>
               
            },
		}   , 
 
  {
							extend: 'pdf',
						 exportOptions: {
                columns: [0,1,2,3,4] // Specify column indices to export (e.g., first three columns)
            },
							title: '<?php echo pll__('Spare Parts');?>',
							text: 'PDF', 
							titleAttr: 'PDF',
						   pageSize: 'A4',   
						   customize: function (doc) {
							for (var i = 1; i < doc.content[1].table.body.length; i++) {
                                for (var j = 0; j < doc.content[1].table.body[i].length; j++) {
                                    doc.content[1].table.body[i][j].alignment = 'center';
                                }
                            }

                            // Center align the table header content
                           // Center align the table header content
                  // Customize the table header to center the content
				  var headerRow = doc.content[1].table.body[0];
                    for (var k = 0; k < headerRow.length; k++) {
                        headerRow[k] = {
                            text: headerRow[k].text,
							alignment: 'center',
				  fillColor: '#2f5eab', // Set background color (blue)
                color: '#FFFFFF', // Set text color (white)
                bold: true, // Make the text bold
                margin: [5, 5, 5, 5] // Add padding to the cells
                        };
                    }

    // Add a header with a logo and title
    doc.content.splice(0, 0, {
        margin: [0, 0, 0, 20],
        alignment: 'center',
        image: 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAVEAAABXCAYAAAC9WHbrAAAAxXpUWHRSYXcgcHJvZmlsZSB0eXBlIGV4aWYAAHjabVBBDgMhCLz7ij5BBBWeY7vbpD/o8zsubLK2nQQYAUck7e/XM90mCkmS2rVZaxkQEysDRLNjHJ6yHP5ApWC05lPtcakgxYjsR20e6czHhTPSAKsXIX1E4b4WTEJfv4SKB54TTb6FkIUQFy9QCAz/Vm6m/fqF+55XqFuaTnQd++fcsb2t4h0uZWfiDM/cfACeJokHCgSPBBozG3hF24BZiGEh//Z0In0A73VZIrjkSZoAAAGDaUNDUElDQyBwcm9maWxlAAB4nH2RPUjDQBzFXxtF0YqDQUQcMlQnu6iIY6liESyUtkKrDiaXfkGThiTFxVFwLTj4sVh1cHHW1cFVEAQ/QJwdnBRdpMT/JYUWMR4c9+PdvcfdOyDYqDDN6ooCmm6bqXhMyuZWpZ5X9EOEgGEIMrOMRHoxA9/xdY8AX+8iPMv/3J9jQM1bDAhIxFFmmDbxBvHspm1w3icWWUlWic+JJ026IPEj1xWP3zgXXQ7yTNHMpOaJRWKp2MFKB7OSqRHPEIdVTaf8YNZjlfMWZ61SY6178heG8vpKmus0xxDHEhJIQoKCGsqowEaEVp0UCynaj/n4R11/klwKucpg5FhAFRpk1w/+B7+7tQrTU15SKAZ0vzjOxzjQsws0647zfew4zRNAeAau9La/2gDmPkmvt7XwETC4DVxctzVlD7jcAUaeDNmUXUmgGSwUgPcz+qYcMHQL9K15vbX2cfoAZKir5Rvg4BCYKFL2us+7ezt7+/dMq78fUZNymbQNUeIAAA12aVRYdFhNTDpjb20uYWRvYmUueG1wAAAAAAA8P3hwYWNrZXQgYmVnaW49Iu+7vyIgaWQ9Ilc1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCI/Pgo8eDp4bXBtZXRhIHhtbG5zOng9ImFkb2JlOm5zOm1ldGEvIiB4OnhtcHRrPSJYTVAgQ29yZSA0LjQuMC1FeGl2MiI+CiA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPgogIDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiCiAgICB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIKICAgIHhtbG5zOnN0RXZ0PSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VFdmVudCMiCiAgICB4bWxuczpkYz0iaHR0cDovL3B1cmwub3JnL2RjL2VsZW1lbnRzLzEuMS8iCiAgICB4bWxuczpHSU1QPSJodHRwOi8vd3d3LmdpbXAub3JnL3htcC8iCiAgICB4bWxuczp0aWZmPSJodHRwOi8vbnMuYWRvYmUuY29tL3RpZmYvMS4wLyIKICAgIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIKICAgeG1wTU06RG9jdW1lbnRJRD0iZ2ltcDpkb2NpZDpnaW1wOjQ3OWFmYjE2LTJjNWQtNGM2Ny05MTliLTY2NzUyZGNmMGFiMyIKICAgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpmNmU0MTJiYS1iZWI5LTQxNmEtYjE4YS1mYTg3YWEzYTkwYTYiCiAgIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDoyOWEyMDRhMS01ZDkyLTQ2MDQtYTM3NC1hNjExZDY0ZjA5OGMiCiAgIGRjOkZvcm1hdD0iaW1hZ2UvcG5nIgogICBHSU1QOkFQST0iMi4wIgogICBHSU1QOlBsYXRmb3JtPSJXaW5kb3dzIgogICBHSU1QOlRpbWVTdGFtcD0iMTczMjA3NjYyMTg4MjIwMSIKICAgR0lNUDpWZXJzaW9uPSIyLjEwLjM2IgogICB0aWZmOk9yaWVudGF0aW9uPSIxIgogICB4bXA6Q3JlYXRvclRvb2w9IkdJTVAgMi4xMCIKICAgeG1wOk1ldGFkYXRhRGF0ZT0iMjAyNDoxMToyMFQwOTo1MzozOSswNTozMCIKICAgeG1wOk1vZGlmeURhdGU9IjIwMjQ6MTE6MjBUMDk6NTM6MzkrMDU6MzAiPgogICA8eG1wTU06SGlzdG9yeT4KICAgIDxyZGY6U2VxPgogICAgIDxyZGY6bGkKICAgICAgc3RFdnQ6YWN0aW9uPSJzYXZlZCIKICAgICAgc3RFdnQ6Y2hhbmdlZD0iLyIKICAgICAgc3RFdnQ6aW5zdGFuY2VJRD0ieG1wLmlpZDo3ZWEzMGVmNi0wYzA2LTQ3NDgtOTI2ZS0zMTU2NDdhMWFjODAiCiAgICAgIHN0RXZ0OnNvZnR3YXJlQWdlbnQ9IkdpbXAgMi4xMCAoV2luZG93cykiCiAgICAgIHN0RXZ0OndoZW49IjIwMjQtMTEtMjBUMDk6NTM6NDEiLz4KICAgIDwvcmRmOlNlcT4KICAgPC94bXBNTTpIaXN0b3J5PgogIDwvcmRmOkRlc2NyaXB0aW9uPgogPC9yZGY6UkRGPgo8L3g6eG1wbWV0YT4KICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgIAo8P3hwYWNrZXQgZW5kPSJ3Ij8+AdegrgAAAAZiS0dEAP8A/wD/oL2nkwAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB+gLFAQXKd5QdrAAACAASURBVHja7L15tG1XXef7/f3mnKvZ7Tnn3nNvctMCBiQRBOWhUfEFGwoUAlXxRiRGaSSIGAwSUepZw60WpWAQJYgEA6FRquqmkOLR2L0qguUrEESsoo8JSUhy29PuvVc75/z96o+1701ASKOIOtifMc7Y595xzl7rrD3Xd/76BSxZsmTJkiVLlixZsmTJkiVLlixZsmTJkiVLlixZsmTJkiVLlixZsmTJkiVLlixZsmTJkiVLlixZsmTJEgA/8OwXP/mSK172jOWVWLJkyT8V5l/qif/g8178TUXgV2yX5Xnf+vjv/tDn/uZD0+XHuWTJkq819p/ioIcOvSTH+viM6Mtya2c+jQPjt/JPxMkTbwoAoAr65Zsm5qxpmWvac9PpbvWzl76muvd71K737K15daGI2z59dd/FAH7ni48xSWZpnqauosaX6jKRqh2oXS27jWMT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', // Replace with Base64 logo
        width: 100
    });

 // Locate the table content dynamically
 let tableIndex = doc.content.findIndex(item => item.table);
    if (tableIndex !== -1) {
        let tableContent = doc.content[tableIndex];

        // Customize table widths
        tableContent.table.widths = Array(tableContent.table.body[0].length).fill('*');

        // Align headers to the left
       /* tableContent.table.body[0].forEach(function (headerCell, index) {
            tableContent.table.body[0][index] = {
                text: headerCell.text,
                alignment: 'CENTER',
				  fillColor: '#2f5eab', // Set background color (blue)
                color: '#FFFFFF', // Set text color (white)
                bold: true, // Make the text bold
                margin: [5, 5, 5, 5] // Add padding to the cells
            };
        });*/
    } else {
        console.warn("Table content not found in PDF document structure.");
    }

    // Add a footer with text and page numbers
    doc.footer = function (currentPage, pageCount) {
        return {
            columns: [
                {
					text: 'TEL: +965 99359196 | E-MAIL: info@seeeda.com',
                    alignment: 'left',
                    margin: [10, 0]
                },
                {
                    text: 'Page ' + currentPage + ' of ' + pageCount,
                    alignment: 'right',
                    margin: [0, 0, 10, 0]
                }
            ]
        };
    };

    // Set page margins
    doc.pageMargins = [10, 70, 10, 50];
}
						},
		],
		     "columnDefs": [
                    {
                        "targets": 0,  // Targeting the first column (dates)
                        "render": function(data, type, row) {
                            if (type === 'sort') {
                                // Convert the date to YYYY-MM-DD format for sorting
                                var dateParts = data.split('-');
                                return dateParts[2] + '-' + dateParts[1] + '-' + dateParts[0]; // Convert dd-mm-yyyy to yyyy-mm-dd
                            }
                            return data;  // Return original data for display
                        }
                    }
                ],
		"bPaginate": true, 
		"pageLength": 50,
		"bLengthChange": false,
		"bFilter": true,
		"bInfo": false,
		"bAutoWidth": false,
		"initComplete": function( settings, json ) {
		$('#example_filter').html('');
		$('#example_paginate').html('');
		c = 0;
	 
		}
	});
	$('#parking-subscriptions').show()
	jQuery('.buttons-pdf').html('<img src="<?php echo get_stylesheet_directory_uri(); ?>/employee-portal/assets/img/pdf.png">')
	jQuery('.buttons-excel').html('<img src="<?php echo get_stylesheet_directory_uri(); ?>/employee-portal/assets/img/export.png">')
});

 </script>