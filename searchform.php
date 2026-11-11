<?php
/**
 * Search form template controller.
 *
 * @package Azbalac_One
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
            : _x('Site search', 'aria label', 'azbalac-one'),
        'placeholder' => _x('Search …', 'placeholder', 'azbalac-one'),
        'search_query' => get_search_query(false),
        'field_label' => _x('Search for:', 'label', 'azbalac-one'),
        'submit_label' => _x('Search', 'submit button', 'azbalac-one'),
    )
);
