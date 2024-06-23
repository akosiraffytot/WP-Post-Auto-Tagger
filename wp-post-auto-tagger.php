<?php
/**
 * Plugin Name: WP Post Auto Tagger
 * Description: Automatically adds tags to a post based on synonyms of the post title.
 * Version: 1.0
 * Author: Rafael Mendoza
 */

// Hook into the save_post action
add_action('save_post', 'auto_add_tags_from_title');

function auto_add_tags_from_title($post_id) {
    // Check if this is not an autosave and the post is not in "Auto Draft" status
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE || get_post_status($post_id) === 'auto-draft') {
        return;
    }

    // Check if the post already has tags
    $existing_tags = wp_get_post_tags($post_id);
    if (!empty($existing_tags)) {
        return;
    }

    // Get the post title
    $post_title = get_the_title($post_id);

    // Get synonyms using Datamuse API
    $synonyms = get_synonyms($post_title);

    // Include the post title itself as a tag
    $tags = array_map('strtolower', array_merge([$post_title], $synonyms));

    // Add tags based on synonyms
    if (!empty($tags)) {
        wp_set_post_tags($post_id, $tags, true);
    }
}

// Function to get synonyms using Datamuse API
function get_synonyms($word) {
    $api_url = "https://api.datamuse.com/words?rel_syn=" . urlencode($word);
    $response = wp_remote_get($api_url);

    if (is_wp_error($response)) {
        return array();
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if (is_array($data) && !empty($data)) {
        $synonyms = wp_list_pluck($data, 'word');
        return $synonyms;
    } else {
        return array();
    }
}
