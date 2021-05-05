<?php namespace Huddle\Zendesk\Services;

use Config, InvalidArgumentException, BadMethodCallException;
use Zendesk\API\HttpClient;

class ZendeskService {

    /**
     * Get auth parameters from config, fail if any are missing.
     * Instantiate API client and set auth token.
     *
     * @throws Exception
     */
    public function __construct() {
        $this->subdomain = config('zendesk-laravel.subdomain');
        $this->username = config('zendesk-laravel.username', '');
        $this->token = config('zendesk-laravel.token');
        if(!$this->subdomain || !$this->token) {
            throw new InvalidArgumentException('Please set ZENDESK_SUBDOMAIN and ZENDESK_TOKEN environment variables.');
        }
        $this->client = new HttpClient($this->subdomain, $this->username);
        if ($this->username != '') {
            $this->client->setAuth('basic', ['username' => $this->username, 'token' => $this->token]);
        } else {
            $this->client->setAuth('oauth', ['token' => $this->token]);
        }
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

    /**
     * Pass any property calls onto $this->client
     *
     * @return mixed
     */
    public function __get($property) {
        if(property_exists($this->client,$property)) {
            return $this->client->{$property};
        } else {
            throw new BadMethodCallException("Property $property does not exist");
        }
    }

}
