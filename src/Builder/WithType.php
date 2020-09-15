<?php
declare(strict_types = 1);

namespace NickSmit\LaravelRequestBuilder\Builder;

/**
 * Trait WithType
 *
 * @package NickSmit\LaravelRequestBuilder\Builder
 */
trait WithType
{
    /**
     * @var FieldType
     */
    protected $type;

    public function getType(): FieldType
    {
        return $this->type ?? FieldType::ANY();
    }

    public function post(): self
    {
        $this->type = FieldType::POST();

        return $this;
    }

    public function input(): self
    {
        $this->type = FieldType::INPUT();

        return $this;
    }

    public function query(): self
    {
        $this->type = FieldType::QUERY();

        return $this;
    }

    public function setType(FieldType $type): self
    {
        $this->type = $type;

        return $this;
    }
}
