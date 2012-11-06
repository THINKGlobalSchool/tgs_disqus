<?php
/**
 * TGS Disqus start.php
 * 
 * @package tgs_disqus
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2012
 * @link http://www.thinkglobalschool.com/
 */

elgg_register_event_handler('init', 'system', 'tgs_discus_init');

// TGS Disqus Init
function tgs_discus_init() {
	// Register php-disqus library
	$include_path = elgg_get_plugins_path() . 'tgs_disqus/vendors/php-disqus/disqusapi/disqusapi.php';
	elgg_register_library('php-disqus', $include_path);

	// Extend Elgg CSS
	elgg_extend_view('css/elgg', 'css/tgs_disqus/css');

	// Register & Load TGS Disqus JS
	$disqus_js = elgg_get_simplecache_url('js', 'tgs_disqus/tgs_disqus');
	elgg_register_simplecache_view('js/tgs_disqus/tgs_disqus');	
	elgg_register_js('elgg.tgs_disqus', $disqus_js);
	elgg_load_js('elgg.tgs_disqus');

	// Re-register elgg, jquery and tgs_disqus js to load in disqus iframe
	$elgg_js_url = elgg_get_simplecache_url('js', 'elgg');
	elgg_register_js('jquery_iframe', '/vendors/jquery/jquery-1.6.4.min.js', 'disqus_iframe');
	elgg_register_js('elgg_iframe', $elgg_js_url, 'disqus_iframe');
	elgg_register_js('elgg.tgs_disqus_iframe', $disqus_js, 'disqus_iframe');

	// Re-register basic elgg CSS to load in iframe
	$elgg_css_url = elgg_get_simplecache_url('css', 'elgg');
	elgg_register_external_file('css', 'elgg_iframe', $elgg_css_url, 'disqus_iframe', 1);

	// Register jquery.resize JS for use in iframe
	$resize_js = elgg_get_simplecache_url('js', 'jquery_resize');
	elgg_register_simplecache_view('js/jquery_resize');	
	elgg_register_js('jquery.resize_iframe', $resize_js, 'disqus_iframe');

	// Register disqus page handler
	elgg_register_page_handler('disqus','tgs_disqus_page_handler');

	// Extend comments view
	elgg_extend_view('page/elements/comments', 'tgs_disqus/disqus', 1);

	// Hook into new disqus comment hook for notifications (if enabled)
	if (elgg_get_plugin_setting('notify_on_new_comment', 'tgs_disqus')) {
		elgg_register_plugin_hook_handler('new_comment', 'disqus', 'tgs_disqus_new_comment_handler');
	}

	// Register actions
	$action_path = elgg_get_plugins_path() . 'tgs_disqus/actions/tgs_disqus';
	elgg_register_action('disqus/new_comment', "$action_path/new_comment.php", 'public');
}

function tgs_disqus_page_handler($page) {
	switch ($page[0]) {
		case 'iframe':
			// Load iframe JS
			elgg_load_js('jquery_iframe');
			elgg_load_js('elgg_iframe');
			elgg_load_js('elgg.tgs_disqus_iframe');
			elgg_load_js('jquery.resize_iframe');
			
			// Load iframe CSS
			elgg_load_css('elgg_iframe');

			echo elgg_view('tgs_disqus/disqus_iframe', array(
				'guid' => $page[1],
			));
			break;
	}
	return TRUE;
}

// Disqus new comment hook handler
function tgs_disqus_new_comment_handler($hook, $type, $return, $params) {	
	$entity = get_entity($params['entity_guid']);

	// Make sure we have a valid entity
	if (elgg_instanceof($entity, 'object')) {
		// Notify content owner that they have a comment
		notify_user(
			$entity->owner_guid,
			elgg_get_site_entity()->guid,
			elgg_echo('tgsdisqus:comment:subject'),
			elgg_echo('tgsdisqus:comment:body', array(
				$entity->title,
				$entity->getURL() . "#disqus_comments",
			))
		);
	}
	return $return;
}