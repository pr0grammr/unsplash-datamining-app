<?php


namespace App\Unsplash\Analyzer;


use App\Models\UnsplashPhoto;
use App\Unsplash\Client;
use App\Unsplash\Service\PhotoService;


/**
 * Class PhotoAnalyzer
 * @package App\Unsplash
 *
 * @author Fabian Schilf <fabian.schilf@active-value.de>
 * @copyright 2020 active value GmbH
 */
class PhotoAnalyzer
{
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
    }

    /**
     * analysiert ein foto:
     * erstellt ein neues foto, sollte noch keins existieren
     * andernfalls wird es geupdated
     *
     * @param string $photoId
     * @return UnsplashPhoto|mixed
     */
    public function analyze(string $photoId)
    {
        $photo = $this->unsplashClient->findPhotoById($photoId);

        if ($unsplashPhoto = UnsplashPhoto::where('photo_id', $photoId)->first()) {
            return $this->photoService->update($photo, $unsplashPhoto);
        } else {
            return $this->photoService->create($photo);
        }
    }
}
