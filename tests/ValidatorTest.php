<?php
/**
 * 验证器单元测试
 */

namespace GraphQLResolve\Tests;

use GraphQLResolve\Validators\Validator;
use PHPUnit\Framework\TestCase;
use \UnexpectedValueException;

class ValidatorTest extends TestCase
{
    protected $rules;

    /**
     * 基竟构建
     */
    public function setup()
    {
        parent::setup();
        $this->rules      = [
            'a' => 'required',
            'b' => 'required',
            'c' => 'required|type:string',
            'e' => 'required|type:string,callable',
            'f' => 'type:string,array',
        ];
    }

    /**
     * 验证必填项 全部为空
     *
     * @expectedException UnexpectedValueException
     * @covers Validator::assertArray
     */
    public  function testRuleRequiredEmptyValue()
    {
        $testValue  = [];
        Validator::assertArray($this->rules, $testValue);
    }

    /**
     * 验证必填项 缺少某一项
     *
     * @expectedException UnexpectedValueException
     * @covers Validator::assertArray
     */
    public  function testRuleRequiredSomeField()
    {
        $testValue  = [
            'a' => 1,
            'b' => 2,
        ];
        Validator::assertArray($this->rules, $testValue);
    }

    /**
     * 验证必填项 类型判断
     *
     * @expectedException UnexpectedValueException
     * @covers Validator::assertArray
     */
    public  function testRuleRequiredWithType()
    {
        $testValue  = [
            'a' => 1,
            'b' => 2,
            'c' => 123,
        ];
        Validator::assertArray($this->rules, $testValue);
    }

    /**
     * 验证必填项 多类型判断 正常执行不抛异常
     * @covers Validator::assertArray
     */
    public  function testRuleRequiredWithTypeMulti()
    {
        $testValue  = [
            'a' => 1,
            'b' => 2,
            'c' => 'abc',
            'e' => 'abc',
        ];
        Validator::assertArray($this->rules, $testValue);
        $testValue['e'] = function () {};
        Validator::assertArray($this->rules, $testValue);
        $testValue['e'] = [$this, 'assertTrue'];
        Validator::assertArray($this->rules, $testValue);
        $this->assertTrue(true);
    }

    /**
     * 验证非必填项 多类型判断 正常执行不抛异常
     * @covers Validator::assertArray
     */
    public  function testRuleOptionalWithTypeMulti()
    {
        $testValue  = [
            'a' => 1,
            'b' => 2,
            'c' => 'abc',
            'e' => 'abc',
        ];
        Validator::assertArray($this->rules, $testValue);
        $testValue['f'] = [$this, 'assertTrue'];
        Validator::assertArray($this->rules, $testValue);
        $testValue['f'] = '正常值';
        Validator::assertArray($this->rules, $testValue);
        $this->assertTrue(true);
    }

    /**
     * 验证非必填项 多类型判断 抛异常
     *
     * @expectedException UnexpectedValueException
     * @covers Validator::assertArray
     */
    public  function testRuleOptionalWithTypeMultiException()
    {
        $testValue  = [
            'a' => 1,
            'b' => 2,
            'c' => 'abc',
            'e' => 'abc',
            'f' => 65535,
        ];
        Validator::assertArray($this->rules, $testValue);
        $this->assertTrue(true);
    }
}