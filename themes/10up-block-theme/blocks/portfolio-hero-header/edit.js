import { useBlockProps, RichText, InnerBlocks } from '@wordpress/block-editor';
import { useEntityProp } from '@wordpress/core-data';
import { useSelect } from '@wordpress/data';

export const BlockEdit = () => {
	const blockProps = useBlockProps();

	// --- Access current post context ---
	const [ title, setTitle ] = useEntityProp( 'postType', 'post', 'title' );
	const [ excerpt, setExcerpt ] = useEntityProp( 'postType', 'post', 'excerpt' );
	const [ meta, setMeta ] = useEntityProp( 'postType', 'post', 'meta' );

	// --- Post meta: role ---
	const role = meta?.role || '';
	const onChangeRole = ( value ) => setMeta( { ...meta, role: value } );

	// --- Featured image ---
	const featuredImage = useSelect( ( select ) => {
		const { getEditedPostAttribute } = select( 'core/editor' );
		const featuredImageId = getEditedPostAttribute( 'featured_media' );
		if ( ! featuredImageId ) return null;
		const media = select( 'core' ).getMedia( featuredImageId );
		return media?.source_url || null;
	}, [] );

	return (
		<div {...blockProps} className="portfolio-hero-header">
			{featuredImage && (
				<img
					src={featuredImage}
					className="portfolio-hero-header-bg"
					alt=""
				/>
			)}
			<div className="portfolio-hero-header-gradient" />

			<div className="portfolio-hero-header-content wp-block-group__inner-container">
				{/* Editable Title */}
				<RichText
					tagName="h1"
					value={title}
					onChange={setTitle}
					placeholder="Add portfolio title…"
					className="portfolio-hero-header-title"
				/>

				{/* Editable Excerpt */}
				<RichText
					tagName="p"
					value={excerpt}
					onChange={setExcerpt}
					placeholder="Add a short summary…"
					className="portfolio-hero-header-excerpt"
				/>

				{/* Taxonomy */}
				<InnerBlocks
					allowedBlocks={['core/post-terms']}
					template={[['core/post-terms', { term: 'technology' }]]}
					templateLock={true}
				/>

				{/* Custom Meta */}
				{role && (
					<div className="portfolio-hero-header-meta">
						{role}
					</div>
				)}
			</div>
		</div>
	);
};
