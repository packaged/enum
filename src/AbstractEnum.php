<?php
namespace Packaged\Enum;

use InvalidArgumentException;
use Packaged\Helpers\Strings;
use ReflectionClass;
use function array_values;
use function in_array;

abstract class AbstractEnum
{
  private static $_valueCache = [];
  private $_value;

  public function __construct($value)
  {
    $this->_setValue($value);
  }

  /**
   * @return array
   */
  final public static function getKeyedValues()
  {
    $return = [];
    foreach(static::_valueCache() as $value)
    {
      $return[$value] = static::getDisplayValue($value);
    }
    return $return;
  }

  final private static function _valueCache()
  {
    if(!isset(self::$_valueCache[static::class]))
    {
      /** @noinspection PhpUnhandledExceptionInspection */
      $oClass = new ReflectionClass(static::class);
      self::$_valueCache[static::class] = $oClass->getConstants();
    }
    return self::$_valueCache[static::class];
  }

  final public static function getValues()
  {
    return array_values(static::_valueCache());
  }

  public static function getConstants()
  {
    return static::_valueCache();
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

  /**
   * @param $value
   *
   * @return bool
   */
  final public static function isValid($value)
  {
    return in_array($value, static::_valueCache(), false);
  }

  /**
   * @param $value
   *
   * @return bool
   */
  final public static function isValidStrict($value)
  {
    return in_array($value, static::_valueCache(), true);
  }

  /**
   * Check the current enum is of type X
   *
   * @param mixed $value Enum value to match the current enum against
   *
   * @return bool
   */
  final public function is($value)
  {
    return $value instanceof AbstractEnum ? $this->_enumMatch($value) : $this->getValue() === $value;
  }

  /**
   * Override this method to support more advanced enum matching
   *
   * @param AbstractEnum $enum
   *
   * @return bool
   */
  protected function _enumMatch(AbstractEnum $enum)
  {
    return $this instanceof static && $this->getValue() === $enum->getValue();
  }

  final public function getValue()
  {
    return $this->_value;
  }

  /**
   * @return string
   */
  public function __toString()
  {
    return (string)$this->_value;
  }

  final protected function _setValue($value)
  {
    if(!static::isValidStrict($value))
    {
      throw new \InvalidArgumentException('Invalid enum value for ' . static::class);
    }
    $this->_value = $value;
  }

  /**
   * @param       $method
   * @param array $args
   *
   * @return $this
   */
  public static function __callStatic($method, array $args)
  {
    foreach(static::_valueCache() as $key => $value)
    {
      if($method === $key)
      {
        return new static($value, ...$args);
      }
    }
    throw new InvalidArgumentException($method . ' is not a valid value for ' . static::class);
  }
}
