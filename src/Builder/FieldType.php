<?php
declare(strict_types = 1);

namespace NickSmit\LaravelRequestBuilder\Builder;

use MyCLabs\Enum\Enum;
use RuntimeException;

/**
 * Class FieldType
 * @method static ANY()
 * @method static INPUT()
 * @method static POST()
 * @method static QUERY()
 */
class FieldType extends Enum
{
    /** @var string */
    public const ANY = 'any';
    /** @var string */
    public const INPUT = 'input';
    /** @var string */
    public const POST = 'post';
    /** @var string */
    public const QUERY = 'query';

    public function requestGetter(): string
    {
        switch ($this->getValue()) {
            case static::ANY: return 'get';
            case static::INPUT: return 'input';
            case static::POST: return 'post';
            case static::QUERY: return 'query';
            default: throw new RuntimeException('Unknown getter for field type ' . $this->getValue());
        }
    }
}
