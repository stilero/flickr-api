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
    const METHOD_DELETE = 'flickr.photos.delete';
    const METHOD_GET_ALL_CONTEXTS = 'flickr.photos.getAllContexts';
    const METHOD_GET_EXIF = 'flickr.photos.getExif';
    const METHOD_GET_INFO = 'flickr.photos.getInfo';
    const METHOD_SET_TAGS = 'flickr.photos.setTags';
    const METHOD_GET_FAVOURITES = 'flickr.photos.getFavorites';
    const IMAGE_SIZE_MEDIUM = 'z_d';
    const IMAGE_SIZE_LARGE = 'b_d';
    const IMAGE_SIZE_SMALL = 'n_d';
    const IMAGE_SIZE_THUMB = 't_d';
    const IMAGE_SIZE_SQUARE_75 = 's_d';
    const IMAGE_SIZE_SQUARE_100 = 'q_d';
    const IMAGE_SIZE_ORIGINAL = 'o_d';
    
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
    /**
     * Add tags to a photo.
     * @param string $photo_id The id of the photo to add tags to.
     * @param string $tags The tags to add to the photo. Example (tag1 tag2 tag3)
     * @return string RAW JSON Response
     */
    public function setTags($photo_id, $tags){
        $params = array(
            'method' => self::METHOD_SET_TAGS,
            'photo_id' => $photo_id,
            'tags' => $tags
        );
        return $this->curlIt(self::API_URL, $params);
    }
    /**
     * Delete a photo from flickr.
     * @param string $photo_id The id of the photo to delete.
     * @return string RAW JSON Response
     */
    public function delete($photo_id){
        $params = array(
            'method' => self::METHOD_DELETE,
            'photo_id' => $photo_id
        );
        return $this->curlIt(self::API_URL, $params);
    }
    /**
     * Returns all visible sets and pools the photo belongs to.
     * @param string $photo_id The id of the photo
     * @return string RAW JSON Response
     */
    public function getAllContexts($photo_id){
        $params = array(
            'method' => self::METHOD_GET_ALL_CONTEXTS,
            'photo_id' => $photo_id
        );
        return $this->curlIt(self::API_URL, $params);
    }
    /**
     * Retrieves a list of EXIF/TIFF/GPS tags for a given photo. The calling user must have permission to view the photo.
     * @param string $photo_id The id of the photo
     * @return string RAW JSON Response
     */
    public function getExif($photo_id){
        $params = array(
            'method' => self::METHOD_GET_EXIF,
            'photo_id' => $photo_id
        );
        return $this->curlIt(self::API_URL, $params);
    }
    /**
     * Get information about a photo. The calling user must have permission to view the photo.
     * @param string $photo_id The id of the photo
     * @return string RAW JSON Response
     */
    public function getInfo($photo_id){
        $params = array(
            'method' => self::METHOD_GET_INFO,
            'photo_id' => $photo_id
        );
        return $this->curlIt(self::API_URL, $params);
    }
    /**
     * Returns the list of people who have favorited a given photo.
     * @param string $photo_id The id of the photo
     * @return string RAW JSON Response
     */
    public function getFavourites($photo_id){
        $params = array(
            'method' => self::METHOD_GET_FAVOURITES,
            'photo_id' => $photo_id
        );
        return $this->curlIt(self::API_URL, $params);
    }
    /**
     * Returns the image src url based on the size
     * @param string $photo_id
     * @param string $size Use constants IMAGE_SIZE
     * @return string Image src url
     */
    protected function getImage($photo_id, $sizeconst){
        $size = '';
        switch ($sizeconst) {
            case self::IMAGE_SIZE_LARGE:
                $size = self::IMAGE_SIZE_LARGE;
                break;
            case self::IMAGE_SIZE_MEDIUM:
                $size = self::IMAGE_SIZE_MEDIUM;
                break;
            case self::IMAGE_SIZE_ORIGINAL:
                $size = self::IMAGE_SIZE_ORIGINAL;
                break;
            case self::IMAGE_SIZE_SMALL:
                $size = self::IMAGE_SIZE_SMALL;
                break;
            case self::IMAGE_SIZE_SQUARE_100:
                $size = self::IMAGE_SIZE_SQUARE_100;
                break;
            case self::IMAGE_SIZE_SQUARE_75:
                $size = self::IMAGE_SIZE_SQUARE_75;
                break;
            case self::IMAGE_SIZE_THUMB:
                $size = self::IMAGE_SIZE_THUMB;
                break;
            default:
                break;
        }
        $response = $this->getInfo($photo_id);
        $decoded = StileroFlickrResponse::handle($response);
        $protocol = 'http://';
        $farm = 'farm'.$decoded->photo->farm.'.';
        $host = 'staticflickr.com/';
        $server = $decoded->photo->server.'/';
        $imgid = $decoded->photo->id.'_';
        $secret = $decoded->photo->secret.'_';
        $type = '.jpg';
        $src = $protocol.$farm.$host.$server.$imgid.$secret.$size.$type;
        return $src;
    }
    /**
     * Returns the medium image src
     * @param string $photo_id
     * @return string Image source url
     */
    public function getImageMedium($photo_id){
        $src = $this->getImage($photo_id, self::IMAGE_SIZE_MEDIUM);
        return $src;
    }
    /**
     * Returns the large image src
     * @param string $photo_id
     * @return string Image source url
     */
    public function getImageLarge($photo_id){
        $src = $this->getImage($photo_id, self::IMAGE_SIZE_LARGE);
        return $src;
    }
    /**
     * Returns the small image src
     * @param string $photo_id
     * @return string Image source url
     */
    public function getImageSmall($photo_id){
        $src = $this->getImage($photo_id, self::IMAGE_SIZE_SMALL);
        return $src;
    }
    /**
     * Returns the original image src
     * @param string $photo_id
     * @return string Image source url
     */
    public function getImageOriginal($photo_id){
        $src = $this->getImage($photo_id, self::IMAGE_SIZE_ORIGINAL);
        return $src;
    }
    /**
     * Returns the square 100 image src
     * @param string $photo_id
     * @return string Image source url
     */
    public function getImageSquare100($photo_id){
        $src = $this->getImage($photo_id, self::IMAGE_SIZE_SQUARE_100);
        return $src;
    }
    /**
     * Returns the Square 75 image src
     * @param string $photo_id
     * @return string Image source url
     */
    public function getImageSquare75($photo_id){
        $src = $this->getImage($photo_id, self::IMAGE_SIZE_SQUARE_75);
        return $src;
    }
    /**
     * Returns the thumb image src
     * @param string $photo_id
     * @return string Image source url
     */
    public function getImageThumb($photo_id){
        $src = $this->getImage($photo_id, self::IMAGE_SIZE_THUMB);
        return $src;
    }
}
