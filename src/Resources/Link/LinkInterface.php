<?php

namespace Worldnet\Resources\Link;

class LinkInterface
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

  public function follow($url)
  {
    $token = $this->_client->getToken();
    $header = ["Content-Type: application/json", "Authorization: Bearer $token"];
    $json = $this->_client->get($url, $header);
    return json_decode($json);
  }


}


