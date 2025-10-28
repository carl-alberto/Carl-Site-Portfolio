/**
 * @jest-environment jsdom
 */

import React from 'react';
import { render, screen } from '@testing-library/react';
import Edit from '@blocks/featured-cover-block/edit';

// Mocks must come before any imports that use them
jest.mock('@wordpress/data', () => ({
  useSelect: jest.fn(),
}));

jest.mock('@wordpress/block-editor', () => ({
  useBlockProps: jest.fn((props) => ({
    className: 'wp-block-myplugin-featured-cover-block',
    style: props?.style || {},
  })),
  InnerBlocks: () => <div data-testid="inner-blocks" />,
}));

const { useSelect } = require('@wordpress/data');

describe('Featured Cover Block – Edit', () => {
  beforeEach(() => {
    useSelect.mockImplementation((selector) =>
      selector((storeName) => {
        if (storeName === 'core/editor') {
          return { getEditedPostAttribute: () => 0 };
        }
        if (storeName === 'core') {
          return { getMedia: () => null };
        }
        return {};
      })
    );
  });

  it('shows default overlay when no featured image', () => {
    render(<Edit attributes={{}} />);
    const overlay = screen.getByTestId('overlay');
    expect(overlay).toHaveStyle('background-color: #172030');
  });

  it('uses featured image as background', () => {
    const img = 'https://example.com/img.jpg';

    useSelect.mockImplementation((selector) =>
      selector((storeName) => {
        if (storeName === 'core/editor') {
          return { getEditedPostAttribute: () => 1 };
        }
        if (storeName === 'core') {
          return { getMedia: () => ({ source_url: img }) };
        }
        return {};
      })
    );

    render(<Edit attributes={{}} />);
    const root = screen.getByTestId('featured-cover-root');
    expect(root).toHaveStyle(`background-image: url(${img})`);
  });

  it('renders InnerBlocks', () => {
    render(<Edit attributes={{}} />);
    expect(screen.getByTestId('inner-blocks')).toBeInTheDocument();
  });
});
