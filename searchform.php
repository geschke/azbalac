<?php
/**
 * Search form template controller.
 *
 * @package Azbalac
 */

global $aztpl;

$azbalac_search_form_id = wp_unique_id('azbalac-search-form-');

echo $aztpl->render(
    'searchform.html.twig',
    array(
        'form_id' => $azbalac_search_form_id,
        'field_id' => $azbalac_search_form_id . '-field',
        'action_url' => home_url('/'),
        'aria_label' => !empty($args['aria_label'])
            ? $args['aria_label']
            : _x('Site search', 'aria label', 'azbalac'),
        'placeholder' => _x('Search …', 'placeholder', 'azbalac'),
        'search_query' => get_search_query(false),
        'field_label' => _x('Search for:', 'label', 'azbalac'),
        'submit_label' => _x('Search', 'submit button', 'azbalac'),
    )
);
