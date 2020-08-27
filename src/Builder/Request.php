<?php
declare(strict_types = 1);

namespace NickSmit\LaravelRequestBuilder\Builder;

/**
 * Class RequestBuilder
 */
class Request
{
    /**
     * @var string
     */
    private $name;

    /**
     * Request constructor.
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
