/**
 * @jest-environment jsdom
 */

import React from 'react';

/* eslint-disable */
jest.mock('@wordpress/blocks', () => ({
  registerBlockType: jest.fn(),
}));

jest.mock('@wordpress/block-editor', () => ({
  InnerBlocks: {
    Content: () => <div data-testid="inner-blocks-content" />,
  },
}));

jest.mock('@blocks/featured-cover-block/edit', () => jest.fn());

// Must come after mocks
import { registerBlockType } from '@wordpress/blocks';
import Edit from '@blocks/featured-cover-block/edit';
import metadata from '@blocks/featured-cover-block/block.json';
import '@blocks/featured-cover-block/index';

import { render, screen } from '@testing-library/react';

describe('Featured Cover Block Registration', () => {
  test('registers the block type correctly', () => {
    expect(registerBlockType).toHaveBeenCalledWith(
      metadata,
      expect.objectContaining({
        edit: Edit,
        save: expect.any(Function),
      })
    );
  });

  test('save function returns InnerBlocks.Content', () => {
    const call = registerBlockType.mock.calls[0];
    const { save } = call[1];
    const result = save(); // ✅ This invokes the function

    const { container } = render(result); // ✅ This renders the JSX
    expect(screen.getByTestId('inner-blocks-content')).toBeInTheDocument();
  });
});

