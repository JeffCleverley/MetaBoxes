<p>
	<label for="new-subtitle"><?php _e( 'New Subtitle', 'mbbasics' ); ?></label>
	<input class="large-text" type="text" name="mbbasics[new-subtitle]" value="<?php esc_attr_e( $new_subtitle ); ?>">
	<span class="description"><?php _e('Enter the subtitle for this piece of content', 'mbbasics' ); ?></span>
</p>

<p>
	<input type="checkbox" value="1" name="mbbasics[show-subtitle]" <?php checked( $show_subtitle, 1 ); ?>>
	<label for="show-subtitle"><?php _e( 'Show Subtitle?', 'mbbasics' ); ?></label>
	<div>
		<span class="description"><?php _e('Check if you want to show the subtitle for this article', 'mbbasics' ); ?></span>
	</div>
</p>


