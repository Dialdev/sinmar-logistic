<?php

/**
 * Twitter-API-PHP : Simple PHP wrapper for the v1.1 API
 * 
 * PHP version 5.3.10
 * 
 * @category Awesomeness
 * @package  Twitter-API-PHP
 * @author   James Mallison <me@j7mbo.co.uk>
 * @license  MIT License
 * @version  1.0.4
 * @link     http://github.com/j7mbo/twitter-api-php
 */
if ( !class_exists('SLZ_Twitter_New_Tweet_API') ) :

class SLZ_Twitter_New_Tweet_API
{
    /**
     * @var string
     */
    private $oauth_access_token;

    /**
     * @var string
     */
    private $oauth_access_token_secret;

    /**
     * @var string
     */
    private $consumer_key;

    /**
     * @var string
     */
    private $consumer_secret;

    /**
     * @var array
     */
    private $postfields;

    /**
     * @var string
     */
    private $getfield;

    /**
     * @var mixed
     */
    protected $oauth;

    /**
     * @var string
     */
    public $url;

    /**
     * @var string
     */
    public $requestMethod;

    public $oauth_details;

    /**
     * Create the API access object. Requires an array of settings::
     * oauth access token, oauth access token secret, consumer key, consumer secret
     * These are all available by creating your own application on dev.twitter.com
     * Requires the cURL library
     *
     * @throws \Exception When cURL isn't installed or incorrect settings parameters are provided
     *
     * @param array $settings
     */
    public function __construct(array $settings)
    {
 
        if (!isset($settings['oauth_access_token'])
            || !isset($settings['oauth_access_token_secret'])
            || !isset($settings['consumer_key'])
            || !isset($settings['consumer_secret']))
        {
            throw new Exception('Make sure you are passing in the correct parameters');
        }

        $this->oauth_access_token = $settings['oauth_access_token'];
        $this->oauth_access_token_secret = $settings['oauth_access_token_secret'];
        $this->consumer_key = $settings['consumer_key'];
        $this->consumer_secret = $settings['consumer_secret'];
    }

    /**
     * Set postfields array, example: array('screen_name' => 'J7mbo')
     *
     * @param array $array Array of parameters to send to API
     *
     * @throws \Exception When you are trying to set both get and post fields
     *
     * @return TwitterAPIExchange Instance of self for method chaining
     */
    public function setPostfields(array $array)
    {
        $this->postfields = $array;
        return $this;
    }
    
    /**
     * Set getfield string, example: '?screen_name=J7mbo'
     * 
     * @param string $string Get key and value pairs as string
     *
     * @throws \Exception
     * 
     * @return \TwitterAPIExchange Instance of self for method chaining
     */
    public function setGetfield($string)
    {
        $this->getfield = $string;
        return $this;
    }
    
    /**
     * Get getfield string (simple getter)
     * 
     * @return string $this->getfields
     */
    public function getGetfield()
    {
        return $this->getfield;
    }
    
    /**
     * Get postfields array (simple getter)
     * 
     * @return array $this->postfields
     */
    public function getPostfields()
    {
        return $this->postfields;
    }
    
    /**
     * Build the Oauth object using params set in construct and additionals
     * passed to this method. For v1.1, see: https://dev.twitter.com/docs/api/1.1
     *
     * @param string $url           The API url to use. Example: https://api.twitter.com/1.1/search/tweets.json
     * @param string $requestMethod Either POST or GET
     *
     * @throws \Exception
     *
     * @return \TwitterAPIExchange Instance of self for method chaining
     */
    public function buildOauth($url, $requestMethod)
    {
        if ( ! in_array( strtolower( $requestMethod ), array( 'post', 'get' ) ) ) {
            return new WP_Error( 'invalid_request', 'Request method must be either POST or GET' );
        }

        $oauth_credentials = array(
            'oauth_consumer_key'     => $this->consumer_key,
            'oauth_nonce'            => time(),
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_token'            => $this->oauth_access_token,
            'oauth_timestamp'        => time(),
            'oauth_version'          => '1.0'
        );

        if ( ! is_null( $this->getfield ) ) {
            // remove question mark(?) from the query string
            $getfield = str_replace( '?', '', explode( '&', $this->getfield ) );

            foreach ( $getfield as $field ) {
                // split and add the GET key-value pair to the post array.
                // GET query are always added to the signature base string
                $split                          = explode( '=', $field );
                $oauth_credentials[ $split[0] ] = $split[1];
            }
        }

        // convert the oauth credentials (including the GET QUERY if it is used) array to query string.
        $signature = $this->buildBaseString( $url, $requestMethod, $oauth_credentials );

        $oauth_credentials['oauth_signature'] = $this->generate_oauth_signature( $signature );

        // save the request url for use by WordPress HTTP API
        $this->url = $url;

        // save the OAuth Details
        $this->oauth_details = $oauth_credentials;

        $this->requestMethod = $requestMethod;

        return $this;
    }
    
    /**
     * Perform the actual data retrieval from the API
     * 
     * @param boolean $return      If true, returns data. This is left in for backward compatibility reasons
     * @param array   $curlOptions Additional Curl options for this request
     *
     * @throws \Exception
     * 
     * @return string json If $return param is true, returns json data.
     */
    public function performRequest($return = true, $curlOptions = array())
    {
        if (!is_bool($return))
        {
            throw new Exception('performRequest parameter must be true or false');
        }

        $getfield = $this->getGetfield();
        $postfields = $this->getPostfields();

        $header = $this->buildAuthorizationHeader($this->oauth_details);
        $args = array(
            'headers'   => array( 'Authorization' => $header ),
            'timeout'   => 45,
            'sslverify' => false,
            'compress'    => true,
            'decompress'  => false,
        );
        if ( ! is_null( $this->postfields ) ) {
            $args['body'] = $this->postfields;
            $response = wp_remote_post( $this->url, $args );
            return wp_remote_retrieve_body( $response );
        }
        else {
            // add the GET parameter to the Twitter request url or endpoint
            $url = $this->url . $this->getfield;
            $response = wp_remote_get( $url, $args );
            return wp_remote_retrieve_body( $response );
        }
    }
    
    /**
     * Private method to generate the base string used by cURL
     * 
     * @param string $baseURI
     * @param string $method
     * @param array  $params
     * 
     * @return string Built base string
     */
    private function buildBaseString($baseURI, $method, $params) 
    {
        $return = array();
        ksort($params);

        foreach($params as $key => $value)
        {
            $return[] = "$key=$value";
        }
        
        return $method . "&" . rawurlencode($baseURI) . '&' . rawurlencode(implode('&', $return)); 
    }
    
    /**
     * Private method to generate authorization header used by cURL
     * 
     * @param array $oauth Array of oauth data generated by buildOauth()
     * 
     * @return string $return Header used by cURL for request
     */    
    private function buildAuthorizationHeader(array $oauth)
    {
        $return = 'OAuth ';
        $values = array();

        foreach($oauth as $key => $value)
        {
            $values[] = "$key=\"" . rawurlencode( $value ) . '"';
        }
        
        $return .= implode(', ', $values);

        return $return;
    }

    private function generate_oauth_signature( $data ) {
        // encode consumer and token secret keys and subsequently combine them using & to a query component
        $hash_hmac_key = rawurlencode( $this->consumer_secret ) . '&' . rawurlencode( $this->oauth_access_token_secret );
        $oauth_signature = base64_encode( hash_hmac( 'sha1', $data, $hash_hmac_key, true ) );
        return $oauth_signature;
    }

}
endif;