<?php

namespace App\Gateway;

use Microsoft\Graph\Graph;

class GraphGatewayClient extends Graph {
    public $path;
    public $scopes = [];

    public function __construct(
        $token,
        $path = "/me",
        $scopes = []
    )
    {
        parent::__construct();
        $this->setAccessToken($token);
        $this->path = $path;
        $this->scopes = $scopes;
    }

    public function get() {
        return self::createRequest("GET", $this->path)
        ->execute();
    }

    public function post() {
        return self::createRequest("POST", $this->path)
        ->attachBody(json_encode($this->scopes))
        ->execute();
    }

    public function patch() {
        return self::createRequest("PATCH", $this->path)
        ->attachBody(json_encode($this->scopes))
        ->execute();
    }

    public function delete() {
        return self::createRequest("DELETE", $this->path)
        ->execute();
    }

}
