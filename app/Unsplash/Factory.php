<?php


namespace App\Unsplash;


use App\Models\UnsplashUser;

class Factory
{
    private $unsplashClient;
    public function createUserInstance(string $user)
    {
        $user = UnsplashUser::create();
    }

    public function createImageInstance(string $imageId)
    {
    }
}
