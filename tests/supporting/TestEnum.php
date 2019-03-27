<?php

namespace Packaged\Tests\supporting;

use Packaged\Enum\AbstractEnum;

class TestEnum extends AbstractEnum
{
  const V_1 = 'v1';
  const V_2 = 'v2';
  const V_3 = '3';

  protected $_url;

  public function __construct($value, $url = null)
  {
    parent::__construct($value);
    $this->_url = $value . '-' . $url;
  }

  public function getUrl()
  {
    return $this->_url;
  }
}