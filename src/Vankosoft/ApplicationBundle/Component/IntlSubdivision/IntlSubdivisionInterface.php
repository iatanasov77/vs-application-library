<?php namespace Vankosoft\ApplicationBundle\Component\IntlSubdivision;

interface IntlSubdivisionInterface
{
    public static function getStatesAndProvincesForCountry( string $countryCode ): array;

    public static function getStatesAndProvinces(): array;
}
