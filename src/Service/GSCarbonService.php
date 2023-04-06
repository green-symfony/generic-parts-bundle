<?php

namespace GS\GenericParts\Service;

use Carbon\Carbon;

class GSCarbonService
{
	public static function forUser(
		Carbon $origin,
		\DateTime $sourceOfMeta = null,
		string $tz = null,
		string $locale = null,
	): Carbon {
		$cloneOrigin			= $origin->clone();
		return $sourceOfMeta ?
			$cloneOrigin->tz($sourceOfMeta->tz)->locale($sourceOfMeta->locale) :
			$cloneOrigin->tz($tz ?? $cloneOrigin->tz)->locale($locale ?? $cloneOrigin->locale)
		;
	}
}