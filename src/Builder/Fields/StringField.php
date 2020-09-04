<?php
declare(strict_types = 1);

namespace NickSmit\LaravelRequestBuilder\Builder\Fields;

use Illuminate\Support\Str;
use NickSmit\LaravelRequestBuilder\Builder\FieldInterface;
use NickSmit\LaravelRequestBuilder\Builder\WithRules;

/**
 * Class StringField
 */
final class StringField implements FieldInterface
{
    use WithRules;

    /**
     * @var string
     */
    private $name;
    /**
     * @var array
     */
    private $rules = ['string'];

    /**
     * StringField constructor.
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

    public function in(string ...$args): self
    {
        $this->rules[] = $this->ruleWithParameters(__FUNCTION__, ...$args);

        return $this;
    }

    public function notIn(string ...$args): self
    {
        $this->rules[] = $this->ruleWithParameters(__FUNCTION__, ...$args);

        return $this;
    }

    public function regex(string $regex): self
    {
        $this->rules[] = $this->ruleWithParameters(__FUNCTION__, $regex);

        return $this;
    }

    public function notRegex(string $regex): self
    {
        $this->rules[] = $this->ruleWithParameters(__FUNCTION__, $regex);

        return $this;
    }

    public function alpha(): self
    {
        $this->rules[] = __FUNCTION__;

        return $this;
    }

    public function alphaDash(): self
    {
        $this->rules[] = Str::snake(__FUNCTION__);

        return $this;
    }

    public function alphaNum(): self
    {
        $this->rules[] = Str::snake(__FUNCTION__);

        return $this;
    }

    public function email(array $args = ['filter']): self
    {
        $this->rules[] = $this->ruleWithParameters('email', ...$args);

        return $this;
    }

    public function endsWith(string ...$args): self
    {
        $this->rules[] = $this->ruleWithParameters(Str::snake(__FUNCTION__), ...$args);

        return $this;
    }

    public function startsWith(string ...$args): self
    {
        $this->rules[] = $this->ruleWithParameters(Str::snake(__FUNCTION__), ...$args);

        return $this;
    }

    public function ip(): self
    {
        $this->rules[] = __FUNCTION__;

        return $this;
    }

    public function ipv4(): self
    {
        $this->rules[] = __FUNCTION__;

        return $this;
    }

    public function ipv6(): self
    {
        $this->rules[] = __FUNCTION__;

        return $this;
    }

    public function json(): self
    {
        $this->rules[] = __FUNCTION__;

        return $this;
    }

    public function timezone(): self
    {
        $this->rules[] = __FUNCTION__;

        return $this;
    }

    public function url(): self
    {
        $this->rules[] = __FUNCTION__;

        return $this;
    }

    public function uuid(): self
    {
        $this->rules[] = __FUNCTION__;

        return $this;
    }

    public function letters(): self
    {
        $this->rules[] = __FUNCTION__;

        return $this;
    }

    public function numbers(): self
    {
        $this->rules[] = __FUNCTION__;

        return $this;
    }

    public function caseDiff(): self
    {
        $this->rules[] = Str::snake(__FUNCTION__);

        return $this;
    }

    public function symbols(): self
    {
        $this->rules[] = __FUNCTION__;

        return $this;
    }
}
