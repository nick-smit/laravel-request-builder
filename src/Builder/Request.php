<?php
declare(strict_types = 1);

namespace NickSmit\LaravelRequestBuilder\Builder;

use NickSmit\LaravelRequestBuilder\Builder\Fields\IntegerField;
use RuntimeException;

/**
 * Class RequestBuilder
 */
class Request
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var array|FieldInterface[]
     */
    private $fields = [];

    /**
     * Request constructor.
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array|FieldInterface[]
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @param string $name
     *
     * @return IntegerField|FieldInterface
     */
    public function integer(string $name): IntegerField
    {
        return $this->addField(new IntegerField($name));
    }

    public function addField(FieldInterface $field): FieldInterface
    {
        if (array_key_exists($field->getName(), $this->fields)) {
            throw new RuntimeException("Field {$field->getName()} already exists");
        }

        $this->fields[$field->getName()] = $field;

        return $field;
    }
}
