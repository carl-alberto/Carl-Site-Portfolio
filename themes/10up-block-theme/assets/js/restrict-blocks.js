// restrict-blocks.js

(function () {
	/* eslint-disable no-undef */
	if (typeof typenow === 'undefined') {
		return;
	}

	// Only restrict if NOT 'portfolio' post type
	if (typenow !== 'portfolio') {
		wp.hooks.addFilter(
			'blocks.registerBlockType',
			'my-plugin/restrict-project-summary-block',
			(settings, name) => {
				if (name === 'tenup/portfolio-header') {
					settings.supports = {
						...settings.supports,
						inserter: false,
					};
				}
				return settings;
			},
		);
	}
})();
