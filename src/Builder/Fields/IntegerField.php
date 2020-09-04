<?php
declare(strict_types = 1);

namespace NickSmit\LaravelRequestBuilder\Builder\Fields;

use NickSmit\LaravelRequestBuilder\Builder\FieldInterface;
use NickSmit\LaravelRequestBuilder\Builder\WithRules;

/**
 * Class Integer
 */
class IntegerField implements FieldInterface
{
    use WithRules;

    /**
     * @var string
     */
    private $name;
    /**
     * @var array
     */
    private $rules = [];

    /**
     * Integer constructor.
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
        return array_merge(['integer'], $this->rules);
    }

    public function digits(int $digits): self
    {
        $this->rules[] = $this->ruleWithParameters(__FUNCTION__, $digits);

        return $this;
    }

    public function digitsBetween(int $digitsMin, int $digitsMax): self
    {
        $this->rules[] = $this->ruleWithParameters(__FUNCTION__, $digitsMin, $digitsMax);

        return $this;
    }

    public function greaterThan(string $otherField): self
    {
        $this->rules[] = $this->ruleWithParameters(__FUNCTION__, $otherField);

        return $this;
    }

    public function greaterThanEqual(string $otherField): self
    {
        $this->rules[] = $this->ruleWithParameters(__FUNCTION__, $otherField);

        return $this;
    }

    public function lowerThan(string $otherField): self
    {
        $this->rules[] = $this->ruleWithParameters(__FUNCTION__, $otherField);

        return $this;
    }

    public function lowerThanEqual(string $otherField): self
    {
        $this->rules[] = $this->ruleWithParameters(__FUNCTION__, $otherField);

        return $this;
    }

    public function min(int $min): self
    {
        $this->rules[] = $this->ruleWithParameters(__FUNCTION__, $min);

        return $this;
    }

    public function max(int $max): self
    {
        $this->rules[] = $this->ruleWithParameters(__FUNCTION__, $max);

        return $this;
    }

    public function between(int $min, int $max): self
    {
        $this->rules[] = $this->ruleWithParameters(__FUNCTION__, $min, $max);

        return $this;
    }

    public function in(int ...$args): self
    {
        $this->rules[] = $this->ruleWithParameters(__FUNCTION__, ...$args);

        return $this;
    }

    public function notIn(int ...$args): self
    {
        $this->rules[] = $this->ruleWithParameters(__FUNCTION__, ...$args);

        return $this;
    }
}
