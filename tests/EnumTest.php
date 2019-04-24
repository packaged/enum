<?php
namespace Packaged\Tests;

use Packaged\Tests\supporting\TestEnum;
use Packaged\Tests\supporting\TestEnumDisplay;
use PHPUnit\Framework\TestCase;

class EnumTest extends TestCase
{
  public function testEnumValues()
  {
    $this->assertEquals(TestEnum::getValues(), ['v1', 'v2', '3']);
    $this->assertEquals(TestEnum::getKeyedValues(), ['v1' => 'V1', 'v2' => 'V2', '3' => '3']);
    $this->assertEquals(TestEnumDisplay::getKeyedValues(), ['v1' => 'Version 1', 'v2' => 'Version 2', '3' => '3']);
  }

  public function testValid()
  {
    $this->assertTrue(TestEnum::isValid('v1'));
    $this->assertFalse(TestEnum::isValid('1'));
    $this->assertTrue(TestEnum::isValid(3));
    $this->assertFalse(TestEnum::isValidStrict(3));
  }

  public function testFailedInstancedEnum()
  {
    $this->expectException(\InvalidArgumentException::class);
    $this->expectExceptionMessage('Invalid enum value for Packaged\Tests\supporting\TestEnum');
    new TestEnum('not valid');
  }

  public function testInstancedEnum()
  {
    $enum = new TestEnum(TestEnum::V_1);
    $this->assertEquals(TestEnum::V_1, $enum->getValue());
  }

  public function testInstancedEnumUrl()
  {
    $enum = new TestEnum(TestEnum::V_1, 'api.com');
    $this->assertEquals(TestEnum::V_1, $enum->getValue());
    $this->assertEquals('v1-api.com', $enum->getUrl());
  }

  public function testMatch()
  {
    $enum = new TestEnum(TestEnum::V_1, 'api.com');
    $this->assertTrue($enum->is(TestEnum::V_1));
    $this->assertFalse($enum->is(new TestEnum(TestEnum::V_1)));
    $this->assertTrue($enum->is(new TestEnum(TestEnum::V_1, 'api.com')));
  }
}
