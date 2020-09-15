<?php
declare(strict_types = 1);

namespace NickSmit\LaravelRequestBuilder\Generator;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use NickSmit\LaravelRequestBuilder\Builder\Request;
use NickSmit\LaravelRequestBuilder\Writer\RequestWriter;
use PhpParser\Builder\Class_;
use PhpParser\Builder\Method;
use PhpParser\Builder\Property;
use PhpParser\BuilderFactory;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Name;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\NullableType;
use PhpParser\Node\Param;
use PhpParser\Node\Scalar\String_;
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
        $this->writeRequestClass($request);
        $this->writeRequestDataClass($request);
    }

    public function setWriter(RequestWriter $requestWriter): self
    {
        $this->requestWriter = $requestWriter;

        return $this;
    }

    protected function writeRequestClass(Request $request): void
    {
        $class = new Class_($this->getRequestClassName($request));
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

    protected function writeRequestDataClass(Request $request): void
    {
        $class = new Class_($this->getRequestClassName($request) . 'Data');

        $requestClass = new FullyQualified(
            app()->getNamespace() . 'Http\\Requests\\' . $this->getRequestClassName($request)
        );

        $requestProp = new Property('request');
        $requestProp->makePrivate();
        if (PHP_MAJOR_VERSION > 7 || PHP_MAJOR_VERSION === 7 && PHP_MINOR_VERSION >= 4) {
            $requestProp->setType($requestClass);
        }
        $class->addStmt($requestProp);

        $constructor = new Method('__construct');
        $constructor->makePublic();
        $requestVar = new Variable('request');
        $constructor->addParam(new Param($requestVar, null, $requestClass));
        $constructor->addStmt(new Assign(new PropertyFetch(new Variable('this'), 'request'), $requestVar));
        $class->addStmt($constructor);

        $getRequestMethod = new Method('getRequest');
        $getRequestMethod->makePublic();
        $getRequestMethod->addStmt(new Return_(new PropertyFetch(new Variable('this'), 'request')));
        $getRequestMethod->setReturnType($requestClass);
        $class->addStmt($getRequestMethod);

        // write getters for every field
        foreach ($request->getFields() as $field) {
            $getter = new Method('get' . ucfirst(Str::camel($field->getName())));
            $getter->makePublic();

            $returnType = $field->getReturnType();
            if (!$field->isRequired()) {
                $returnType = new NullableType($returnType);
            }

            $getter->setReturnType($returnType);

            $returnStmt = new Return_(
                $field->getCast(
                    new MethodCall(
                        new PropertyFetch(new Variable('this'), 'request'),
                        $field->getType()->requestGetter(),
                        [new Arg(new String_($field->getName()))]
                    )
                )
            );
            $getter->addStmt($returnStmt);
            $class->addStmt($getter);
        }

        $this->requestWriter->write($class);
    }

    /**
     * @param Request $request
     *
     * @return string
     */
    protected function getRequestClassName(Request $request): string
    {
        return ucfirst(Str::camel($request->getName()));
    }
}
