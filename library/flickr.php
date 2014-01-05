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

class StileroFlickr{
    
    protected $Api;
    protected $Frob;
    protected $perms;
    protected $People;
    protected $Photos;
    protected $Photoscomments;
    protected $Photouploader;
    public $auth_token;
    
    public function __construct($api_key, $api_secret, $auth_token = null, $perms='read') {
        $this->Api = new StileroFlickrApi($api_key, $api_secret);
        $this->Frob = new StileroFlickrFrob();
        $this->perms = $perms;
        $this->auth_token = $auth_token;
        $this->init();
        return $this;
    }
    /**
     * Initializes all endpoints
     */
    private function _endpoints(){
        $this->People = new StileroFlickrPeople($this->Api, $this->auth_token);
        $this->Photos = new StileroFlickrPhotos($this->Api, $this->auth_token);
        $this->Photoscomments = new StileroFlickrPhotoscomments($this->Api, $this->auth_token);
        $this->Photouploader = new StileroFlickrPhotouploader($this->Api, $this->auth_token);
        return $this;
    }
    /**
     * Initializes the API
     * If a token is not set then you will be redirected to the auth page
     */
    public function init(){
        if( !isset($this->auth_token) && !StileroFlickrFrob::hasFrobInGetRequest() ){
            $Url = new StileroFlickrUrl($this->Api);
            $Url->redirectToUrl($this->perms);
        }else if( StileroFlickrFrob::hasFrobInGetRequest() ){
            $this->Frob->fetchFrob();
            $Authtoken = new StileroFlickrAuthtoken($this->Api, $this->Frob);
            $Authtoken->getToken();
            $this->auth_token = $Authtoken->token;
        }if(isset($this->auth_token)){
            $this->_endpoints();
        }
        return $this;
    }
    /**
     * Sets the access token
     * @param string $token
     */
    public function setAccessToken($token){
        $this->auth_token = $token;
    }
    
    /**
     * WRAPPER METHODS FOR EASY ACCESS TO THE ENDPOINTS
     */
    
    /**
     * Wrapper method for accessing people endpoint
     * @return \StileroFlickrPeople People endpoint
     */
    public function People(){
        if(isset($this->People)){
           return $this->People; 
        }
        $People = new StileroFlickrPeople($this->Api, $this->auth_token);
        $this->People = $People;
        return $People;
    }
    /**
     * Wrapper method for accessing photos endpoint
     * @return \StileroFlickrPhotos Photos Endpoint
     */
    public function Photos(){
        if(isset($this->Photos)){
            return $this->Photos;
        }
        $Photos = new StileroFlickrPhotos($this->Api, $this->auth_token);
        $this->Photos = $Photos;
        return $Photos;
    }
    /**
     * Wrapper for accessing photo comments
     * @return \StileroFlickrPhotoscomments Comments endpoint
     */
    public function Photoscomments(){
        if(isset($this->Photoscomments)){
            return $this->Photoscomments;
        }
        $Comments = new StileroFlickrPhotoscomments;
        $this->Photoscomments = $Comments;
        return $Comments;
    }
    /**
     * Wrapper for accessing the uploader
     * @return \StileroFlickrPhotouploader Uploader endpoint
     */
    public function Photouploader(){
        if(isset($this->Photouploader)){
            return $this->Photouploader;
        }
        $Uploader = new StileroFlickrPhotouploader;
        $this->Photouploader = $Uploader;
        return $Uploader;
    }
}
