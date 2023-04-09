<?php

namespace GS\GenericParts\IsoFormat;

use GS\GenericParts\Contracts\GSIsoFormat;

class GSLLLIsoFormat implements GSIsoFormat
{
    public static function get(): string
    {
        return 'dddd, MMMM D, YYYY h:mm:ss A';
    }
}
