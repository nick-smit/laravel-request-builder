<?php
declare(strict_types = 1);

namespace NickSmit\LaravelRequestBuilder\Writer;

use PhpParser\Builder\Class_;
use PhpParser\BuilderFactory;
use PhpParser\PrettyPrinter\Standard as PrettyPrinter;

/**
 * Class TestWriter
 */
final class TestWriter implements RequestWriter
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
     * @var false|resource
     */
    private $handle;

    /**
     * TestWriter constructor.
     *
     * @param PrettyPrinter  $printer
     * @param BuilderFactory $builderFactory
     */
    public function __construct(PrettyPrinter $printer, BuilderFactory $builderFactory)
    {
        $this->printer = $printer;
        $this->builderFactory = $builderFactory;

        $this->handle = fopen('php://memory', 'w+');
    }

    /**
     *
     */
    public function __destruct()
    {
        fclose($this->handle);
    }

    public function write(Class_ $class): void
    {
        fwrite(
            $this->handle,
            $this->printer->prettyPrint(
                [
                    $this->builderFactory->namespace('Tests\\Http\\Requests')
                        ->addStmt($class)
                        ->getNode(),
                ]
            )
        );
    }

    public function getContent(): string
    {
        $content = '';
        rewind($this->handle);
        while (!feof($this->handle)) {
            $content .= fgets($this->handle);
        }

        return $content;
    }
}
