import { useBlockProps, InnerBlocks, useBlockProps as useStyledBlockProps } from '@wordpress/block-editor';
import { useSelect } from '@wordpress/data';

export default function Edit({ attributes }) {
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
    <div {...blockProps}>
      <div
        className="overlay"
        style={overlayStyle}
      />
      <div className="featured-block-cover__inner-content">
        <InnerBlocks />
      </div>
    </div>
  );
}
