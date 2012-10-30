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
	$disqus_shortname = elgg_get_plugin_setting('disqus_shortname', 'tgs_disqus');
	$disqus_identifier = $vars['entity']->guid;
?>
	<div id="disqus_thread"></div>
	<script type="text/javascript">
		/* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
		var disqus_shortname = '<?php echo $disqus_shortname; ?>'; // Disqus shortname, configured in admin settings
		var disqus_identifier = '<?php echo $disqus_identifier; ?>'; // Unique identifier, in this case the entity guid

		/* * * DON'T EDIT BELOW THIS LINE * * */
		(function() {
			var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
			dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
			(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
			})();
	</script>
	<noscript>
		Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a>
	</noscript>
	<a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>
<?php
}