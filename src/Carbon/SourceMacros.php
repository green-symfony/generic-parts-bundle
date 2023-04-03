<?php

namespace GS\GenericParts\Carbon;

class SourceMacros
{
    /*
		DateTime in User locale and timezone
		
        Usage:
			$carbonForUser			= Carbon::forUser(tz: <>, locale: <>);
			$carbonForUser			= Carbon::forUser($sourceData);
			$carbonForUser			= $carbon->forUser($sourceData);
    */
    public static function forUser()
    {
        return static function (
            \DateTime $sourceOfMeta = null,
            string $tz = null,
            string $locale = null,
        ): \DateTime {
            $carbonClone = self::this()->clone();
            return $sourceOfMeta ?
                $carbonClone->tz($sourceOfMeta->tz)->locale($sourceOfMeta->locale) :
                $carbonClone->tz($tz ?? $carbonClone->tz)->locale($locale ?? $carbonClone->locale);
        };
    }
}
