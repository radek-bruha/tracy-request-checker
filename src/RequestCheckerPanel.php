<?php declare(strict_types=1);

namespace Bruha\Tracy;

use Tracy\IBarPanel;

/**
 * Class RequestCheckerPanel
 *
 * @package Bruha\Tracy
 */
final class RequestCheckerPanel implements IBarPanel
{

    private const SUCCESS = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA8AAAAPCAMAAAAMCGV4AAAAflBMVEUAAAAAiAAAiAAAiAAAiAAAiAAAiAAAiAAAiAAAiAAAiAAAiAAAiAAAiAAAiAAAiAAAiAAAiAAAiAAAiAAAiAAAiAAAiAAAiAAAiAAAiAAAiAAAiAAAiAAAiAAAiAAAiAAAiAAAiAAAiAAAiAAAiAAAiAAAiAAAiAAAiAAAiAASFJtHAAAAKXRSTlMAAQMEBQ0QERMXLC8wMTQ1OkNHTk9SWV9hYmdwkZilvMjP2t7v8/n7/Y4B51wAAABmSURBVAgdbcEHEoIwAEXBpyhiV7A3sBDy739BQ0JmGMddvPRK37Te0zN46wZropmkDeWczklOUX+GBBcFC7xsqeBIa/RMS3mHMc5E0bnCSayiF62dohV/3OVZ2xizBR6mserk/PoCRMkPd/99Fe4AAAAASUVORK5CYII=';
    private const ERROR   = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA8AAAAPCAMAAAAMCGV4AAAAflBMVEUAAAD/AAD/AAD/AAD/AAD/AAD/AAD/AAD/AAD/AAD/AAD/AAD/AAD/AAD/AAD/AAD/AAD/AAD/AAD/AAD/AAD/AAD/AAD/AAD/AAD/AAD/AAD/AAD/AAD/AAD/AAD/AAD/AAD/AAD/AAD/AAD/AAD/AAD/AAD/AAD/AAD/AAD7v5q5AAAAKXRSTlMAAQMEBQ0QERMXLC8wMTQ1OkNHTk9SWV9hYmdwkZilvMjP2t7v8/n7/Y4B51wAAABmSURBVAgdbcEHEoIwAEXBpyhiV7A3sBDy739BQ0JmGMddvPRK37Te0zN46wZropmkDeWczklOUX+GBBcFC7xsqeBIa/RMS3mHMc5E0bnCSayiF62dohV/3OVZ2xizBR6mserk/PoCRMkPd/99Fe4AAAAASUVORK5CYII=';
    private const LABEL   = '<span title="Request Checker"><img src="%s" style="padding-left: 2px; margin-top: 5px;"><span class="tracy-label">%s ms (%s)</span></span>';

    /**
     * RequestCheckerPanel constructor
     *
     * @param int $threshold
     */
    public function __construct(private readonly int $threshold = 100)
    {
    }

    /**
     * @return string
     */
    public function getTab(): string
    {
        $requests = RequestLogger::getRequests();
        $hasError = array_filter($requests, static fn(Request $request): bool => $request->getStatus() >= 500);
        $duration = array_sum(array_map(static fn(Request $request): float => $request->getDuration(), $requests)) * 1_000;

        return sprintf(
            self::LABEL,
            $hasError || $duration >= ($this->threshold * count($requests)) ? self::ERROR : self::SUCCESS,
            self::number($duration, 1),
            count($requests)
        );
    }

    /**
     * @return string
     */
    public function getPanel(): string
    {
        ob_start();

        $requests = RequestLogger::getRequests();

        include __DIR__ . '/RequestCheckerPanel.phtml';

        return (string) ob_get_clean();
    }

    /**
     * @param float|int $number
     * @param int       $decimals
     *
     * @return string
     */
    public static function number(float|int $number, int $decimals = 0): string
    {
        return number_format($number, $decimals, '.', ' ');
    }

}
