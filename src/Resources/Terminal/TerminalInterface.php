<?php

namespace Worldnet\Resources\Terminal;

class TerminalInterface
{

  private $_client;

  function __construct($client)
  {
    $this->_client = $client;
  }

  function __toString()
  {
    return get_class($this);
  }

  public function list()
  {
    $url = "/merchant/api/v1/account/terminals";
    $token = $this->_client->getToken();
    $header = ["Content-Type: application/json", "Authorization: Bearer $token"];
    $json = $this->_client->get($url, $header);
    return json_decode($json);
  }

  public function devices($id)
  {
    $url = "/merchant/api/v1/account/terminals/{$id}/devices";
    $token = $this->_client->getToken();
    $header = ["Content-Type: application/json", "Authorization: Bearer $token"];
    $json = $this->_client->get($url, $header);
    return json_decode($json);
  }

}


