<?php
declare(strict_types = 1);

namespace NickSmit\LaravelRequestBuilder\Writer;

use Illuminate\Contracts\Config\Repository;
use PhpParser\Builder\Class_;
use PhpParser\BuilderFactory;
use PhpParser\Node\Scalar\LNumber;
use PhpParser\Node\Stmt\Declare_;
use PhpParser\Node\Stmt\DeclareDeclare;
use PhpParser\PrettyPrinter\Standard as PrettyPrinter;

/**
 * Class FileWriter
 */
final class FileWriter implements RequestWriter
{
    /**
     * @var Repository
     */
    private $config;
    /**
     * @var PrettyPrinter
     */
    private $printer;
    /**
     * @var BuilderFactory
     */
    private $builderFactory;

    /**
     * FileWriter constructor.
     *
     * @param Repository     $config
     * @param PrettyPrinter  $printer
     * @param BuilderFactory $builderFactory
     */
    public function __construct(Repository $config, PrettyPrinter $printer, BuilderFactory $builderFactory)
    {
        $this->config = $config;
        $this->printer = $printer;
        $this->builderFactory = $builderFactory;
    }

    public function write(Class_ $class): void
    {
        $outputDir = $this->config->get('laravel-request-builder.request-output-directory');

        if (!is_dir($outputDir)) {
            mkdir($outputDir);
        }

        $handle = fopen($outputDir . '/' . $class->getNode()->name . '.php', 'w+');
        fwrite($handle, "<?php\n");
        fwrite(
            $handle,
            $this->printer->prettyPrint(
                [
                    new Declare_([new DeclareDeclare('strict_types', new LNumber(1))]),
                    $this->builderFactory->namespace(app()->getNamespace() . 'Http\\Requests')
                        ->addStmt($class)
                        ->getNode(),
                ]
            )
        );
        fclose($handle);
    }
}
