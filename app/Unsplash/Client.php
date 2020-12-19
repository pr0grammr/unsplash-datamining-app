<?php


namespace App\Unsplash;


use Unsplash\HttpClient;
use Unsplash\Photo;
use Unsplash\User;


/**
 * Class Client
 * @package App\Unsplash
 *
 * Helper für den Unsplash API Client
 *
 * @author Fabian Schilf <fabian.schilf@active-value.de>
 * @copyright 2020 active value GmbH
 */
class Client
{
    /**
     * @var InputResolver
     */
    private $inputResolver;

    /**
     * unsplash API wird mit access key und secret key initialisiert
     *
     * @param InputResolver $inputResolver
     */
    public function __construct(InputResolver $inputResolver)
    {
        $this->inputResolver = $inputResolver;

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
        $username = $this->inputResolver->stripUsername($username);
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
