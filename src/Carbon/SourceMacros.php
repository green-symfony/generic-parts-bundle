<?php

namespace GS\GenericParts\Carbon;

use GS\GenericParts\Service\{
    GSCarbonService
};

class SourceMacros
{
    /*
        DateTime in User locale and timezone

        Usage:
            $carbonForUser          = Carbon::forUser(tz: <>, locale: <>);
            $carbonForUser          = Carbon::forUser($sourceData);
            $carbonForUser          = $carbon->forUser($sourceData);
    */
    public static function forUser()
    {
        return static function (
            \DateTime|\DateTimeImmutable $sourceOfMeta = null,
            string $tz = null,
            string $locale = null,
        ): \DateTime|\DateTimeImmutable {
            return GSCarbonService::forUser(
                origin:             self::this(),
                sourceOfMeta:       $sourceOfMeta,
                tz:                 $tz,
                locale:             $locale,
            );
        };
    }
}
