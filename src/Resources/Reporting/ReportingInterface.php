<?php

namespace Worldnet\Resources\Reporting;

class ReportingInterface
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

  /**
  * List Batches
  *
  * @return JSON object with data property set to array of batch objects
  */
  public function list($terminal, $filter = [])
  {
    $filter['terminal'] = $terminal;
    if(!array_key_exists('pageSize', $filter)){
      $filter['pageSize'] = 250;
    }
    $url = "/merchant/api/v1/reporting/terminals/{$terminal}/batches/closed";
    $token = $this->_client->getToken();
    $header = ["Content-Type: application/json", "Authorization: Bearer $token"];
    $json = $this->_client->get($url, $header, $filter);
    return json_decode($json);
  }

  /**
  * Get Batch Transactions
  *
  * @return JSON object with data property set to array of transaction objects
  */
  public function get($terminal, $uniqueReference, $filter = [])
  {
    if(!array_key_exists('pageSize', $filter)){
      $filter['pageSize'] = 250;
    }
    $url = "/merchant/api/v1/reporting/terminals/{$terminal}/batches/{$uniqueReference}/closed/transactions";
    $token = $this->_client->getToken();
    $header = ["Content-Type: application/json", "Authorization: Bearer $token"];
    $json = $this->_client->get($url, $header, $filter);
    return json_decode($json);
  }

}


