<?php


namespace App\Twitter;


/**
 * Class Client
 * @package App\Twitter
 *
 * @author Fabian Schilf <fabian.schilf@active-value.de>
 * @copyright 2020 active value GmbH
 */
class Client
{
    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     * @param \GuzzleHttp\Client $client
     */
    public function __construct(\GuzzleHttp\Client $client)
    {
        $this->client = $client;
    }

    /**
     * stellt eine Anfrage an die twitter API um den gewünschten user zu bekommen
     * überprüft den statuscode und gibt null zurück, sollte der code != 200 sein
     *
     * liefert bei erfolg ein array mit follower_count, following_count und tweet_count zurück
     *
     * @param string $username
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getUserByUsername(string $username)
    {
        $response = $this->client->get(sprintf('/2/users/by/username/%s?user.fields=public_metrics', $username));
        if ($response->getStatusCode() != 200) {
            return null;
        }

        $contents = $response->getBody()->getContents();
        $json = json_decode($contents, true);
        $data = $json['data'] ?? null;
        if (!$data) {
            return null;
        }

        $stats = $data['public_metrics'];

        return [
            'username' => $data['username'],
            'followers_count' => $stats['followers_count'],
            'following_count' => $stats['following_count'],
            'tweet_count' => $stats['tweet_count']
        ];
    }
}
