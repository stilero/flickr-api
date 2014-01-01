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
foreach (glob(PATH_TWITTER_LIBRARY.'oauth/'."*.php") as $filename){
    require_once $filename;
}
foreach (glob(PATH_TWITTER_LIBRARY.'authentication/'."*.php") as $filename){
    require_once $filename;
}
foreach (glob(PATH_TWITTER_LIBRARY.'endpoints/'."*.php") as $filename){
    require_once $filename;
}
require_once dirname(__FILE__).'/jerror.php';
$file = dirname(__FILE__).'/joomla_logo_black.jpg';
$auth_token = '72157639226524196-c88cad77e7d51500';
$api_key = 'a7aa0fcf048ed05cc2257645cbf9bc02';
$api_secret = '2298ca9011e3c640';
$Flickr = new StileroFlickr($api_key, $api_secret);
$Flickr->setAccessToken($auth_token);
$Flickr->init();
$Api = new StileroFlickrApi($api_key, $api_secret);
$Photouploader = new StileroFlickrPhotouploader($Api, $auth_token);
$People = new StileroFlickrPeople($Api, $auth_token);
$Photos = new StileroFlickrPhotos($Api, $auth_token);
$title = 'Imagetitle';
$description = 'Imagedescription';
$tags = 'tag6 tag7 tag8';
//$response = $Photouploader->upload($file, $title, $description, $tags);
//$response = $Photouploader->replace($file, '11685505596');
//$response = $People->findByUsername('stilero_com');
//$response = $People->getPhotos('113011993@N02');
$response = $Photos->setTags('11685505596', $tags);
//var_dump($response);
?>