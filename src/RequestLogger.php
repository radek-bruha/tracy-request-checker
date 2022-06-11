<?php declare(strict_types=1);

namespace Bruha\Tracy;

use CLosure;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\TransferStats;
use Psr\Http\Message\RequestInterface;

/**
 * Class HttpLogger
 *
 * @package Bruha\Tracy
 */
final class RequestLogger
{

    /**
     * @var Request[]
     */
    private static array $requests = [];

    /**
     * @return Request[]
     */
    public static function getRequests(): array
    {
        return self::$requests;
    }

    /**
     * @return CLosure
     */
    public static function requestLogger(): Closure
    {
        return static function (callable $handler): Closure {
            return static function (RequestInterface $request, array $options) use ($handler): PromiseInterface {
                $onStatsCallback = $options[RequestOptions::ON_STATS] ?? NULL;

                return $handler(
                    $request,
                    array_merge($options, [
                        RequestOptions::ON_STATS => static function (
                            TransferStats $transferStats,
                        ) use ($onStatsCallback): void {
                            if ($onStatsCallback) {
                                $onStatsCallback($transferStats);
                            }

                            $response = $transferStats->getResponse();

                            self::$requests[] = new Request(
                                (string) $transferStats->getRequest()->getUri(),
                                $response ? $response->getStatusCode() : 500,
                                $transferStats->getTransferTime() ?: 0,
                            );
                        },
                    ])
                );
            };
        };
    }
}
