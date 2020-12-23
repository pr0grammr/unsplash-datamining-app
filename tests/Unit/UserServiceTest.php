<?php


namespace Tests\Unit;


use App\Models\UnsplashUser;
use App\Unsplash\Client;
use App\Unsplash\UserService;
use Tests\TestCase;


/**
 * Class UserServiceTest
 * @package Tests\Unit
 *
 * @author Fabian Schilf <fabian.schilf@active-value.de>
 * @copyright 2020 active value GmbH
 */
class UserServiceTest extends TestCase
{
    /**
     * @var Client
     */
    private $unsplashClient;

    /**
     * @var UserService
     */
    private $userService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->unsplashClient = app(Client::class);
        $this->userService = app(UserService::class);
    }

    /**
     * test create user
     */
    public function testCreateUser()
    {
        $user = $this->unsplashClient->findUserByUsername('@yeapea');
        $unsplashUser = $this->userService->create($user);

        $this->assertEquals('yeapea', $unsplashUser->username);
        $this->assertInstanceOf(UnsplashUser::class, $unsplashUser);

        // find user
        $unsplashUser = UnsplashUser::where('username', 'yeapea')->first();
        $this->assertNotNull($unsplashUser);
    }

    /**
     * test create user and analyze twitter data
     */
    public function testCreateUserWithTwitterData()
    {
        $user = $this->unsplashClient->findUserByUsername('@chewy');
        $unsplashUser = $this->userService->create($user);

        $this->assertNotNull($unsplashUser->twitter);
        $this->assertEquals('Chewy', $unsplashUser->twitter['username']);
    }

    /**
     * test update user
     */
    public function testUpdateUser()
    {
        $user = $this->unsplashClient->findUserByUsername('@yeapea');
        $unsplashUser = UnsplashUser::where('username', 'yeapea')->first();

        $this->assertNotNull($unsplashUser);

        $unsplashUser = $this->userService->update($user, $unsplashUser);

        $this->assertEquals('yeapea', $unsplashUser->username);
        $this->assertNotNull($unsplashUser);
        $this->assertEquals(UnsplashUser::DETECTION_MODE_MANUAL, $unsplashUser->detection_mode);
    }

    /**
     * test check if detection mode == 'manual'
     */
    public function testUserDetectionMode()
    {
        $user = $this->unsplashClient->findUserByUsername('@yeapea');
        $unsplashUser = $this->userService->create($user);

        $this->assertEquals(UnsplashUser::DETECTION_MODE_MANUAL, $unsplashUser->detection_mode);
    }
}
