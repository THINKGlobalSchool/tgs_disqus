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

// Get plugin settings
$disqus_shortname = $vars['entity']->disqus_shortname;
$public_only = $vars['entity']->public_only;
$notify_on_new_comment = $vars['entity']->notify_on_new_comment;
$disqus_secret_key = $vars['entity']->disqus_secret_key;
$disqus_public_key = $vars['entity']->disqus_public_key;

// Shortname (forum name)
$disqus_shortname_label = elgg_echo('tgsdisqus:label:shortname');
$disqus_shortname_input = elgg_view('input/text', array(
	'name' => 'params[disqus_shortname]',
	'value' => $disqus_shortname,
));

// Only display disqus when not logged in
$public_only_label = elgg_echo('tgsdisqus:label:publiconly');
$public_only_input = elgg_view('input/dropdown', array(
	'name' => 'params[public_only]',
	'options_values' => array(
		'no' => elgg_echo('option:no'),
		'yes' => elgg_echo('option:yes')
	),
	'value' => $public_only,
));

// Notify users on new comment?
$notify_label = elgg_echo('tgsdisqus:label:notifycomment');
$notify_input = elgg_view('input/dropdown', array(
	'name' => 'params[notify_on_new_comment]',
	'options_values' => array(
		'no' => elgg_echo('option:no'),
		'yes' => elgg_echo('option:yes')
	),
	'value' => $notify_on_new_comment,
));

// API secret key
$disqus_api_secret_key_label = elgg_echo('tgsdisqus:label:secretkey');
$disqus_api_secret_key_input = elgg_view('input/text', array(
	'name' => 'params[disqus_secret_key]',
	'value' => $disqus_secret_key,
));

// API public key
$disqus_api_public_key_label = elgg_echo('tgsdisqus:label:publickey');
$disqus_api_piblic_key_input = elgg_view('input/text', array(
	'name' => 'params[disqus_public_key]',
	'value' => $disqus_public_key,
));


$content = <<<HTML
	<div>
		<label>$disqus_shortname_label</label>
		$disqus_shortname_input
	</div>
	<div>
		<label>$notify_label</label>
		$notify_input
	</div>
	<div>
		<label>$public_only_label</label>
		$public_only_input
	</div>
	<div>
		<label>$disqus_api_secret_key_label</label>
		$disqus_api_secret_key_input
	</div>
	<div>
		<label>$disqus_api_public_key_label</label>
		$disqus_api_piblic_key_input
	</div>
HTML;

echo $content;