// edit.js
import { useBlockProps, useInnerBlocksProps } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';

export const BlockEdit = (props) => {
	const blockProps = useBlockProps({
		className: 'hero-block-editor-preview',
	});

	const innerBlocksProps = useInnerBlocksProps(
		{ className: 'hero-block__inner-content' },
		{
			// Optional: restrict allowed blocks
			// allowedBlocks: [ 'core/paragraph', 'core/button' ],
		}
	);

	return (
		<div {...blockProps}>
			<div className="hero-block__background hero-block__background--placeholder">
				<div className="hero-block__content">
					<h1 className="hero-block__title">{__('Post Title', 'tenup')}</h1>
					<div className="hero-block__taxonomies">
						{__('Category, Tag', 'tenup')}
					</div>
					<div {...innerBlocksProps} />
				</div>
			</div>
		</div>
	);
};
