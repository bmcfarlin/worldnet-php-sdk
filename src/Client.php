<?php

namespace Worldnet;

use Worldnet\Resources\Link\LinkInterface;
use Worldnet\Resources\Reporting\ReportingInterface;
use Worldnet\Resources\Transaction\TransactionInterface;
use Worldnet\Resources\Account\AccountInterface;
use Worldnet\Resources\Terminal\TerminalInterface;
use Worldnet\Resources\Boarding\BoardingInterface;
use Worldnet\Resources\Device\DeviceInterface;

class Client
{
  private $_account;
  private $_client;
  private $_terminal;
  private $_reporting;
  private $_transaction;
  private $_boarding;

  function __construct($api_key, $base_url)
  {
    $this->_client = new RestClient($api_key, $base_url);
    $this->account->authenticate();
    $this->boarding->authenticate();
  }

  function __toString()
  {
    return get_class($this);
  }

  public function __get($name)
  {
    $name = ucfirst($name);
    $method = sprintf("get%s", $name);
    if(method_exists($this, $method))
    {
      return $this->$method();
    }
    throw new \Exception('Unknown resource ' . $name);
  }

  function getAccount()
  {
    if(empty($this->_account))
    {
      $this->_account = new AccountInterface($this->_client);
    }
    return $this->_account;
  }

  function getTerminal()
  {
    if(empty($this->_terminal))
    {
      $this->_terminal = new TerminalInterface($this->_client);
    }
    return $this->_terminal;
  }

  function getTransaction()
  {
    if(empty($this->_transaction))
    {
      $this->_transaction = new TransactionInterface($this->_client);
    }
    return $this->_transaction;
  }

  function getReporting()
  {
    if(empty($this->_reporting))
    {
      $this->_reporting = new ReportingInterface($this->_client);
    }
    return $this->_reporting;
  }

  function getLink()
  {
    if(empty($this->_link))
    {
      $this->_link = new LinkInterface($this->_client);
    }
    return $this->_link;
  }

  function getBoarding()
  {
    if(empty($this->_boarding))
    {
      $this->_boarding = new BoardingInterface($this->_client);
    }
    return $this->_boarding;
  }

  function getDevice()
  {
    if(empty($this->_device))
    {
      $this->_device = new DeviceInterface($this->_client);
    }
    return $this->_device;
  }

}
