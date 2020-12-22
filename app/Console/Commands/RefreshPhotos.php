<?php


namespace App\Console\Commands;


use App\Models\UnsplashPhoto;
use App\Unsplash\Client;
use App\Unsplash\PhotoService;
use Illuminate\Console\Command;


/**
 * Class RefreshPhotos
 * @package App\Console\Commands
 *
 * @author Fabian Schilf <fabian.schilf@active-value.de>
 * @copyright 2020 active value GmbH
 */
class RefreshPhotos extends Command
{
    protected $signature = 'refresh:photos';

    protected $description = 'Refreshing all photos in the database';

    /**
     * @var Client
     */
    private $unsplashClient;

    /**
     * @var PhotoService
     */
    private $photoService;

    /**
     * @param Client $unsplashClient
     * @param PhotoService $photoService
     */
    public function __construct(Client $unsplashClient, PhotoService $photoService)
    {
        $this->unsplashClient = $unsplashClient;
        $this->photoService = $photoService;

        parent::__construct();
    }

    public function handle()
    {
        $this->withProgressBar(UnsplashPhoto::all(), function(UnsplashPhoto $unsplashPhoto) {
            $this->refreshPhoto($unsplashPhoto);
        });
    }

    /**
     * führt einen erneuten API request durch ud erneuert den datensatz
     *
     * @param UnsplashPhoto $unsplashPhoto
     * @return UnsplashPhoto
     */
    private function refreshPhoto(UnsplashPhoto $unsplashPhoto)
    {
        $photo = $this->unsplashClient->findPhotoById($unsplashPhoto->photo_id);
        return $this->photoService->update($photo, $unsplashPhoto);
    }
}
