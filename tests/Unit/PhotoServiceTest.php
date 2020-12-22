<?php


namespace Tests\Unit;


use App\Models\UnsplashPhoto;
use App\Models\UnsplashUser;
use App\Unsplash\Client;
use App\Unsplash\PhotoService;
use Tests\TestCase;


/**
 * Class PhotoServiceTest
 * @package Tests\Unit
 *
 * @author Fabian Schilf <fabian.schilf@active-value.de>
 * @copyright 2020 active value GmbH
 */
class PhotoServiceTest extends TestCase
{
    /**
     * @var Client
     */
    private $unsplashClient;

    /**
     * @var PhotoService
     */
    private $photoService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->unsplashClient = app(Client::class);
        $this->photoService = app(PhotoService::class);
    }

    /**
     * test create photo
     */
    public function testCreatePhoto()
    {
        $photo = $this->unsplashClient->findPhotoById('R4QnpCXWfpA');
        $unsplashPhoto = $this->photoService->create($photo);

        $this->assertNotNull($unsplashPhoto);
        $this->assertEquals('R4QnpCXWfpA', $unsplashPhoto->photo_id);
        $this->assertInstanceOf(UnsplashPhoto::class, $unsplashPhoto);
    }

    /**
     * test if user is automatically created during photo creation
     */
    public function testCreateRelatedUser()
    {
        $photo = $this->unsplashClient->findPhotoById('ScEXB6uxOVc');
        $unsplashPhoto = $this->photoService->create($photo);

        $this->assertNotNull($unsplashPhoto->user);
        $this->assertEquals('chewy', $unsplashPhoto->user->username);

        // test detection mode == 'auto' (only if user didnt exist before)
        $this->assertEquals(UnsplashUser::DETECTION_MODE_AUTO, $unsplashPhoto->user->detection_mode);
    }

    /**
     * test update photo
     */
    public function testUpdatePhoto()
    {
        $photo = $this->unsplashClient->findPhotoById('ScEXB6uxOVc');
        $unsplashPhoto = $this->photoService->create($photo);

        $this->assertNotNull($unsplashPhoto);

        // test if user detection mode is still 'auto'
        $this->assertEquals(UnsplashUser::DETECTION_MODE_AUTO, $unsplashPhoto->user->detection_mode);
    }
}
