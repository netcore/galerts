<?php

namespace Netcore\GAlerts;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\FileCookieJar;

class ManagerBase
{
    /**
     * Endpoints
     */
    const CREATE_ENDPOINT = 'https://www.google.com/alerts/create?';
    const DELETE_ENDPOINT = 'https://www.google.com/alerts/delete?';
    const MODIFY_ENDPOINT = 'https://www.google.com/alerts/modify?';

    /**
     * Base endpoints
     */
    const GOOGLE_URL = 'https://google.com';
    const BASE_URL   = 'https://google.com/alerts';

    /**
     * Auth endpoints
     */
    const AUTH_URL  = 'https://accounts.google.com/ServiceLoginAuth';
    const LOGIN_URL = 'https://accounts.google.com/ServiceLogin?service=alerts&hl=en&continue=https://google.com/alerts';

    /**
     * Response states
     *
     * @var array
     */
    protected static $responses = [
        'ALERT_EXIST'                => "[null,11,null,\"\"]",
        'ALERT_SOMETHING_WENT_WRONG' => "[null,7,null,\"\"]",
        'ALERT_NOT_EXIST'            => "[null,5,null,\"\"]",
        'ALERT_LIMIT_EXCEEDED'       => "[null,4,null,\"\"]",
    ];

    /**
     * Guzzle client
     *
     * @var $resource Client
     */
    protected $resource;

    /**
     * ManagerBase constructor.
     */
    public function __construct()
    {
        $this->authorize();
    }

    /**
     * Handle authentication
     *
     * @return void
     */
    protected function authorize()
    {
        // Create client to make requests
        $client = new Client([
            'cookies'         => new FileCookieJar(storage_path('galerts_cookies.txt')),
            'allow_redirects' => true,
            'headers'         => [
                'User-Agent' => 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)',
            ],
        ]);

        // Parse login form
        $loginResponse = $client->get(self::LOGIN_URL);
        $loginBody = (string) $loginResponse->getBody();
        $loginForm = FormUtils::getFormFields($loginBody);

        // Modify auth data
        $loginForm['Email'] = config('galerts.user');
        $loginForm['Passwd'] = config('galerts.pass');

        unset($loginForm['PersistentCookie']);

        // Send auth request
        $client->post(self::AUTH_URL, [
            'form_params' => $loginForm,
        ]);

        $this->resource = $client;
    }

}