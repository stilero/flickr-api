<?php
/**
 * Flickr API: Index file for testing
 *
 * @version  1.0
 * @package Stilero
 * @subpackage Flickr API
 * @author Daniel Eliasson <daniel at stilero.com>
 * @copyright  (C) 2013-dec-30 Stilero Webdesign (http://www.stilero.com)
 * @license	GNU General Public License version 2 or later.
 * @link http://www.stilero.com
 */
define('_JEXEC', 1);
define('PATH_TWITTER_LIBRARY', dirname(__FILE__).'/library/');

foreach (glob(PATH_TWITTER_LIBRARY."*.php") as $filename){
    require_once $filename;
}
foreach (glob(PATH_TWITTER_LIBRARY.'authentication/'."*.php") as $filename){
    require_once $filename;
}
foreach (glob(PATH_TWITTER_LIBRARY.'oauth/'."*.php") as $filename){
    require_once $filename;
}
require_once dirname(__FILE__).'/jerror.php';
$imagefile = dirname(__FILE__).'/joomla_logo_black.jpg';
$api_key = 'a7aa0fcf048ed05cc2257645cbf9bc02';
$api_secret = '2298ca9011e3c640';
$Api = new StileroFlickrApi($api_key, $api_secret);
$Url = new StileroFlickrUrl($Api);
print $Url->getUrl(StileroFlickrPermissions::WRITE);
?>