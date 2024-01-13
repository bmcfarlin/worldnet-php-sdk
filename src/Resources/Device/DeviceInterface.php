<?php

namespace Worldnet\Resources\Device;

class DeviceInterface
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

  public function search($filter = [])
  {
    if(!array_key_exists('pageSize', $filter)){
      $filter['pageSize'] = 100;
    }
    $url = "/merchant/api/v2/boarding/devices";
    $token = $this->_client->getBToken();
    $header = ["Content-Type: application/json", "Authorization: Bearer $token"];
    $json = $this->_client->get($url, $header, $filter);
    return json_decode($json);
  }

  public function deactivate($id)
  {
    $url = "/merchant/api/v2/boarding/devices/$id/deactivate";
    $token = $this->_client->getBToken();
    $header = ["Content-Type: application/json", "Authorization: Bearer $token"];
    $json = $this->_client->patch($url, $header);
    return json_decode($json);
  }

}


