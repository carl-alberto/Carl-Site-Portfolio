// restrict-blocks.js

( function () {

	// Ensure we're in the admin and on a post-edit screen
	if ( typeof typenow === 'undefined' ) {
		return;
	}

	// Only restrict if NOT 'portfolio' post type
	if ( typenow !== 'portfolio' ) {
		wp.hooks.addFilter(
			'blocks.registerBlockType',
			'my-plugin/restrict-project-summary-block',
			function ( settings, name ) {
				if ( name === 'tenup/portfolio-header' ) {
					settings.supports = {
						...settings.supports,
						inserter: false,
					};
				}
				return settings;
			}
		);
	}
} )();
