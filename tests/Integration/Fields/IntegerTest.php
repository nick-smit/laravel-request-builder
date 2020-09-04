<?php
declare(strict_types = 1);

namespace NickSmit\LaravelRequestBuilder\Tests\Integration\Fields;

use NickSmit\LaravelRequestBuilder\Builder\Request;
use NickSmit\LaravelRequestBuilder\Generator\RequestGenerator;
use NickSmit\LaravelRequestBuilder\Writer\TestWriter;
use PhpParser\BuilderFactory;
use PhpParser\PrettyPrinter\Standard;
use PHPUnit\Framework\TestCase;
use Spatie\Snapshots\MatchesSnapshots;

/**
 * Class IntegerTest
 */
final class IntegerTest extends TestCase
{
    use MatchesSnapshots;

    /**
     * @var TestWriter
     */
    private $testWriter;
    /**
     * @var RequestGenerator
     */
    private $requestGenerator;

    protected function setUp(): void
    {
        $this->testWriter = new TestWriter(new Standard(), new BuilderFactory());
        $this->requestGenerator = new RequestGenerator(
            new BuilderFactory(),
            $this->testWriter
        );
    }

    public function test_integer(): void
    {
        $request = new Request(__FUNCTION__);
        $request->integer('integer');

        $this->requestGenerator->generate($request);

        $actual = $this->testWriter->getContent();
        $this->assertMatchesTextSnapshot($actual);
    }

    public function test_required_integer(): void
    {
        $request = new Request(__FUNCTION__);
        $request->integer('integer')->required();

        $this->requestGenerator->generate($request);

        $actual = $this->testWriter->getContent();
        $this->assertMatchesTextSnapshot($actual);
    }

    public function test_required_if_integer(): void
    {
        $request = new Request(__FUNCTION__);
        $request->integer('integer')->requiredIf('other', 1);

        $this->requestGenerator->generate($request);

        $actual = $this->testWriter->getContent();
        $this->assertMatchesTextSnapshot($actual);
    }
}
