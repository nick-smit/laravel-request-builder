<?php
declare(strict_types = 1);

namespace NickSmit\LaravelRequestBuilder\Builder\Fields;

use NickSmit\LaravelRequestBuilder\Builder\FieldInterface;
use NickSmit\LaravelRequestBuilder\Builder\WithRules;

/**
 * Class BoolField
 */
final class BooleanField implements FieldInterface
{
    use WithRules;

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

    public function accepted(): self
    {
        $this->rules[] = __FUNCTION__;

        return $this;
    }
}
