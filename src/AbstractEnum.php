<?php
namespace Packaged\Enum;

use Packaged\Helpers\Strings;

abstract class AbstractEnum
{
  private static $_valueCache = [];

  private $_value;

  public function __construct($value)
  {
    $this->_setValue($value);
  }

  final protected function _setValue($value)
  {
    if(!static::isValidStrict($value))
    {
      throw new \InvalidArgumentException('Invalid enum value for ' . static::class);
    }
    $this->_value = $value;
  }

  final public function getValue()
  {
    return $this->_value;
  }

  public static function getValues(): array
  {
    $class = static::class;
    if(!isset(self::$_valueCache[$class]))
    {
      /** @noinspection PhpUnhandledExceptionInspection */
      $oClass = new \ReflectionClass($class);
      self::$_valueCache[$class] = array_values($oClass->getConstants());
    }
    return self::$_valueCache[$class];
  }

  /**
   * @return array
   */
  public static function getKeyedValues(): array
  {
    $return = [];
    foreach(static::getValues() as $value)
    {
      $return[$value] = static::getDisplayValue($value);
    }
    return $return;
  }

  /**
   * @param $value
   *
   * @return bool
   */
  public static function isValid($value)
  {
    return in_array($value, static::getValues(), false);
  }

  /**
   * @param $value
   *
   * @return bool
   */
  public static function isValidStrict($value)
  {
    return in_array($value, static::getValues(), true);
  }

  /**
   * @param $value
   *
   * @return string
   */
  public static function getDisplayValue($value)
  {
    return Strings::titleize($value);
  }
}