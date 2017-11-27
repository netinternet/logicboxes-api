<?php

namespace Netinternet\Logicboxes\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;

class Base
{
    protected $client;

    public function client()
    {
        return new Client([
            'base_uri' => $this->url(),
            'query' => [
                'auth-userid' => config('logicboxes.auth-userid'),
                'api-key' => config('logicboxes.api-key'),
            ]
        ]);
    }

    public function mode()
    {
        return config('logicboxes.mode');
    }

    public function url()
    {
        if ($this->mode() === 'test') {
            return 'https://test.httpapi.com/api/';
        }

        return 'https://httpapi.com/api/';
    }

    protected function request($url, $query = [], $method = 'GET', $string = false)
    {
        try {
            if (!$string) {
                $response = $this->client()->request($method, $url, [
                    'query' => array_merge($this->client()->getConfig('query'), $query)
                ]);
            } else {
                $query = \GuzzleHttp\Psr7\build_query($query, PHP_QUERY_RFC1738);
                foreach ($this->client()->getConfig('query') as $k => $v) {
                    $query .= "&{$k}={$v}";
                }
                $base = (string)$this->client()->getConfig()['base_uri'];
                $fullUrl = $base.$url."?".$query;
                $client = new Client();
                $response = $client->get($fullUrl);
            }

            return [
                'status' => true,
                'response' => json_decode((string) $response->getBody()),
                'message' => 'success'
            ];
        } catch (ServerException $e) {
            $re = '/"message":"(.*?)[\",(]/';
            preg_match_all($re, $e->getMessage(), $matches, PREG_SET_ORDER, 0);
            $match = $matches[0][1];
            if (strstr($matches[0][1], '\u003d')) {
                $match = str_replace('\u003d', '', strstr($matches[0][1], '\u003d'));
            }

            return [
                'status' => false,
                'response' => null,
                'message' => $match
            ];
        }
    }
}
