<?php

namespace Packaged\Tests\supporting;

class TestEnumDisplay extends TestEnum
{
  public static function getDisplayValue($value)
  {
    return preg_replace('/^v/', 'Version ', $value);
  }
}