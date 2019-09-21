<?php

$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'Userlist',
	'author' => 'GBu, KSt',
	'url' => 'https://www.mediawiki.org/wiki/Extension:None',
	'descriptionmsg' => 'userlist-desc',
	'version' => '1.0',
);

$dir = dirname(__FILE__) . '/';

$wgAutoloadClasses['SpecialUserlist'] = $dir . 'SpecialUserlist.php'; # Location of the SpecialMyExtension class (Tell MediaWiki to load this file)
$wgExtensionMessagesFiles['Userlist'] = $dir . 'Userlist.i18n.php'; # Location of a messages file (Tell MediaWiki to load this file)
$wgExtensionMessagesFiles['UserlistAlias'] = $dir . 'Userlist.alias.php'; # Location of an aliases file (Tell MediaWiki to load this file)
$wgSpecialPages['Userlist'] = 'SpecialUserlist'; # Tell MediaWiki about the new special page and its class name
$wgSpecialPageGroups['Userlist'] = 'hstools';