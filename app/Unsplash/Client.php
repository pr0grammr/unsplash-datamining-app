<?php


namespace App\Unsplash;


use Unsplash\HttpClient;
use Unsplash\Photo;
use Unsplash\User;


/**
 * Class Client
 * @package App\Unsplash
 *
 * @author Fabian Schilf <fabian.schilf@active-value.de>
 * @copyright 2020 active value GmbH
 */
class Client
{
    /**
     * unsplash API wird mit access key und secret key initialisiert
     */
    public function __construct()
    {
        $config = config()->get('services')['unsplash'];
        HttpClient::init([
            'applicationId' => $config['access_key'],
            'secret' => $config['secret_key'],
            'utmSource' => $config['application_name']
        ]);
    }

    /**
     * @param string $username
     * @return User
     */
    public function findUserByUsername(string $username)
    {
        // wenn $username mit @ startet, dann wird das erste zeichen entfernt
        // andernfalls liefert die unsplash API keine ergebnisse
        if ($username[0] == '@') {
            $username = substr($username, 1);
        }

        return User::find($username);
    }

    /**
     * @param string $photoId
     * @return Photo
     */
    public function findPhotoById(string $photoId)
    {
        return Photo::find($photoId);
    }
}
