<?php


namespace App\Unsplash;


/**
 * Class InputResolver
 * @package App\Unsplash
 *
 * @author Fabian Schilf <fabian.schilf@active-value.de>
 * @copyright 2020 active value GmbH
 */
class InputResolver
{
    const TYPE_USER = 1;
    const TYPE_PHOTO = 2;

    /**
     * regex pattern to check various combinations of unsplash.com URL
     *
     * checking user URL username:
     * https://unsplash.com/@{username}
     * https://www.unsplash.com/@{username}
     * unsplash.com/@{username}
     * www.unsplash.com/@{username}
     *
     * checking photo URL or ID:
     * https://unsplash.com/photos/{photoID}
     * https://www.unsplash.com/photos/{photoID}
     * unsplash.com/photos/{photoID}
     * www.unsplash.com/photos/{photoID}
     *
     * @param string $input
     * @return string
     */
    public function resolveInput(string $input)
    {
        return preg_replace('/([https:\/\/]*[www\.]*[unsplash\.com]*\/*[photos]*\/)*/', '', $input);
    }

    /**
     * checks if $input is a username or a photo ID
     * if $input starts with @, $input is a username, else it is a photo ID
     *
     * @param string $input
     * @return int
     */
    public function resolveType(string $input)
    {
        return $input[0] == '@' ? self::TYPE_USER : self::TYPE_PHOTO;
    }

    /**
     * @param string $username
     * @return false|string
     */
    public function stripUsername(string $username)
    {
        if ($username[0] == '@') {
            return substr($username, 1);
        }

        return $username;
    }
}
