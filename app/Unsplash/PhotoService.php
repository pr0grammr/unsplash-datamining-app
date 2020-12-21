<?php


namespace App\Unsplash;


use App\Models\UnsplashPhoto;
use App\Models\UnsplashUser;
use Unsplash\Photo;


/**
 * Class PhotoService
 * @package App\Unsplash
 *
 * @author Fabian Schilf <fabian.schilf@active-value.de>
 * @copyright 2020 active value GmbH
 */
class PhotoService
{
    /**
     * @var Client
     */
    private $unsplashClient;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @param Client $unsplashClient
     * @param UserService $userService
     */
    public function __construct(Client $unsplashClient, UserService $userService)
    {
        $this->unsplashClient = $unsplashClient;
        $this->userService = $userService;
    }

    /**
     * @param Photo $photo
     * @return mixed
     */
    public function create(Photo $photo)
    {
        $data = $this->prepare($photo);

        $unsplashPhoto = new UnsplashPhoto($data);
        $unsplashPhoto->user()->associate($data['user']);
        $unsplashPhoto->save();

        return $unsplashPhoto;
    }

    /**
     * @param Photo $photo
     * @param UnsplashPhoto $unsplashPhoto
     * @return UnsplashPhoto
     */
    public function update(Photo $photo, UnsplashPhoto $unsplashPhoto)
    {
        $data = $this->prepare($photo);

        $unsplashPhoto->fill($data);
        $unsplashPhoto->save();

        return $unsplashPhoto;
    }

    /**
     * @param Photo $photo
     * @return array
     */
    private function prepare(Photo $photo)
    {
        $data = $photo->toArray();

        $data['photo_id'] = $data['id'];

        $username = $data['user']['username'];

        if ($unsplashUser = UnsplashUser::where('username', $username)->first()) {
            $data['user'] = $unsplashUser;
        } else {
            $user = $this->unsplashClient->findUserByUsername($username);
            $unsplashUser = $this->userService->create($user);

            // überschreiben des detection mode, da der user in dem fall automatisch angelegt wird
            $unsplashUser->detection_mode = UnsplashUser::DETECTION_MODE_AUTO;
            $unsplashUser->save();
            $data['user'] = $unsplashUser;
        }

        return $data;
    }
}
