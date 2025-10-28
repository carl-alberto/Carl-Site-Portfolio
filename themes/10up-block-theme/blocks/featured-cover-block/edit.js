// eslint-disable-next-line
import React from 'react';
import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';
import { useSelect } from '@wordpress/data';

const Edit = ({ attributes }) => {
	const featuredImageUrl = useSelect((select) => {
		const editor = select('core/editor');
		const core = select('core');

		const featuredImageId = editor.getEditedPostAttribute('featured_media');
		const media = featuredImageId ? core.getMedia(featuredImageId) : null;

		return media?.source_url || null;
	}, []);

	const blockProps = useBlockProps({
		className: 'wp-block-myplugin-featured-cover-block',
		style: {
			backgroundImage: featuredImageUrl ? `url(${featuredImageUrl})` : undefined,
		},
	});

	const overlayStyle = {
		backgroundColor: attributes?.backgroundColor ? undefined : '#172030',
	};

	return (
		<div {...blockProps} data-testid="featured-cover-root">
			<div className="overlay" style={overlayStyle} data-testid="overlay" />
			<div className="featured-cover-block__inner-content">
				<InnerBlocks />
			</div>
		</div>
	);
};

export default Edit;
