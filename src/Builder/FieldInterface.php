<?php
declare(strict_types = 1);

namespace NickSmit\LaravelRequestBuilder\Builder;

use PhpParser\Node\Expr;

/**
 * Interface TypeInterface
 */
interface FieldInterface
{
    public function getName(): string;

    public function getType(): FieldType;

    public function getRules(): array;

    public function getReturnType(): string;

    public function isRequired(): bool;

    public function getCast(Expr\MethodCall $methodCall): Expr;
}
