<?php namespace Huddle\Zendesk\Services;

use Config, Exception;
use Zendesk\API\Client;

class ZendeskService {

    /**
     * Get auth parameters from config, fail if any are missing.
     * Instantiate API client and set auth token.
     *
     * @throws Exception
     */
    public function __construct() {
        $this->subdomain = Config::get('zendesk-laravel.subdomain');
        $this->username = Config::get('zendesk-laravel.username');
        $this->token = Config::get('zendesk-laravel.token');
        if(!$this->subdomain || !$this->username || !$this->token) {
            throw new Exception('Please set ZENDESK_SUBDOMAIN, ZENDESK_USERNAME and ZENDESK_TOKEN environment variables.');
        }
        $this->client = new Client($this->subdomain, $this->username);
        $this->client->setAuth('token',$this->token);
    }

    /**
     * Pass any method calls onto $this->client
     *
     * @return mixed
     */
    public function __call($method, $args) {
        if(is_callable([$this->client,$method])) {
            return call_user_func_array([$this->client,$method],$args);
        }
    }

}