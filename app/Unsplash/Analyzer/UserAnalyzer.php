<?php


namespace App\Unsplash\Analyzer;


use App\Models\UnsplashUser;
use App\Unsplash\Client;
use App\Unsplash\InputResolver;
use App\Unsplash\Service\UserService;


/**
 * Class UserAnalyzer
 * @package App\Unsplash
 *
 * @author Fabian Schilf <fabian.schilf@active-value.de>
 * @copyright 2020 active value GmbH
 */
class UserAnalyzer
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
     * @var InputResolver
     */
    private $inputResolver;

    /**
     * @param Client $unsplashClient
     * @param UserService $userService
     */
    public function __construct(Client $unsplashClient, UserService $userService, InputResolver $inputResolver)
    {
        $this->unsplashClient = $unsplashClient;
        $this->userService = $userService;
        $this->inputResolver = $inputResolver;
    }

    /**
     * analysiert einen user:
     * erstellt einen neuen nutzer, sollte noch keiner existieren
     * andernfalls wird er geupdated
     *
     * @param string $username
     * @return UnsplashUser
     */
    public function analyze(string $username)
    {
        $username = $this->inputResolver->stripUsername($username);
        $user = $this->unsplashClient->findUserByUsername($username);

        if ($unsplashUser = UnsplashUser::where('username', $username)->first()) {
            return $this->userService->update($user, $unsplashUser);
        } else {
            return $this->userService->create($user);
        }
    }
}
