<?php 

$thisHttp = 'http://';
if (! empty( $_SERVER['HTTPS'] )) {
    $thisHttp = ($_SERVER['HTTPS'] == 'on') ? 'https://' : 'http://';
}

$_SERVER['HTTP_HOST'] = (!empty($_SERVER['HTTP_HOST'])) ? $_SERVER['HTTP_HOST'] : '';

define('THIS_ABSPATH', str_replace('\\', '/', realpath(dirname(__FILE__))) . '/');
define('THIS_DOCROOT', rtrim(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']) . '/', '/'));
define('THIS_DOMAIN', $thisHttp . $_SERVER['HTTP_HOST']);
define('THIS_ABSURL', THIS_DOMAIN . str_replace(THIS_DOCROOT, '', THIS_ABSPATH));