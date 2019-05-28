<?php

namespace Packaged\Tests\supporting;

use Packaged\Enum\AbstractEnum;

/**
 * @method static TestEnum V1()
 * @method static TestEnum V2()
 * @method static TestEnum V3()
 */
class TestEnum extends AbstractEnum
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
