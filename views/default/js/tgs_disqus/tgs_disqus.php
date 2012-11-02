<?php
/**
 * TGS Disqus JS
 * 
 * @package tgs_disqus
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2012
 * @link http://www.thinkglobalschool.com/
 */
?>
//<script>
elgg.provide('elgg.tgs_disqus');

// Init function
elgg.tgs_disqus.init = function () {	
	// Delegate click handler for comment navigation
	$(document).delegate('.tgs-disqus-comment-tab', 'click', elgg.tgs_disqus.commentTabClick);

	// Handler url hashes
	elgg.tgs_disqus.handle_hash();
}

// Click handler for comment navigation
elgg.tgs_disqus.commentTabClick = function(event) {
	// Clear selected state
	$('.tgs-disqus-comment-tab').removeClass('elgg-state-selected');

	// Select this tab
	$(this).addClass('elgg-state-selected');

	// Hide comments containers
	$('.tgs-comments-container').addClass('tgs-disqus-hidden');

	// Show selected container
	$($(this).find('a').attr('href')).removeClass('tgs-disqus-hidden');

	event.preventDefault();
}

// Hook handler for 'disqus' 'new_comment'
elgg.tgs_disqus.trackComment = function(hook, type, params, value) {
	if (params) {
		// Trigger new_comment action for further processing
		elgg.action('disqus/new_comment', {
			data: {
				entity_guid: params.entity_guid,
				disqus_comment_id: params.comment.id,
				disqus_comment_text: params.comment.text,
			}, 
			success: function(result) {
				// Don't need to do anything with the action result at the moment
				if (result.status != -1) {
					// Success
				} else {
					// Error
				}
			}
		});
	}
	return value;
}

// Process and react to any url hashes
elgg.tgs_disqus.handle_hash = function() {
	switch (window.location.hash) {
		// Display disqus tab automagically
		case "#disqus_comments":
			$('.elgg-menu-item-disqus-comments').trigger('click');
			break;
	}
}

elgg.register_hook_handler('new_comment', 'disqus', elgg.tgs_disqus.trackComment);
elgg.register_hook_handler('init', 'system', elgg.tgs_disqus.init);