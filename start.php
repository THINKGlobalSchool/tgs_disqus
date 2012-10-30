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
	// Only for public use at the moment
	if (!elgg_is_logged_in()) {
		// Extend comments view
		elgg_extend_view('forms/comments/add', 'tgs_disqus/disqus');
	}
}