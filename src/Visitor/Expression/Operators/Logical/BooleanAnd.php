<?php

namespace PHPSA\Visitor\Expression\Operators\Logical;

use PHPSA\CompiledExpression;
use PHPSA\Context;
use PHPSA\Visitor\Expression;
use PHPSA\Visitor\Expression\AbstractExpressionCompiler;

class BooleanAnd extends AbstractExpressionCompiler
{
    protected $name = '\PhpParser\Node\Expr\BinaryOp\BooleanAnd';

    /**
     * {expr} && {expr}
     *
     * @param \PhpParser\Node\Expr\BinaryOp\BooleanAnd $expr
     * @param Context $context
     * @return CompiledExpression
     */
    public function compile($expr, Context $context)
    {
        $expression = new Expression($context);
        $left = $expression->compile($expr->left);

        $expression = new Expression($context);
        $right = $expression->compile($expr->right);

        switch ($left->getType()) {
            case CompiledExpression::LNUMBER:
            case CompiledExpression::DNUMBER:
            case CompiledExpression::STRING:
            case CompiledExpression::BOOLEAN:
            case CompiledExpression::NULL:
                switch ($right->getType()) {
                    case CompiledExpression::LNUMBER:
                    case CompiledExpression::DNUMBER:
                    case CompiledExpression::STRING:
                    case CompiledExpression::BOOLEAN:
                    case CompiledExpression::NULL:
                        return CompiledExpression::fromZvalValue($left->getValue() && $right->getValue());
                }
                break;
        }

        return new CompiledExpression(CompiledExpression::UNKNOWN);
    }
}
