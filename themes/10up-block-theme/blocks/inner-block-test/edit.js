import { useBlockProps, useInnerBlocksProps } from '@wordpress/block-editor';

export const BlockEdit = (props) => {
	const { attributes, setAttributes } = props;
	const blockProps = useBlockProps();
	const innerBlocksProps = useInnerBlocksProps({}, {});
	return (
		<div {...blockProps}>
			<ul {...innerBlocksProps} />
		</div>
	);
};
