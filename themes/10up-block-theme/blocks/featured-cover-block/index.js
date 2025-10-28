import React from 'react'; // ✅ Required for JSX
import { registerBlockType } from '@wordpress/blocks';
import { InnerBlocks } from '@wordpress/block-editor';
import Edit from './edit';
import metadata from './block.json';

registerBlockType(metadata, {
	edit: Edit,
	save: () => <InnerBlocks.Content />,
});
