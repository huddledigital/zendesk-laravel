<?php namespace Huddle\Zendesk\Services;

use Config, InvalidArgumentException, BadMethodCallException;
use Zendesk\API\Client;

class ZendeskService {

    /**
     * Get auth parameters from config, fail if any are missing.
     * Instantiate API client and set auth token.
     *
     * @throws Exception
     */
    public function __construct() {
        $this->subdomain = config('zendesk-laravel.subdomain');
        $this->username = config('zendesk-laravel.username');
        $this->token = config('zendesk-laravel.token');
        if(!$this->subdomain || !$this->username || !$this->token) {
            throw new InvalidArgumentException('Please set ZENDESK_SUBDOMAIN, ZENDESK_USERNAME and ZENDESK_TOKEN environment variables.');
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
        } else {
            throw new BadMethodCallException("Method $method does not exist");
        }
    }

}