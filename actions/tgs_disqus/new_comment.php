<?php
/**
 * TGS Disqus New Comment Action
 * 
 * @package tgs_disqus
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2012
 * @link http://www.thinkglobalschool.com/
 */

// Get input
$entity_guid = get_input('entity_guid');
$disqus_comment_id = get_input('disqus_comment_id');
$disqus_comment_text = get_input('disqus_comment_text');

// Build params for plugin hook
$params = array(
	'entity_guid' => $entity_guid,
	'disqus_comment_id' => $disqus_comment_id,
	'disqus_comment_text' => $disqus_comment_text,
);

// Trigger plugin hook for new disqus comments
elgg_trigger_plugin_hook('new_comment', 'disqus', $params, NULL);

forward(REFERER);