<?php
declare(strict_types = 1);

namespace NickSmit\LaravelRequestBuilder\Generator;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use NickSmit\LaravelRequestBuilder\Builder\Request;
use NickSmit\LaravelRequestBuilder\Writer\RequestWriter;
use PhpParser\Builder\Class_;
use PhpParser\Builder\Method;
use PhpParser\BuilderFactory;
use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Name;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Stmt\Return_;

/**
 * Class RequestGenerator
 */
final class RequestGenerator
{
    /**
     * @var BuilderFactory
     */
    private $builderFactory;
    /**
     * @var RequestWriter
     */
    private $requestWriter;

    /**
     * RequestGenerator constructor.
     *
     * @param BuilderFactory $builderFactory
     * @param RequestWriter  $requestWriter
     */
    public function __construct(
        BuilderFactory $builderFactory,
        RequestWriter $requestWriter
    ) {
        $this->builderFactory = $builderFactory;
        $this->requestWriter = $requestWriter;
    }

    public function generate(Request $request): void
    {
        $class = new Class_(ucfirst(Str::camel($request->getName())));
        $class->extend(new FullyQualified(FormRequest::class));

        $authorizeMethod = new Method('authorize');
        $authorizeMethod->makePublic();
        $authorizeMethod->setReturnType(new Name('bool'));
        $authorizeMethod->addStmt(new Return_(new ConstFetch(new Name('true'))));
        $class->addStmt($authorizeMethod);

        $rulesMethod = new Method('rules');
        $rulesMethod->makePublic();
        $rulesMethod->setReturnType(new Name('array'));

        $rulesArray = [];
        foreach ($request->getFields() as $field) {
            $rulesArray[$field->getName()] = $field->getRules();
        }

        $rulesMethod->addStmt(new Return_($this->builderFactory->val($rulesArray)));
        $class->addStmt($rulesMethod);

        $this->requestWriter->write($class);
    }

    public function setWriter(RequestWriter $requestWriter): self
    {
        $this->requestWriter = $requestWriter;

        return $this;
    }
}
