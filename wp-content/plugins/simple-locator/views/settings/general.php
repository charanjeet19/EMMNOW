<?php 
settings_fields( 'wpsimplelocator-general' ); 
$location_btn = get_option('wpsl_geo_button');
if ( !isset($location_btn['enabled']) || $location_btn['enabled'] == "" ) $location_btn['enabled'] = false;
if ( !isset($location_btn['text']) || $location_btn['text'] == "" ) $location_btn['text'] = __('Use my location', 'simple-locator');
?>

</table>

<div class="wpsl-settings-general-head">
	<h3><?php _e('Google Maps API Key', 'simple-locator'); ?></h3>
	<p><?php _e('As of June 2016, all websites using the Google Maps API require a valid API key.', 'simple-locator'); ?> <a href="https://developers.google.com/maps/documentation/javascript/tutorial#api_key" target="_blank"><?php _e('How to obtain an API key', 'simple-locator'); ?></a></p>
	<p>
		<strong><label for="wpsl_google_api_key"><?php _e('Google Maps Javascript API V3 Key (public)', 'simple-locator');?></label></strong><br>
		<input type="text" name="wpsl_google_api_key" id="wpsl_google_api_key" value="<?php echo get_option('wpsl_google_api_key'); ?>" />
	</p>
	<p><?php _e('Use of the built-in importer requires a server API key with the Geocoding API enabled. This should not be a public key. It should be a server key, with your server\'s IP address whitelisted.', 'simple-locator'); ?></p>
	<p>
		<strong><label for="wpsl_google_geocode_api_key"><?php _e('Google Maps Geocode API Key (server)', 'simple-locator');?></label></strong><br>
		<input type="text" name="wpsl_google_geocode_api_key" id="wpsl_google_geocode_api_key" value="<?php echo get_option('wpsl_google_geocode_api_key'); ?>" />
	</p>
</div>

<table class="form-table">
<tr valign="top">
	<th scope="row"><?php _e('Measurement Unit', 'simple-locator'); ?></th>
	<td>
		<select name="wpsl_measurement_unit">
			<option value="miles" <?php if ( $this->unit == "miles") echo ' selected'; ?>><?php _e('Miles', 'simple-locator'); ?></option>
			<option value="kilometers" <?php if ( $this->unit == "kilometers") echo ' selected'; ?>><?php _e('Kilometers', 'simple-locator'); ?></option>
		</select>
	</td>
</tr>
<tr valign="top">
	<th scope="row"><?php _e('Custom Map Pin', 'simple-locator'); ?></th>
	<td>
		<div id="map-pin-image-cont" style="float:left;">
			<?php 
			if ( get_option('wpsl_map_pin') ){
				echo '<img src="' . get_option('wpsl_map_pin') . '" id="map-pin-image" />';
			}
			?>
		</div>
		<?php 
		if ( get_option('wpsl_map_pin') ){
			echo '<input id="remove_map_pin" type="button" value="' . __('Remove', 'simple-locator') . '" class="button action" style="margin-right:5px;margin-left:10px;" />';
		} else {
			echo '<input id="upload_image_button" type="button" value="Upload" class="button action" />';
		} ?>
		<input id="wpsl_map_pin" type="text" size="36" name="wpsl_map_pin" value="<?php echo get_option('wpsl_map_pin'); ?>" style="display:none;" />
	</td>
</tr>
<tr valign="top">
	<th scope="row"><?php _e('Output Simple Locator CSS', 'simple-locator'); ?></th>
	<td>
		<label>
			<input type="radio" value="true" name="wpsl_output_css" <?php if ( get_option('wpsl_output_css') == 'true') echo 'checked'; ?> />
			<?php _e('Yes', 'simple-locator'); ?>
		</label><br />
		<label>
			<input type="radio" value="false" name="wpsl_output_css" <?php if ( get_option('wpsl_output_css') !== 'true') echo 'checked'; ?> />
			<?php _e('No', 'simple-locator'); ?>
		</label>
	</td>
</tr>
<tr valign="top">
	<th scope="row"><?php _e('Include Google Maps API (front end)', 'simple-locator'); ?>*</th>
	<td>
		<label>
			<input type="radio" value="true" name="wpsl_gmaps_api" <?php if ( get_option('wpsl_gmaps_api') == 'true') echo 'checked'; ?> />
			<?php _e('Yes', 'simple-locator'); ?>
		</label><br />
		<label>
			<input type="radio" value="false" name="wpsl_gmaps_api" <?php if ( get_option('wpsl_gmaps_api') !== 'true') echo 'checked'; ?> />
			<?php _e('No', 'simple-locator'); ?>
		</label>
		<p style="font-style:oblique;font-size:13px;"><?php _e('The Google Maps API is required for Simple Locator to function. If another plugin in use includes the Google Maps API, disable it here to avoid it being included multiple times on the front end of your site.', 'simple-locator'); ?></p>
	</td>
</tr>
<tr valign="top">
	<th scope="row"><?php _e('Include Google Maps API (admin)', 'simple-locator'); ?>*</th>
	<td>
		<label>
			<input type="radio" value="true" name="wpsl_gmaps_api_admin" <?php if ( get_option('wpsl_gmaps_api_admin') == 'true') echo 'checked'; ?> />
			<?php _e('Yes', 'simple-locator'); ?>
		</label><br />
		<label>
			<input type="radio" value="false" name="wpsl_gmaps_api_admin" <?php if ( get_option('wpsl_gmaps_api_admin') !== 'true') echo 'checked'; ?> />
			<?php _e('No', 'simple-locator'); ?>
		</label>
		<p style="font-style:oblique;font-size:13px;"><?php _e('The Google Maps API is required for saving and editing locations.', 'simple-locator'); ?></p>
	</td>
</tr>
<tr valign="top">
	<th scope="row"><?php _e('Enable Autocomplete in Search', 'simple-locator'); ?></th>
	<td>
		<label>
			<input type="checkbox" value="true" name="wpsl_enable_autocomplete" <?php if ( get_option('wpsl_enable_autocomplete') == 'true') echo 'checked'; ?> />
			<?php _e('Enable', 'simple-locator'); ?>
		</label>
	</td>
</tr>
<tr valign="top">
	<th scope="row"><?php _e('Display Map in Singular View', 'simple-locator'); ?></th>
	<td>
		<label>
			<input type="radio" value="true" name="wpsl_singular_data" <?php if ( get_option('wpsl_singular_data') == 'true') echo 'checked'; ?> />
			<?php _e('Yes', 'simple-locator'); ?>
		</label><br />
		<label>
			<input type="radio" value="false" name="wpsl_singular_data" <?php if ( get_option('wpsl_singular_data') !== 'true') echo 'checked'; ?> />
			<?php _e('No', 'simple-locator'); ?>
		</label>
	</td>
</tr>
<tr valign="top">
	<th scope="row"><?php _e('Location Button', 'simple-locator'); ?></th>
	<td>
		<label>
			<input type="checkbox" id="wpsl_geo_button_enable" name="wpsl_geo_button[enabled]" value="true" <?php if ( $location_btn['enabled'] ) echo 'checked'; ?> />
			<?php _e('Display location button on geolocation enabled devices/browsers', 'simple-locator');?>

		</label>
	</td>
</tr>
<tr valign="top" class="wpsl-location-text">
	<th scope="row"><?php _e('Location Button Text', 'simple-locator'); ?></th>
	<td>
		<input type="text" name="wpsl_geo_button[text]" value="<?php echo esc_html($location_btn['text']); ?>" />
	</td>
</tr>
<tr valign="top">
	<th scope="row"><?php _e('Enable Javascript Debugging', 'simple-locator'); ?></th>
	<td>
		<label><input type="checkbox" name="wpsl_js_debug" value="true" <?php if ( $this->settings_repo->jsDebug() ) echo 'checked';?> /><?php _e('Enable Javascript Console Logging (for debugging/development purposes)', 'simple-locator'); ?></label>
	</td>
</tr>
<tr valign="top">
	<th scope="row"><?php _e('Save Searches', 'simple-locator'); ?></th>
	<td>
		<label>
			<input type="checkbox" value="true" name="wpsl_save_searches" <?php if ( get_option('wpsl_save_searches') == 'true') echo 'checked'; ?> />
			<?php _e('Save Search History', 'simple-locator'); ?>
		</label>
	</td>
</tr>