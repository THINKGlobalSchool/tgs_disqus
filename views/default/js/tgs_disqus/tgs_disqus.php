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

elgg.register_hook_handler('init', 'system', elgg.tgs_disqus.init);