<?php
declare(strict_types = 1);

namespace NickSmit\LaravelRequestBuilder\Writer;

use PhpParser\Builder\Class_;
use PhpParser\BuilderFactory;
use PhpParser\PrettyPrinter\Standard as PrettyPrinter;

/**
 * Class ConsoleWriter
 */
final class ConsoleWriter implements RequestWriter
{
    /**
     * @var PrettyPrinter
     */
    private $printer;
    /**
     * @var BuilderFactory
     */
    private $builderFactory;

    /**
     * ConsoleWriter constructor.
     *
     * @param PrettyPrinter          $printer
     * @param BuilderFactory         $builderFactory
     */
    public function __construct(PrettyPrinter $printer, BuilderFactory $builderFactory)
    {
        $this->printer = $printer;
        $this->builderFactory = $builderFactory;
    }

    public function write(Class_ $class): void
    {
        echo $this->printer->prettyPrint(
            [
                $this->builderFactory->namespace(app()->getNamespace() . 'Http\\Requests')
                    ->addStmt($class)
                    ->getNode(),
            ]
        );

        echo "\n";
    }
}
