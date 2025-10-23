import { render, screen, fireEvent } from '@testing-library/react';
import '@testing-library/jest-dom';
import { registerBlockType } from '@wordpress/blocks';
import { createElement } from '@wordpress/element';

// Mock WP dependencies
jest.mock('@wordpress/blocks', () => ({
    registerBlockType: jest.fn(),
    createBlock: jest.fn(() => ({ name: 'tenup/portfolio-header' })),
}));

// Mock block editor components
jest.mock('@wordpress/block-editor', () => ({
    MediaUploadCheck: ({ children }) => children,
    MediaUpload: ({ onSelect }) => ({
        props: { onSelect: jest.fn() }
    }),
    InspectorControls: ({ children }) => <div>{children}</div>,
    BlockControls: ({ children }) => <div>{children}</div>,
}));

// Import AFTER mocks
import './../../../blocks/portfolio-header/index.js'; // Registers block
import PortfolioHeaderEdit from './../../../blocks/portfolio-header/edit.js';

describe('Portfolio Header Block', () => {
    beforeEach(() => {
        jest.clearAllMocks();
    });

    it('registers block with correct name and attributes', () => {
        expect(registerBlockType).toHaveBeenCalledWith('tenup/portfolio-header', expect.objectContaining({
            title: 'Portfolio Header',
            category: 'text',
            attributes: expect.objectContaining({
                featuredImageUrl: expect.objectContaining({
                    type: 'string',
                    default: '',
                }),
            }),
            supports: expect.objectContaining({
                align: ['wide', 'full'],
                color: expect.objectContaining({ gradients: true }),
                spacing: expect.objectContaining({
                    margin: true,
                    padding: true,
                }),
            }),
        }));
    });

    it('renders edit component with default attributes', () => {
        const attributes = { featuredImageUrl: '' };
        const setAttributes = jest.fn();

        render(
            <PortfolioHeaderEdit
                attributes={attributes}
                setAttributes={setAttributes}
                isSelected={true}
            />
        );

        expect(screen.getByText('Portfolio Header')).toBeInTheDocument();
    });

    it('displays featured image when URL is set', () => {
        const attributes = {
            featuredImageUrl: 'https://example.com/image.jpg'
        };
        const setAttributes = jest.fn();

        render(
            <PortfolioHeaderEdit
                attributes={attributes}
                setAttributes={setAttributes}
                isSelected={true}
            />
        );

        // Adjust selector based on your edit.js - common patterns:
        expect(screen.getByAltText(/featured image/i)).toBeInTheDocument();
        // OR
        // expect(screen.getByRole('img', { src: 'https://example.com/image.jpg' })).toBeInTheDocument();
    });

    it('handles image upload and sets featuredImageUrl', () => {
        const attributes = { featuredImageUrl: '' };
        const setAttributes = jest.fn();
        const mockImage = { url: 'https://example.com/new-image.jpg' };

        render(
            <PortfolioHeaderEdit
                attributes={attributes}
                setAttributes={setAttributes}
                isSelected={true}
            />
        );

        const uploadButton = screen.getByRole('button', { name: /select image/i });
        fireEvent.click(uploadButton);

        // Mock media selection
        const onSelect = expect.any(Function);
        onSelect(mockImage);

        expect(setAttributes).toHaveBeenCalledWith({
            featuredImageUrl: 'https://example.com/new-image.jpg',
        });
    });

    it('applies blue variation class', () => {
        const attributes = { className: 'is-style-blue' };
        const setAttributes = jest.fn();

        render(
            <PortfolioHeaderEdit
                attributes={attributes}
                setAttributes={setAttributes}
                isSelected={true}
            />
        );

        expect(screen.getByTestId('portfolio-header-root')).toHaveClass('is-style-blue');
    });
});
