<?php
namespace GraphQLResolve\Validators;

use GraphQLResolve\Traits\Singleton;
use UnexpectedValueException;
use Exception;

/**
 * 验证器
 */
class Validator
{
    use Singleton;

    /**
     * 规则分隔符
     */
    const RULE_SEPARATOR    = '|';

    /**
     * 规则边界
     */
    const RULE_BOUNDARY     = ':';

    /**
     * 规则参数分隔符
     */
    const PARAM_SEPARATOR   = ',';

    public static function assertArray(array $mapRules, array $mapValues)
    {
        foreach ($mapRules as $item => $ruleExpression) {

            try {
                $value  = isset($mapValues[$item])  ? $mapValues[$item] : NotExists::getInstance();
                self::assertRule($ruleExpression, $value);
            } catch (UnexpectedValueException $e) {
                throw new UnexpectedValueException($e->getMessage() . ' for key: ' . $item . ' .');
            }
        }
    }

    public static function assertRule(string $ruleExpression, $value)
    {
        self::getInstance()->executeRule($ruleExpression, $value);
    }

    public function executeRule (string $ruleExpression, $value)
    {
        $ruleStructure  = $this->parseRule($ruleExpression);
        array_map(function ($ruleInfo) use ($value) {
            $ruleName       = $ruleInfo['ruleName'];
            $ruleParams     = $ruleInfo['ruleParams'];
            $ruleInstance   = $this->getRule($ruleName);
            $ruleInstance->handler($value, $ruleParams);
        }, $ruleStructure);
    }

    /**
     * 解析规则表达式
     *
     * @param string $ruleExpression
     * @return array
     */
    public function parseRule(string $ruleExpression): array
    {
        $structure  = [];

        foreach (explode(self::RULE_SEPARATOR, $ruleExpression) as $ruleClip) {

            $ruleResolve    = explode(self::RULE_BOUNDARY, $ruleClip);
            $ruleParams     = isset($ruleResolve[1])
                            ? explode(self::PARAM_SEPARATOR, $ruleResolve[1])
                            : [];
            $structure[]    = [
                'ruleName'      => $ruleResolve[0],
                'ruleParams'    => $ruleParams,
            ];
        }

        return      $structure;
    }

    protected   function getRule (string $ruleName)
    {
        $ruleClass  = __NAMESPACE__ . '\\Rules\\' . ucfirst($ruleName);
        $callback   = [$ruleClass, 'getInstance'];

        if (is_callable($callback)) {

            return  call_user_func($callback);
        }

        throw new Exception('Rule ' . $ruleName . ' (' . $ruleClass . ') not exists.');
    }
}
