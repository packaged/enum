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
    $this->assertEquals(TestEnum::getConstants(), ['V1' => 'v1', 'V2' => 'v2', 'V3' => '3']);
    $this->assertEquals(TestEnumDisplay::getKeyedValues(), ['v1' => 'Version 1', 'v2' => 'Version 2', '3' => '3']);
    $this->assertEquals(TestEnumDisplay::getConstants(), ['V1' => 'v1', 'V2' => 'v2', 'V3' => '3']);
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
    $enum = new TestEnum(TestEnum::V1);
    $this->assertEquals(TestEnum::V1, $enum->getValue());
  }

  public function testInstancedStaticEnum()
  {
    $this->assertEquals(TestEnum::V1, TestEnum::V1()->getValue());
  }

  public function testInvalidInstancedStaticEnum()
  {
    $this->expectExceptionMessage("V_gd is not a valid value for Packaged\Tests\supporting\TestEnum");
    TestEnum::V_gd();
  }

  public function testInstancedEnumUrl()
  {
    $enum = new TestEnum(TestEnum::V1, 'api.com');
    $this->assertEquals(TestEnum::V1, $enum->getValue());
    $this->assertEquals('v1-api.com', $enum->getUrl());
  }

  public function testMatch()
  {
    $enum = new TestEnum(TestEnum::V1, 'api.com');
    $this->assertTrue($enum->is(TestEnum::V1));
    $this->assertFalse($enum->is(new TestEnum(TestEnum::V1)));
    $this->assertTrue($enum->is(new TestEnum(TestEnum::V1, 'api.com')));
  }

  public function testToString()
  {
    $this->assertEquals('v2', (string)TestEnumDisplay::V2());
  }
}
