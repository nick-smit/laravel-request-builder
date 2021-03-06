<?php
declare(strict_types = 1);

namespace NickSmit\LaravelRequestBuilder\Builder\Fields;

use NickSmit\LaravelRequestBuilder\Builder\FieldInterface;
use NickSmit\LaravelRequestBuilder\Builder\WithRules;
use NickSmit\LaravelRequestBuilder\Builder\WithType;
use PhpParser\Node\Expr;

/**
 * Class BoolField
 */
final class BooleanField implements FieldInterface
{
    use WithRules, WithType;

    /**
     * @var string
     */
    private $name;
    /**
     * @var array
     */
    private $rules = ['bool'];

    /**
     * BooleanField constructor.
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getRules(): array
    {
        return $this->rules;
    }

    public function getReturnType(): string
    {
        return 'bool';
    }

    public function getCast(Expr\MethodCall $expr): Expr
    {
        return new Expr\Cast\Bool_($expr);
    }

    public function accepted(): self
    {
        $this->rules[] = __FUNCTION__;

        return $this;
    }
}
