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

class StileroFlickrPeople extends StileroFlickrEndpoint{
    
    const API_URL = 'http://flickr.com/services/rest/';
    
    public function __construct(\StileroFlickrApi $Api, $auth_token) {
        parent::__construct($Api, $auth_token);
        return $this;
    }
    
    public function getInfoFromId($id){
        $params = array(
            'method' => 'flickr.people.getInfo',
            'user_id' => $id
        );
        return $this->request($params, self::API_URL);
    }
    
    public function findByUsername($username){
        $params = array(
            'method' => 'flickr.people.findByUsername',
            'username' => $username
        );
        return $this->request($params, self::API_URL);
    }
}
