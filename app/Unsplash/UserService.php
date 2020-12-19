<?php


namespace App\Unsplash;


use App\Models\UnsplashUser;


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
        $data = $this->prepare($data);
        return UnsplashUser::create($data);
    }

    /**
     * @param array $data
     * @param UnsplashUser $unsplashUser
     * @return UnsplashUser
     */
    public function update(array $data, UnsplashUser $unsplashUser)
    {
        $data = $this->prepare($data);

        $unsplashUser->fill($data);
        $unsplashUser->save();

        return $unsplashUser;
    }

    /**
     * @param array $data
     * @return array
     */
    private function prepare(array $data)
    {
        $data['profile_image_url'] = $data['profile_image']['medium'];
        return $data;
    }
}
