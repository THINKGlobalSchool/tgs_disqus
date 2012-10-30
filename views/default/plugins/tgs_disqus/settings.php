<?php
/**
 * TGS Disqus Plugin settings
 * 
 * @package tgs_disqus
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2012
 * @link http://www.thinkglobalschool.com/
 */

$disqus_shortname = $vars['entity']->disqus_shortname;

$disqus_shortname_label = elgg_echo('tgsdisqus:label:shortname');
$disqus_shortname_input = elgg_view('input/text', array(
	'name' => 'params[disqus_shortname]',
	'value' => $disqus_shortname,
));

$content = <<<HTML
	<div>
		<label>$disqus_shortname_label</label>
		$disqus_shortname_input
	</div>
HTML;

echo $content;