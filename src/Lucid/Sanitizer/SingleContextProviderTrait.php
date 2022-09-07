<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Sanitizer;

use Closure;
use DecodeLabs\Lucid\Constraint\NotFoundException as ConstraintNotFoundException;
use DecodeLabs\Lucid\Sanitizer;
use DecodeLabs\Lucid\Validate\Result;
use Exception;

/**
 * @template TValue
 */
trait SingleContextProviderTrait
{
    public function as(
        string $type,
        array|Closure|null $setup = null
    ): mixed {
        return $this->sanitize()->as($type, $setup);
    }

    public function forceAs(
        string $type,
        array|Closure|null $setup = null
    ): mixed {
        return $this->sanitize()->forceAs($type, $setup);
    }

    public function validate(
        string $type,
        array|Closure|null $setup = null
    ): Result {
        return $this->sanitize()->validate($type, $setup);
    }

    public function is(
        string $type,
        array|Closure|null $setup = null
    ): bool {
        try {
            return $this->validate($type, $setup)->isValid();
        } catch (ConstraintNotFoundException $e) {
            throw $e;
        } catch (Exception $e) {
            return false;
        }
    }

    public function sanitize(): Sanitizer
    {
        return new Sanitizer($this->getValue());
    }

    /**
     * @phpstan-return TValue
     */
    abstract protected function getValue(): mixed;
}
