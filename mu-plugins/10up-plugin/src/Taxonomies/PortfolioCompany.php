<?php
/**
 * Company Link Taxonomy
 *
 * @package TenUpPlugin
 */

namespace TenUpPlugin\Taxonomies;

use TenupFramework\Taxonomies\AbstractTaxonomy;

class PortfolioCompany extends AbstractTaxonomy {
    public function get_name() {
        return 'portfolio-company';
    }
    public function get_singular_label() {
        return esc_html__( 'Company', 'tenup-plugin' );
    }
    public function get_plural_label() {
        return esc_html__( 'Companies', 'tenup-plugin' );
    }
    public function get_object_type() {
        return [ 'portfolio' ];
    }
    public function can_register() {
        return true;
    }

    /**
     * After the taxonomy is registered, wire up hooks to sync terms with Company posts.
     *
     * Ensures the choices in this taxonomy mirror the titles of Company posts.
     */
    public function after_register() {
        // Keep a term in this taxonomy for each Company post.
        add_action( 'save_post_company', [ $this, 'sync_company_to_term' ], 10, 3 );

        // Remove the matching term when a Company is deleted.
        add_action( 'before_delete_post', [ $this, 'delete_term_for_company' ] );

        // One-time backfill for existing companies.
        add_action( 'init', [ $this, 'maybe_backfill_terms' ], 20 );
    }

    /**
     * Create or update a taxonomy term to mirror a Company post.
     *
     * @param int      $post_id Post ID.
     * @param \WP_Post $post    Post object.
     * @param bool     $update  Whether this is an existing post being updated.
     */
    public function sync_company_to_term( $post_id, $post, $update ) {
        if ( 'company' !== $post->post_type ) {
            return;
        }

        // Ignore autosaves/revisions.
        if ( wp_is_post_autosave( $post_id ) || wp_is_post_revision( $post_id ) ) {
            return;
        }

        // Skip when moving to trash - handled by delete hook.
        if ( 'trash' === $post->post_status ) {
            return;
        }

        $taxonomy = $this->get_name();
        $name     = get_the_title( $post_id );
        $slug     = 'company-' . absint( $post_id ); // Stable unique slug.

        $existing = $this->get_term_for_company( $post_id );

        if ( $existing && ! is_wp_error( $existing ) ) {
            // Update name if changed.
            if ( $existing->name !== $name ) {
                wp_update_term( $existing->term_id, $taxonomy, [ 'name' => $name ] );
            }
            return;
        }

        // Create a new term mapped to this Company post.
        $result = wp_insert_term( $name, $taxonomy, [ 'slug' => $slug ] );
        if ( is_wp_error( $result ) ) {
            return;
        }

        $term_id = (int) $result['term_id'];
        add_term_meta( $term_id, '_company_post_id', (int) $post_id, true );
    }

    /**
     * Delete the mirrored term when a Company post is deleted.
     *
     * @param int $post_id Post ID being deleted.
     */
    public function delete_term_for_company( $post_id ) {
        if ( 'company' !== get_post_type( $post_id ) ) {
            return;
        }

        $term = $this->get_term_for_company( $post_id );
        if ( $term && ! is_wp_error( $term ) ) {
            wp_delete_term( $term->term_id, $this->get_name() );
        }
    }

    /**
     * Find the taxonomy term that maps to a given Company post id.
     *
     * @param int $post_id Company post ID.
     * @return \WP_Term|false
     */
    protected function get_term_for_company( $post_id ) {
        $terms = get_terms(
            [
                'taxonomy'   => $this->get_name(),
                'hide_empty' => false,
                'number'     => 1,
                'meta_query' => [
                    [
                        'key'   => '_company_post_id',
                        'value' => (string) absint( $post_id ),
                    ],
                ],
            ]
        );

        if ( is_wp_error( $terms ) || empty( $terms ) ) {
            return false;
        }

        return $terms[0];
    }

    /**
     * One-time backfill to ensure every existing Company has a matching term.
     */
    public function maybe_backfill_terms() {
        $flag_key = 'tenup_portfolio_company_terms_backfilled';
        if ( get_option( $flag_key ) ) {
            return;
        }

        // Only run in admin or CLI to avoid front-end overhead.
        if ( ! is_admin() && ! defined( 'WP_CLI' ) ) {
            return;
        }

        $companies = get_posts(
            [
                'post_type'      => 'company',
                'post_status'    => 'any',
                'posts_per_page' => -1,
                'fields'         => 'ids',
            ]
        );

        foreach ( $companies as $company_id ) {
            $post = get_post( $company_id );
            if ( $post ) {
                $this->sync_company_to_term( $company_id, $post, true );
            }
        }

        update_option( $flag_key, time() );
    }
}
