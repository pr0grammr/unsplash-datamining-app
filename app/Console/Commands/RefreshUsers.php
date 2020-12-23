<?php


namespace App\Console\Commands;


use App\Models\UnsplashUser;
use App\Unsplash\Client;
use App\Unsplash\Service\UserService;
use Illuminate\Console\Command;


/**
 * Class RefreshUsers
 * @package App\Console\Commands
 *
 * @author Fabian Schilf <fabian.schilf@active-value.de>
 * @copyright 2020 active value GmbH
 */
class RefreshUsers extends Command
{
    /**
     * @var Client
     */
    private $unsplashClient;

    /**
     * @var UserService
     */
    private $userService;

    protected $signature = 'refresh:users';

    protected $description = 'Refreshing all users in the database';

    /**
     * @param Client $unsplashClient
     * @param UserService $userService
     */
    public function __construct(Client $unsplashClient, UserService $userService)
    {
        $this->unsplashClient = $unsplashClient;
        $this->userService = $userService;

        parent::__construct();
    }

    public function handle()
    {
        $this->withProgressBar(UnsplashUser::all(), function(UnsplashUser $unsplashUser) {
            $this->refreshUser($unsplashUser);
        });
    }

    /**
     * führt einen erneuten API request durch ud erneuert den datensatz
     *
     * @param UnsplashUser $unsplashUser
     * @return UnsplashUser
     */
    private function refreshUser(UnsplashUser $unsplashUser)
    {
        $user = $this->unsplashClient->findUserByUsername($unsplashUser->username);
        return $this->userService->update($user, $unsplashUser);
    }
}
