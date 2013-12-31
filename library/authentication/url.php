<?php
/**
 * Flickr_API
 * Authentication URL for building Authentication urls
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

class StileroFlickrUrl{
    
    protected $Api;
    protected $url;
    
    const API_BASE_URL = 'http://flickr.com/services/auth/';
    
    public function __construct(StileroFlickrApi $Api) {
        $this->Api = $Api;
    }
    
    /**
     * Builds and returns the url for authentication of the request
     * @param string $perms Permission string (read, write, delete) Use StileroFlickrPermission constants
     * @return string Url
     */
    public function getUrl($perms='read'){
        $params = array(
            'api_key' => $this->Api->key,
            'perms' => $perms
        );
        $signature = StileroFlickrSignature::getSignature($params, $this->Api);
        $params['api_sig'] = $signature;
        $url = self::API_BASE_URL.'?'.http_build_query($params);
        return $url;
    }
}
