<?php
/**
 * TGS Disqus comments extension (adds Disqus JS)
 * 
 * @package tgs_disqus
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2012
 * @link http://www.thinkglobalschool.com/
 */

// Restrict to public objects
if (elgg_instanceof($vars['entity'], 'object') && $vars['entity']->access_id == ACCESS_PUBLIC) {
	// Add a class to the site comments container
	$vars['class'] .= ' tgs-comments-container tgs-site-comments-container';
	
	// Add a unique id
	if (!$vars['id']) {
		$vars['id'] = uniqid();
	}

	// Get the id of the site comments container
	$site_comments_id = $vars['id'];

	// Determine if we're going to display this for everyone, or just publicly
	$public_only = elgg_get_plugin_setting('public_only', 'tgs_disqus');

	$is_logged_in = elgg_is_logged_in();

	// Build tabbed navigation if we're displaying for everyone, or if we're logged out
	if ($public_only != 'yes' || !$is_logged_in) {
		// Determine if site comments are selected
		$site_comments_selected = $is_logged_in ? TRUE : FALSE; // Select first if logged in

		// Register site comments tab
		elgg_register_menu_item('tgs_disqus:tabs', array(
			'name' => 'site_comments',
			'text' => elgg_echo('tgsdisqus:label:site_comments', array(elgg_get_site_entity()->name)),
			'href' => "#.tgs-site-comments-container",
			'priority' => $is_logged_in ? 0 : 1, // Priority depends on wether or now we're logged in
			'selected' => $site_comments_selected,
		));

		// Determine if disqus comments are selected
		$disqus_selected = $is_logged_in ? FALSE : TRUE; // Select only if not logged in

		// Hide site comments by default if disqus is selected
		if ($disqus_selected) {
			$vars['class'] .= " tgs-disqus-hidden"; // Append hidden class to any passed in classes
		}

		// Register disqus tab
		elgg_register_menu_item('tgs_disqus:tabs', array(
			'name' => 'disqus_comments',
			'text' => elgg_echo('tgsdisqus:label:disqus_comments'),
			'href' => '#.tgs-disqus-container',
			'priority' => $is_logged_in ? 1 : 0,
			'selected' => $disqus_selected, 
		));

		echo elgg_view_menu('tgs_disqus:tabs', array(
			'sort_by' => 'priority',
			'class' => 'elgg-menu-hz elgg-menu-filter elgg-menu-filter-default',
			'item_class' => 'tgs-disqus-comment-tab',
		));
	}

	// Display Disqus comments depending on public only settings
	if (($public_only == 'yes' && !elgg_is_logged_in()) || $public_only != 'yes')  {	
		$identifier = $vars['entity']->guid;
		$iframe_url = elgg_get_site_url() . 'disqus/iframe/' . $identifier;
		
		$hidden_class = $disqus_selected ? '' : ' tgs-disqus-hidden';
		
 		echo "<iframe id='tgs-disqus-iframe-$identifier' scrolling='no' frameborder='0' src='$iframe_url' class='tgs-disqus-iframe tgs-comments-container tgs-disqus-container $hidden_class'></iframe>";
?>
		<script type='text/javascript'>
			// Helper function to resize iframe
			function resizeFrame(height){
				$('iframe#tgs-disqus-iframe-<?php echo $identifier; ?>').attr("height", height + 25);
			}
		</script>
<?php
	}
}
