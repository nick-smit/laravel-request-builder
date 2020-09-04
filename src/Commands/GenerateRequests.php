<?php
declare(strict_types = 1);

namespace NickSmit\LaravelRequestBuilder\Commands;

use Illuminate\Console\Command;
use Iterator;
use NickSmit\LaravelRequestBuilder\Builder\Request;
use NickSmit\LaravelRequestBuilder\Generator\RequestGenerator;
use NickSmit\LaravelRequestBuilder\Writer\ConsoleWriter;
use RuntimeException;
use SplFileInfo;
use Symfony\Component\Finder\Finder;

/**
 * Class GenerateRequests
 */
class GenerateRequests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'request-builder:generate {--write-to-console}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates request classes';

    /**
     * Execute the console command.
     *
     * @param RequestGenerator $generator
     *
     * @return int
     */
    public function handle(RequestGenerator $generator): int
    {
        if ($this->option('write-to-console')) {
            $generator->setWriter(app()->make(ConsoleWriter::class));
        }

        $path = config('laravel-request-builder.request-input-directory');

        foreach ($this->getRequests($path) as $request) {
            $this->info('Processing request: ' . $request->getName());

            $generator->generate($request);
        }

        return 0;
    }

    /**
     * @param string $fromPath
     * @param bool   $recursive
     *
     * @return Iterator|Request[]
     */
    protected function getRequests(string $fromPath, bool $recursive = true): Iterator
    {
        /** @var SplFileInfo $spl */
        foreach (Finder::create()->depth(0)->ignoreDotFiles(true)->in($fromPath) as $spl) {
            if ($spl->isDir() && $recursive) {
                yield from $this->getRequests($spl->getPathname(), true);

                continue;
            }

            yield $this->loadRequest($spl->getPathname());
        }
    }

    /**
     * @param string $pathname
     *
     * @return Request
     */
    protected function loadRequest(string $pathname)
    {
        $request = require $pathname;

        if (!$request instanceof Request) {
            throw new RuntimeException('All request config files must return a request instance!');
        }

        return $request;
    }
}
