<div class="profileDashboard dashboardRight" id = "dashboard-pass">
	<div class="userpro-dashboard userpro-<?php echo $i; ?> userpro-id-<?php echo $user_id; ?> userpro-<?php echo $args['layout']; ?>" <?php userpro_args_to_data( $args ); ?>>
	<form action="" method="post" data-action="<?php echo 'edit'; ?>">
		<input type="hidden" name="user_id-<?php echo $i; ?>" id="user_id-<?php echo $i; ?>" value="<?php echo $user_id; ?>" />
<?php
		$hook_args = array_merge($args, array('user_id' => $user_id, 'unique_id' => $i));
		do_action('userpro_before_fields', $hook_args);
		for( $i=0;$i<$pass_arr_size;$i++ ){
			echo userpro_edit_field( $pass_arr[$i], $edit_fields[$pass_arr[$i]], $i, $args, $user_id );
		}
?>
	<div class="userpro-field userpro-submit userpro-column">
				
				<?php if (isset($args["edit_button_primary"]) ) { ?>
				<input type="submit" value="<?php echo $args['edit_button_primary']; ?>" class="userpro-button" />
				<?php } ?>
	</div>
	</form>
</div>
</div>
