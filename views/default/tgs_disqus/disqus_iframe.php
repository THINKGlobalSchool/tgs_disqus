<?php
/**
 * TGS Disqus comments extension iframe
 * 
 * @package tgs_disqus
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2012
 * @link http://www.thinkglobalschool.com/
 */

$guid = elgg_extract('guid', $vars);
$entity = get_entity($guid);

// Double-check valid entity
if (!elgg_instanceof($entity, 'object')) {
	return '';
}

// Disqus vars
$disqus_shortname = elgg_get_plugin_setting('disqus_shortname', 'tgs_disqus');
$disqus_identifier = $guid;
$disqus_url = $entity->getURL();

// Control for tabs
$disqus_selected = elgg_is_logged_in() ? FALSE : TRUE; // Select only if not logged in

// Load custom iframe JS
$js = elgg_get_loaded_js('disqus_iframe');

// Load custom iframe CSS
$css = elgg_get_loaded_external_files('css', 'disqus_iframe');

?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<?php foreach ($css as $link) { ?>
			<link rel="stylesheet" href="<?php echo $link; ?>" type="text/css" />
		<?php } ?>
		<?php foreach ($js as $script) { ?>
			<script type="text/javascript" src="<?php echo $script; ?>"></script>
		<?php } ?>

		<script type="text/javascript">
			<?php echo elgg_view('js/initialize_elgg'); ?>
		</script>
	</head>
	<body>
	<!--<div id="disqus_thread" class="tgs-disqus-container tgs-comments-container"></div>-->
	<div id="disqus_thread"></div>

	<script type="text/javascript"> 
		/*** CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE ***/
		var disqus_shortname = "<?php echo $disqus_shortname ?>"; // Disqus shortname, configured in admin settings
		var disqus_identifier = '<?php echo $disqus_identifier; ?>'; // Unique identifier, in this case the entity guid
		var disqus_url = '<?php echo $disqus_url; ?>'; // Permalink
	
		// Further Disqus Config
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

		/* Developer Mode (Disable for prod) */
		var disqus_identifier = '<?php echo $disqus_identifier; ?>'; // Unique identifier, in this case the entity guid

		 /*** DON'T EDIT BELOW THIS LINE ***/
		 (function() {
		     var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
		     dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
		     (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
		 })();
	
		$('#disqus_thread').resize(function(event) {
			frameHeight = $('#disqus_thread').height();
			parent.resizeFrame(frameHeight);
		});
	</script>
	<noscript>
		Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a>
	</noscript>
	</body>