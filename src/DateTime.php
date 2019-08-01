<?php

declare(strict_types=1);

namespace PhpCfdi\SatWsDescargaMasiva;


use DateTimeImmutable;
use InvalidArgumentException;

class DateTime
{
    /** @var DateTimeImmutable */
    private $value;

    public function __construct($value = null)
    {
        if (is_integer($value)) {
            $value = 'u' . $value;
        }
        if (null === $value || is_string($value)) {
            $value = new DateTimeImmutable($value ?? 'now');
        }
        if (! $value instanceof DateTimeImmutable) {
            throw new InvalidArgumentException('Unable to create a Datetime');
        }
        $this->value = $value;
    }

    public static function now(): self
    {
        return new self('now');
    }

    public function formatSat(): string
    {
        return $this->value->format('Y-m-d\TH:i:s.000\Z');
    }

    public function modify(string $modify): self
    {
        return new self($this->value->modify($modify));
    }

    public function compareTo(DateTime $otherDate): int
    {
        return $this->formatSat() <=> $otherDate->formatSat();
    }
}
