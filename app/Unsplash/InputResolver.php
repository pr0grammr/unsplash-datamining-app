<?php


namespace App\Unsplash;


class InputResolver
{
    const REGEX_PATTERN = '/([https:\/\/]*[www\.]*[unsplash\.com]*\/*[photos]*\/)*/';

    const TYPE_USER = 1;
    const TYPE_IMAGE = 2;

    public function stripInput(string $input)
    {
        return preg_replace(self::REGEX_PATTERN, '', $input);
    }

    public function resolveType(string $input)
    {
        return $input[0] == '@' ? self::TYPE_USER : self::TYPE_IMAGE;
    }
}
