<?php


namespace Tests\Unit;


use App\Models\UnsplashUser;
use App\Unsplash\Client;
use App\Unsplash\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
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

    const TEST_USERNAME = 'yeapea';

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
        $user = $this->unsplashClient->findUserByUsername(self::TEST_USERNAME);
        $unsplashUser = $this->userService->create($user);

        $this->assertEquals(self::TEST_USERNAME, $unsplashUser->username);
        $this->assertInstanceOf(UnsplashUser::class, $unsplashUser);

        // find user
        $unsplashUser = UnsplashUser::where('username', self::TEST_USERNAME)->first();
        $this->assertNotNull($unsplashUser);
    }

    /**
     * test update user
     */
    public function testUpdateUser()
    {
        $user = $this->unsplashClient->findUserByUsername(self::TEST_USERNAME);
        $unsplashUser = UnsplashUser::where('username', self::TEST_USERNAME)->first();

        $this->assertNotNull($unsplashUser);

        $unsplashUser = $this->userService->update($user, $unsplashUser);

        $this->assertEquals(self::TEST_USERNAME, $unsplashUser->username);
        $this->assertNotNull($unsplashUser);
        $this->assertEquals(UnsplashUser::DETECTION_MODE_MANUAL, $unsplashUser->detection_mode);
    }

    /**
     * test check if detection mode == 'manual'
     */
    public function testUserDetectionMode()
    {
        $user = $this->unsplashClient->findUserByUsername(self::TEST_USERNAME);
        $unsplashUser = $this->userService->create($user);

        $this->assertEquals(UnsplashUser::DETECTION_MODE_MANUAL, $unsplashUser->detection_mode);
    }
}
