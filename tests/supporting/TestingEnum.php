<?php

namespace Packaged\Tests\supporting;

use Packaged\Enum\AbstractEnum;

/**
 * @method static TestingEnum V1()
 * @method static TestingEnum V2()
 * @method static TestingEnum V3()
 */
class TestingEnum extends AbstractEnum
{
  const V1 = 'v1';
  const V2 = 'v2';
  const V3 = '3';

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

  protected function _enumMatch(AbstractEnum $enum)
  {
    /** @var static $enum */
    return parent::_enumMatch($enum) && $this->getUrl() === $enum->getUrl();
  }

}
