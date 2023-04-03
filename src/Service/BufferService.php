<?php

namespace GS\GenericParts\Service;

use Endroid\QrCode\{
	Builder\Builder,
	Encoding\Encoding,
	ErrorCorrectionLevel\ErrorCorrectionLevelHigh,
	RoundBlockSizeMode\RoundBlockSizeModeMargin,
	Writer\PngWriter
};
use Symfony\Component\HttpFoundation\Response;

final class BufferService
{
	public function __construct(
	) {
	}
	
	public static function clear(): void 
	{
		while (\ob_get_level()) \ob_end_clean();
	}
}