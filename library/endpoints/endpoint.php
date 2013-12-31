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

class StileroFlickrEndpoint extends StileroFlickrCommunicator{
    
    protected $Api;
    protected $auth_token;


    public function __construct(StileroFlickrApi $Api, $auth_token) {
        parent::__construct();
        $this->Api = $Api;
        $this->auth_token = $auth_token;
    }
    
    public function request(array $params, $url){
        $auth_params = array(
            'api_key' => $this->Api->key,
            'auth_token' => $this->auth_token
        );
        $combined_params = array_merge($auth_params, $params);
        $signature = StileroFlickrSignature::getSignature($combined_params, $this->Api);
        $combined_params['api_sig'] = $signature;
        $this->setPostVars($combined_params);
        $this->setUrl($url);
        $this->query();
        return $this->getResponse();
    }
    
}
