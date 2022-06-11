<?php declare(strict_types=1);

namespace Bruha\Tracy;

/**
 * Class Request
 *
 * @package Bruha\Tracy
 */
final class Request
{

    /**
     * Request constructor
     *
     * @param string $url
     * @param int    $status
     * @param float  $duration
     */
    public function __construct(
        private readonly string $url,
        private readonly int $status,
        private readonly float $duration
    ) {
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @return float
     */
    public function getDuration(): float
    {
        return $this->duration;
    }
}
