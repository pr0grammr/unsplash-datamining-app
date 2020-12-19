<?php


namespace App\Unsplash;


use App\Models\UnsplashPhoto;
use App\Models\UnsplashUser;


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
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        $data = $this->prepare($data);
        return UnsplashPhoto::create($data);
    }

    /**
     * @param array $data
     * @param UnsplashPhoto $unsplashPhoto
     * @return UnsplashPhoto
     */
    public function update(array $data, UnsplashPhoto $unsplashPhoto)
    {
        $data = $this->prepare($data);

        $unsplashPhoto->fill($data);
        $unsplashPhoto->save();

        return $unsplashPhoto;
    }

    /**
     * @param array $data
     * @return array
     */
    private function prepare(array $data)
    {
        $data['photo_id'] = $data['id'];

        $username = $data['user']['username'];

        if ($unsplashUser = UnsplashUser::where('username', $username)->first()) {
            $data['user_id'] = $unsplashUser->id;
        } else {
            $user = $this->unsplashClient->findUserByUsername($username);
            $unsplashUser = $this->userService->create($user->toArray());
            $data['user_id'] = $unsplashUser->id;
        }

        return $data;
    }
}
