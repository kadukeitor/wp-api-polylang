<?php
/**
 * Plugin Name: WP REST API - Polylang
 * Description: Polylang integration for the WP REST API
 * Author: Jorge R Garcia
 * Author URI:
 * Version: 0.0.1
 * Plugin URI:
 * License: GPL2+
 */

/**
 * Init
 */
function polylang_json_api_init()
{

    global $polylang;

    $default = pll_default_language();
    $langs = pll_languages_list();

    $cur_lang = $_GET['lang'];

    if (!in_array($cur_lang, $langs)) {
        $cur_lang = $default;
    }

    $polylang->curlang = $polylang->model->get_language($cur_lang);
    $GLOBALS['text_direction'] = $polylang->curlang->is_rtl ? 'rtl' : 'ltr';
}

/**
 *  Get available languages
 *
 * @return array
 */
function polylang_json_api_languages()
{
    return pll_languages_list();
}

add_action('rest_api_init', 'polylang_json_api_init');
add_action('rest_api_init', function () {
    register_rest_route('polylang/v2', '/languages', array(
        'methods' => 'GET',
        'callback' => 'polylang_json_api_languages',
    ));
});