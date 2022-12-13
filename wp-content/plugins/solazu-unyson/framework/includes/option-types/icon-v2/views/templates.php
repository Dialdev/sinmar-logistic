<?php

$tabs = slz()->backend->render_options(
	array(
		'icon-fonts' => array(
			'type' => 'tab',
			'title' => __('Icons', 'slz'),
			'lazy_tabs' => false,
			'options' => array(
				'icon-font' => array(
					'type' => 'html-full',
					'attr' => array('class' => 'slz-icon-v2-icons-library'),
					'label' => false,
					'html' => '{{{data.icons_library_html}}}',
				)
			)
		),

		'favorites' => array(
			'type' => 'tab',
			'attr' => array('class' => '.slz-icon-v2-favorites'),
			'title' => __('Favorites', 'slz'),
			'lazy_tabs' => false,
			'options' => array(
				'icon-font-favorites' => array(
					'type' => 'html-full',
					'label' => false,
					'html' => '{{{data.favorites_list_html}}}'
				)
			)
		),

		'custom-upload' => array(
			'type' => 'tab',
			'lazy_tabs' => false,
			'title' => __('Upload', 'slz'),
			'options' => array(
				'custom-upload' => array(
					'type' => 'upload',
					'label' => __('Upload Icon', 'slz')
				)
			)
		)
	),

	/** $values */
	array(),

	array(
		'id_prefix' => 'slz-option-type-iconv2-',
		'name_prefix' => 'slz_option_type_iconv2'
	)
);

?>

<script type="text/html" id="tmpl-slz-icon-v2-tabs">

<?php echo $tabs; ?>

</script>

<script type="text/html" id="tmpl-slz-icon-v2-library">

<div class="slz-icon-v2-toolbar">
	<input 
		type="text"
		placeholder="<?php echo __('Search Icon', 'slz'); ?>"
		class="slz-option slz-option-type-text">

	<select class="slz-selectize">
		<option selected value="all">
			<?php echo __('All Packs', 'slz'); ?>
		</option>

		<# _.each(data.packs, function (pack) { #>
			<option value="{{pack.name}}">{{pack.title}}</option>
		<# }) #>
	</select>
</div>

<div class="slz-icon-v2-library-packs-wrapper">
	<# if (data.packs.length > 0) { #>
		<# var template = wp.template('slz-icon-v2-packs'); #>

		{{{ template(data) }}}
	<# } #>
</div>

</script>

<script type="text/html" id="tmpl-slz-icon-v2-packs">
	<# _.each(data.packs, function (pack) { #>
		<# if (pack.icons.length === 0) { return; } #>

		<h2>
			<span>{{pack.title}}</span>
		</h2>

		{{{
			wp.template('slz-icon-v2-icons-collection')(
				_.extend({}, pack, {
					current_state: data.current_state,
					favorites: data.favorites
				})
			)
		}}}
	<# }) #>
</script>

<script type="text/html" id="tmpl-slz-icon-v2-favorites">

<div class="slz-icon-v2-icon-favorites">
	<# if (data.favorites.length === 0) { #>

		<h4>You have no favorite icons yet.</h4>
		<p>
			To add icons here, simply click on the star 
			(<i class="slz-icon-v2-info dashicons dashicons-star-filled"></i>)
			button that's on top of each icon.
		</p>

	<# } else { #>

		{{{
			wp.template('slz-icon-v2-icons-collection')(
				_.extend({}, {icons: data.favorites, current_state: data.current_state})
			)
		}}}

	<# } #>
</div>

</script>

<script type="text/html" id="tmpl-slz-icon-v2-icons-collection">

	<# if (data.icons.length > 0) { #>
		<ul class="slz-icon-v2-library-pack">

		<# _.each(data.icons, function (icon) { #>
			<# var iconClass = data.css_class_prefix ? data.css_class_prefix + ' ' + icon : icon; #>
			<# var selectedClass = data.current_state['icon-class'] === iconClass ? 'selected' : ''; #>
			<# var favoriteClass = _.contains(data.favorites, iconClass) ? 'slz-icon-v2-favorite' : '' #>

			<li
				data-slz-icon-v2="{{data.css_class_prefix}} {{icon}}"
				class="slz-icon-v2-library-icon {{selectedClass}} {{favoriteClass}}">

				<i class="{{iconClass}}"></i>

				<a
					title="<?php echo __('Add to Favorites', 'slz') ?>"
					class="slz-icon-v2-favorite">

					<i class="dashicons dashicons-star-filled"></i>
				</a>
			</li>

		<# }) #>
		</ul>
	<# } #>

</script>

<?php

/* 			<li class="slz-icon-v2-library-icon" data-slz-icon-v2="{{icon}}"> */
/* 				<i class="{{icon}}"> */
/* 				<a title="<?php __('Add To Favorites', 'slz'); ?>" */
/* 					class="slz-icon-v2-favorite"> */
/* 					<i class="dashicons dashicons-star-filled"></i> */
/* 				</a> */
/* 			</li> */

?>
