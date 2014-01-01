<?php
/**
 * Flickr_API
 *
 * @version  1.0
 * @package Stilero
 * @subpackage Flickr_API
 * @author Daniel Eliasson <daniel at stilero.com>
 * @copyright  (C) 2013-dec-31 Stilero Webdesign (http://www.stilero.com)
 * @license	GNU General Public License version 2 or later.
 * @link http://www.stilero.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access'); 

class StileroFlickrPhotos extends StileroFlickrCurler{
    
    const API_URL = 'http://flickr.com/services/rest/';
    const METHOD_ADD_TAGS = 'flickr.photos.addTags';
    
    public function __construct(\StileroFlickrApi $Api, $auth_token) {
        parent::__construct($Api, $auth_token);
    }
    
    /**
     * Add tags to a photo.
     * @param string $photo_id The id of the photo to add tags to.
     * @param string $tags The tags to add to the photo. Example (tag1 tag2 tag3)
     * @return string RAW JSON Response
     */
    public function addTags($photo_id, $tags){
        $params = array(
            'method' => self::METHOD_ADD_TAGS,
            'photo_id' => $photo_id,
            'tags' => $tags
        );
        return $this->curlIt(self::API_URL, $params);
    }
    
}
