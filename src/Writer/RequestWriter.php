<?php
declare(strict_types = 1);

namespace NickSmit\LaravelRequestBuilder\Writer;

use PhpParser\Builder\Class_;

/**
 * Interface RequestWriter
 */
interface RequestWriter
{
    public function write(Class_ $class): void;
}
