<?php
/**
 * TGS Disqus English language translation
 * 
 * @package tgs_disqus
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2012
 * @link http://www.thinkglobalschool.com/
 */

$english = array(
	// Labels
	'tgsdisqus:label:shortname' => 'Disqus Shortname',
	'tgsdisqus:label:publiconly' => 'Show Disqus only when logged out?',
	'tgsdisqus:label:site_comments' => '%s Comments',
	'tgsdisqus:label:disqus_comments' => 'Disqus Comments',
	'tgsdisqus:label:secretkey' => 'Disqus API Secret Key',
	'tgsdisqus:label:publickey' => 'Disqus API Public Key',
	'tgsdisqus:label:notifycomment' => 'Notify users when content is commented?',

	// Notifications
	'tgsdisqus:comment:subject' => 'You have a new public comment!',
	'tgsdisqus:comment:body' => "You have a new public comment on your item \"%s\". 

To reply or view the original item, click here:

%s

Please note: Because this is a public comment, it may end up being flagged as inappropriate and removed by a moderator.

You cannot reply to this email.",

);

add_translation('en',$english);