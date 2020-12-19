<?php


namespace App\Unsplash;


use App\Models\UnsplashUser;
use Unsplash\HttpClient;
use Unsplash\User;


/**
 * Class UserService
 * @package App\Unsplash
 *
 * dieser service kümmert sich um das erstellen und updaten eines App\Models\UnsplashUser models
 *
 * @author Fabian Schilf <fabian.schilf@active-value.de>
 * @copyright 2020 active value GmbH
 */
class UserService
{
    /**
     * @param array $data
     * @return UnsplashUser
     */
    public function create(array $data)
    {
        return $this->prepare($data, new UnsplashUser());
    }

    /**
     * @param array $data
     * @param UnsplashUser $unsplashUser
     * @return UnsplashUser
     */
    public function update(array $data, UnsplashUser $unsplashUser)
    {
        return $this->prepare($data, $unsplashUser);
    }

    /**
     * @param array $data
     * @param UnsplashUser $unsplashUser
     * @return UnsplashUser
     */
    private function prepare(array $data, UnsplashUser $unsplashUser)
    {
        $unsplashUser->username = $data['username'];
        $unsplashUser->name = $data['name'];
        $unsplashUser->first_name = $data['first_name'];
        $unsplashUser->last_name = $data['last_name'];
        $unsplashUser->profile_image_url = $data['profile_image']['medium'];
        $unsplashUser->twitter_username = $data['twitter_username'];
        $unsplashUser->instagram_username = $data['instagram_username'];
        $unsplashUser->bio = $data['bio'];
        $unsplashUser->location = $data['location'];
        $unsplashUser->total_collections = $data['total_collections'];
        $unsplashUser->total_likes = $data['total_likes'];
        $unsplashUser->total_photos = $data['total_photos'];
        $unsplashUser->following_count = $data['following_count'];
        $unsplashUser->followers_count = $data['followers_count'];
        $unsplashUser->downloads = $data['downloads'];

        $unsplashUser->save();

        return $unsplashUser;
    }
}
