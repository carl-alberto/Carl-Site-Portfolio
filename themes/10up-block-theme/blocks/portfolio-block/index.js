import { __ } from '@wordpress/i18n';
import { InspectorControls } from '@wordpress/block-editor';
import { PanelBody, RangeControl } from '@wordpress/components';

wp.blocks.registerBlockType('10up/portfolio-block', {
	title: __('Portfolio Block', '10up-block-theme'),
	icon: 'portfolio',
	category: 'widgets',
	attributes: {
		postsToShow: {
			type: 'number',
			default: 3,
		},
	},
	edit: (props) => {
		const { attributes, setAttributes } = props;
		return (
			<>
				<InspectorControls>
					<PanelBody title={__('Settings', '10up-block-theme')}>
						<RangeControl
							label={__('Number of items', '10up-block-theme')}
							value={attributes.postsToShow}
							onChange={(value) => setAttributes({ postsToShow: value })}
							min={1}
							max={12}
						/>
					</PanelBody>
				</InspectorControls>
				<div className="portfolio-block-placeholder">
					<p>
						{__(
							'Portfolio items will be displayed on the front end.',
							'10up-block-theme',
						)}
					</p>
				</div>
			</>
		);
	},
	save: () => null, // Rendered via PHP
});
