<?php
namespace GraphQLResolve\Traits;

use \Closure;
/**
 * 获取类型描述
 */
trait TypeDescription
{
    use TypeName;

    /**
     * 获取描述
     *
     * @return string
     */
    public function description(): string
    {
        return $this->getDefaultAttribute('description', function () {

            $name       = $this->name();
            $article    = in_array($name[0], ['A','E','I','O','U']) ? 'an' : 'a';

            return      sprintf('%s %s Object', $article, $name);
        });
    }

    /**
     * 获取字符串值
     *
     * @param string
     * @param \Closure
     * @return string
     */
    abstract protected function getDefaultAttribute(string $attributeName, Closure $default);
}
