<?php


namespace App\Unsplash;


use Unsplash\HttpClient;
use Unsplash\Photo;
use Unsplash\Search;
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

    /**
     * da der unsplash API PHP wrapper keine möglichkeit bietet,
     * die follower eines users zu bekommen, muss dies manuell per guzzleClient gemacht werden
     * hier wird ein request an den followers endpoint gestellt
     * danach wird eine pagination berechnet
     * zurückgegeben wird ein array mit einem 'data' key, der die follower enthält (je nach limit, standard: 10)
     * und einem 'pagination' key, der die pagination enthält
     *
     * @param string $username
     * @param int $page
     * @param int $limit
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getFollowersOfUser(string $username, int $page = 1, int $limit = 10)
    {
        $username = $this->inputResolver->stripUsername($username);

        $client = new \GuzzleHttp\Client();
        $config = config()->get('services')['unsplash'];
        $accessKey = $config['access_key'];

        $url = sprintf('https://api.unsplash.com/users/%s/followers?client_id=%s&page=%s&per_page=%s', $username, $accessKey, $page, $limit);

        $response = $client->get($url);

        $pagination = [
            'total' => intval($response->getHeader('X-Total')[0]),
            'per_page' => $limit,
            'current_page' => $page
        ];

        $pagination['total_pages'] = ceil($pagination['total'] / $limit);
        $pagination['next_page'] = $page < $pagination['total_pages'] ? $page + 1 : null;
        $pagination['previous_page'] = $page > 1 ? $page - 1 : null;

        if ($response->getStatusCode() != 200) {
            return [];
        }

        $content = $response->getBody()->getContents();
        $json = json_decode($content, true);

        return [
            'data' => $json,
            'pagination' => $pagination
        ];
    }
}
