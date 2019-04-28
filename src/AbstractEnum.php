<?php
namespace Packaged\Enum;

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
  public static function getKeyedValues()
  {
    $return = [];
    foreach(static::getValues() as $value)
    {
      $return[$value] = static::getDisplayValue($value);
    }
    return $return;
  }

  public static function getValues()
  {
    if(!isset(self::$_valueCache[static::class]))
    {
      /** @noinspection PhpUnhandledExceptionInspection */
      $oClass = new ReflectionClass(static::class);
      self::$_valueCache[static::class] = array_values($oClass->getConstants());
    }
    return self::$_valueCache[static::class];
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

  final protected function _setValue($value)
  {
    if(!static::isValidStrict($value))
    {
      throw new \InvalidArgumentException('Invalid enum value for ' . static::class);
    }
    $this->_value = $value;
  }
}
