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
	// Register CSS
	$disqus_css = elgg_get_simplecache_url('css', 'tgs_disqus/css');
	elgg_register_simplecache_view('css/tgs_disqus/css');	
	elgg_register_css('elgg.tgs_disqus', $disqus_css);
	elgg_load_css('elgg.tgs_disqus');
	
	// Register JS
	$disqus_js = elgg_get_simplecache_url('js', 'tgs_disqus/tgs_disqus');
	elgg_register_simplecache_view('js/tgs_disqus/tgs_disqus');	
	elgg_register_js('elgg.tgs_disqus', $disqus_js);
	
	// Extend comments view
	elgg_extend_view('page/elements/comments', 'tgs_disqus/disqus', 1);
}