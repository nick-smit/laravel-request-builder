<?php
declare(strict_types = 1);

namespace NickSmit\LaravelRequestBuilder\Builder;

/**
 * Trait WithRules
 *
 * @package NickSmit\LaravelRequestBuilder\Builder
 */
trait WithRules
{
    public function required(): self
    {
        $this->rules[] = __FUNCTION__;

        return $this;
    }

    public function nullable(): self
    {
        $this->rules[] = __FUNCTION__;

        return $this;
    }

    /**
     * @param string $otherField
     * @param mixed  $value
     *
     * @return $this
     */
    public function requiredIf(string $otherField, $value): self
    {
        $this->rules[] = $this->ruleWithParameters(__FUNCTION__, $otherField, $value);

        return $this;
    }

    /**
     * @param string $rule
     * @param mixed  ...$args
     *
     * @return string
     */
    protected function ruleWithParameters(string $rule, ...$args)
    {
        return "$rule:" . implode(',', $args);
    }

    /**
     * @param string $otherField
     * @param mixed  $value
     *
     * @return $this
     */
    public function requiredUnless(string $otherField, $value): self
    {
        $this->rules[] = $this->ruleWithParameters(__FUNCTION__, $otherField, $value);

        return $this;
    }

    public function bail(): self
    {
        $this->rules[] = __FUNCTION__;

        return $this;
    }

    public function confirmed(): self
    {
        $this->rules[] = __FUNCTION__;

        return $this;
    }

    public function exists(string $table, string $column = null): self
    {
        $params = [$table];
        if ($column) {
            $params[] = $column;
        }

        $this->rules[] = $this->ruleWithParameters(__FUNCTION__, ...$params);

        return $this;
    }

    public function unique(string $table, string $column = null, string $except = null, string $idColumn = null): self
    {
        $params = [$table];
        if ($column) {
            $params[] = $column;
        }
        if ($except) {
            $params[] = $except;
        }
        if ($idColumn) {
            $params[] = $idColumn;
        }

        $this->rules[] = $this->ruleWithParameters(__FUNCTION__, ...$params);

        return $this;
    }

    public function same(string $otherField): self
    {
        $this->rules[] = $this->ruleWithParameters(__FUNCTION__, $otherField);

        return $this;
    }

    public function different(string $otherField): self
    {
        $this->rules[] = $this->ruleWithParameters(__FUNCTION__, $otherField);

        return $this;
    }

    public function size(int $size): self
    {
        $this->rules[] = $this->ruleWithParameters(__FUNCTION__, $size);

        return $this;
    }
}
