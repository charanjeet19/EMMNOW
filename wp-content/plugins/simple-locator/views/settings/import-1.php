<h3 class="wpsl-step-title"><?php _e('Step 1: Upload CSV File', 'simple-locator'); ?></h3>

<?php 
// Form Notifications
if ( isset($_GET['success']) ) echo '<div class="updated"><p>' . sanitize_text_field($_GET['success']) . '</p></div>';
if ( isset($_GET['error']) ) echo '<div class="error"><p>' . sanitize_text_field($_GET['error']) . '</p></div>';
?>

<p>
	<a href="#" class="button button-primary" data-toggle-import-instructions><?php _e('Files & Limits', 'simple-locator'); ?></a>
</p>

<div class="wpsl-import-instructions" style="display:none;">
	<h4><?php _e('File Format', 'simple-locator'); ?></h4>
	<p><?php _e('File must be properly formatted CSV', 'simple-locator'); ?>. <a href="<?php echo \SimpleLocator\Helpers::plugin_url(); ?>/assets/csv_template.csv"><?php _e('View an Example Template', 'simple-locator'); ?></a></p>

	<h4><?php _e('Required Columns', 'simple-locator'); ?></h4>
	<p><?php _e('2 columns are required: a title and at least one address column. Addresses may be saved across multiple columns (street address, city, etc…), or in one column.'); ?></p>

	<h4><?php _e('Import Limits', 'simple-locator'); ?></h4>
	<p><?php _e('The Google Maps Geocoding API limits request to 2500 per 24 hour period & 5 requests per second. If your file contains over 2500 records, it may take multiple days to import. If the limit is reached, progress will be saved, and you may continue your import later.', 'simple-locator'); ?></p>
</div>
<?php
	$incomplete = $this->import_repo->incomplete();
	
	if ( $incomplete && !isset($_GET['error']) ) :
		$transient = $this->import_repo->transient();
?>
<div class="wpsl-import-instructions" style="padding-bottom:10px;">
	<h4 style="color:#d54e21;margin-bottom:15px;">
		<?php _e('You have an incomplete import. Would you like to continue the import?', 'simple-locator'); ?>
	</h4>
	<p>
		<?php 
			$out = __('File Name', 'simple-locator') . ': ' . $transient['filename']; 
			if ( $transient['mac'] ) $out .= ' <em>(' . __('Mac Formatted', 'simple-locator') . ')</em>';
			$out .= '<br>';
			$out .= __('Total Records', 'simple-locator') . ': ' . $transient['row_count'] . '<br>';
			$out .= __('Completed Records', 'simple-locator') . ': ' . $transient['complete_rows'] . '<br>';
			$out .= __('Import Errors', 'simple-locator') . ': ' . count($transient['error_rows']) . '<br>';
			echo $out;
		?>
	</p>
	<a href="options-general.php?page=wp_simple_locator&amp;tab=import&amp;step=3" class="button">
		<?php _e('Continue Import', 'simple-locator'); ?>
	</a>
	<a href="#" class="wpsl-new-import button button-primary">
		<?php _e('New Import', 'simple-locator'); ?>
	</a>
</div>
<?php endif; ?>

<form action="<?php echo admin_url('admin-post.php'); ?>" method="post" enctype="multipart/form-data" class="wpsl-upload-form"<?php if ( $incomplete ) echo ' style="display:none;"';?>>
	<div class="import-notice"><strong><?php _e('Important', 'simple-locator'); ?>:</strong> <?php _e('Before running an import, make a complete backup of your database.', 'simple-locator'); ?></div>
	<p>
		<?php
		if ( $incomplete ){
			echo '<h4 style="color:#d54e21;margin-bottom:15px;font-size:15px;">' . __('New Import', 'simple-locator') . '</h4>';
		}
		?>
		<h4><?php _e('Import to Post Type', 'simple-locator'); ?></h4>
		<select name="import_post_type" style="margin-top: 10px;width:250px;">
		<?php
		foreach ( $this->field_repo->getPostTypes() as $type ){
			echo '<option value="' . $type['name'] . '">' . $type['label'] . '</option>';
		}
		?>
		</select>
	</p>
	<input type="hidden" name="action" value="wpslimportupload">
	<?php wp_nonce_field( 'wpsl-import-nonce', 'nonce' ) ?>
	
	<h4><?php _e('Choose CSV File', 'simple-locator'); ?></h4>
	<input type="file" name="file">
	
	<p style="background-color:#f2f2f2;padding:8px;">
		<label>
			<input type="checkbox" name="mac_formatted" value="true">
			<?php _e('CSV file created on Mac', 'simple-locator'); ?>
		</label>
	</p>
	<input type="submit" class="button" value="<?php _e('Upload File', 'simple-locator'); ?>">
</form>


<?php
// Display Previous Imports with options to redo, undo, and remove
$iq = new WP_Query(array(
	'post_type' => 'wpslimport',
	'posts_per_page' => -1
));
if ( $iq->have_posts() ) : $c = 1;
?>
<div class="wpsl-previous-imports">
	<h3><?php _e('Complete Imports', 'simple-locator'); ?></h3>
	<?php while ( $iq->have_posts() ) : $iq->the_post(); $data = get_post_meta(get_the_id(), 'wpsl_import_data', true); ?>
		<div class="import<?php if ( $c == 1) echo ' first';?>">
			<div class="import-title">
				<a href="#" class="button" data-import-toggle-details><?php _e('Details', 'simple-locator'); ?></a>
				<h4><?php echo get_the_title(get_the_id()) . ' ' . __('from', 'simple-locator') . ' ' . $data['filename']; ?></h4>
			</div><!-- .import-title -->
			<div class="import-body">
				<p>
					<strong><?php _e('File', 'simple-locator'); ?>:</strong> <?php echo $data['filename']; ?><br>
					<strong><?php _e('Total Posts Imported', 'simple-locator'); ?>:</strong> <?php echo $data['complete_rows']; ?><br>
					<strong><?php _e('Post Type', 'simple-locator'); ?>:</strong> <?php echo $data['post_type']; ?><br>
					<strong><?php _e('Errors', 'simple-locator'); ?>:</strong> <?php echo count($data['error_rows']); ?>
				</p>
				<p>
					<?php if ( file_exists($data['file']) ) : ?>
					<a href="#" class="button" data-redo-import="<?php echo get_the_id(); ?>">
						<?php _e('Re-Run Import', 'simple-locator'); ?>
					</a>
					<?php else : ?>
						<?php _e('The original file has been removed. This import cannot be run again automatically.', 'simple-locator');?>
					<?php endif; ?>
					<a href="#" class="button" data-remove-import="<?php echo get_the_id(); ?>">
						<?php _e('Remove Import Record', 'simple-locator'); ?>
					</a>
				</p>
				<?php if ( count($data['error_rows']) > 0 ) : ?>
				<div class="wpsl-import-details">
				<h4><?php _e('Error Log', 'simple-locator'); ?></h4>
				<table>
					<thead>
						<tr>
							<th><?php _e('Row Number', 'simple-locator'); ?></th>
							<th><?php _e('Error', 'simple-locator'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php 
						foreach($data['error_rows'] as $row){
							$out = '<tr>';
							$out .= '<td>' . $row['row'] . '</td>';
							$out .= '<td>' . $row['error'] . '</td>';
							$out .= '</tr>';
							echo $out;
						}
						?>
					</tbody>
				</table>
				</div>
				<?php endif; ?>
				<div class="import-footer">
					<p>
						<a href="#" data-undo-import="<?php echo get_the_id(); ?>" class="button-danger">
							<?php _e('Undo Import', 'simple-locator'); ?>
						</a>
						<strong><?php _e('Warning', 'simple-locator'); ?></strong>: <?php _e('Undoing an import will erase all post data created during the import.', 'simple-locator'); ?>
					</p>
				</div>
			</div><!-- .import-body -->
		</div><!-- .import -->
	<?php $c++; endwhile; ?>

	<form action="<?php echo admin_url('admin-post.php'); ?>" method="post" data-remove-import-form style="display:none;">
		<input type="hidden" name="action" value="wpslremoveimport">
		<input type="hidden" name="remove_import_id" id="remove_import_id">
		<?php wp_nonce_field( 'wpsl-import-nonce', 'nonce' ) ?>
	</form>

	<form action="<?php echo admin_url('admin-post.php'); ?>" method="post" data-redo-import-form style="display:none;">
		<input type="hidden" name="action" value="wpslredoimport">
		<input type="hidden" name="redo_import_id" id="redo_import_id">
		<?php wp_nonce_field( 'wpsl-import-nonce', 'nonce' ) ?>
	</form>

	<form action="<?php echo admin_url('admin-post.php'); ?>" method="post" data-undo-import-form style="display:none;">
		<input type="hidden" name="action" value="wpslundoimport">
		<input type="hidden" name="undo_import_id" id="undo_import_id">
		<?php wp_nonce_field( 'wpsl-import-nonce', 'nonce' ) ?>
	</form>

</div><!-- .wpsl-previous-imports -->
<?php endif; wp_reset_postdata(); // Previous Import