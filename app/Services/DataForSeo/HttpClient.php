<?php

namespace App\Services\DataForSeo;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\PendingRequest;

class HttpClient
{
    /**
     * @var string
     */
    private string $apiBaseUrl;

    /**
     * @var \Illuminate\Http\Client\PendingRequest
     */
    private ?PendingRequest $http = null;

    /**
     * @var string
     */
    private string $login;

    /**
     * @var string
     */
    private string $password;

    public function __construct()
    {
        $runMode = config('dataforseo.mode');

        $this->apiBaseUrl = config("dataforseo.{$runMode}.url");
        $this->login = config("dataforseo.{$runMode}.login");
        $this->password = config("dataforseo.{$runMode}.password");
    }

    /**
     * @return void
     */
    private function createClient(): void
    {
        $this->http = Http::withBasicAuth(
            $this->login,
            $this->password
        )->baseUrl($this->apiBaseUrl);
    }

   /**
    * @param string $method
    * @param string $url
    * @param array $options
    */
    public function request(string $method, string $url, array $options = [])
    {
        $this->createClient();

        switch (strtolower($method)) {
            case 'get':
                $this->http->asForm();
                break;
            default:
                $this->http->asJson();
        }

        return $this->http->send($method, $url, $options)->object();
    }
}
