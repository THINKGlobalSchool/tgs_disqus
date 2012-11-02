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

// Restrict to objects for now..
if (elgg_instanceof($vars['entity'], 'object')) {

	// If we don't have an id for the site comments container, set one
	if (!$vars['id']) {
		$vars['id'] = 'tgs-site-comments-container';
	}

	// Add a class to the site comments container
	$vars['class'] .= ' tgs-comments-container';

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
			'href' => "#{$site_comments_id}",
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
			'href' => '#disqus_thread',
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
		// Load Utility JS
		elgg_load_js('elgg.tgs_disqus');

		$disqus_shortname = elgg_get_plugin_setting('disqus_shortname', 'tgs_disqus');
		$disqus_identifier = $vars['entity']->guid;
?>
		<div id="disqus_thread" class="tgs-comments-container<?php echo $disqus_selected ? '' : ' tgs-disqus-hidden'; ?>"></div>
		<script type="text/javascript">
			/* START DISQUS CODE */
			
			// CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE
			var disqus_shortname = '<?php echo $disqus_shortname; ?>'; // Disqus shortname, configured in admin settings
			var disqus_identifier = '<?php echo $disqus_identifier; ?>'; // Unique identifier, in this case the entity guid
			//var disqus_developer = 1; // developer mode is on ** MAKE SURE THIS IS DISABLED IN PRODUCTION **
			
			// Further Config
			function disqus_config() {
				// Add onNewComment callback
			    this.callbacks.onNewComment = [function(data) { 
					var params = {
						entity_guid: disqus_identifier,
						comment: data
					};
					// Trigger a JS hook for new comments
					elgg.trigger_hook('new_comment', 'disqus', params); 
				}];
			}

			/**** DON'T EDIT BELOW THIS LINE ****/
			(function() {
				var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
				dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
				(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
			})();
		</script>
		<noscript>
			Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a>
		</noscript>
<?php
	}
}