<?php
declare(strict_types = 1);

namespace NickSmit\LaravelRequestBuilder\Builder;

/**
 * Interface TypeInterface
 */
interface FieldInterface
{
    public function getName(): string;

    public function getRules(): array;
}
