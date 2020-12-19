<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnsplashRequest;
use App\Models\UnsplashPhoto;
use App\Models\UnsplashUser;
use App\Unsplash\Client;
use App\Unsplash\InputResolver;
use App\Unsplash\PhotoService;
use App\Unsplash\UserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;


/**
 * Class UnsplashController
 * @package App\Http\Controllers
 *
 * @author Fabian Schilf <fabian.schilf@active-value.de>
 * @copyright 2020 active value GmbH
 */
class UnsplashController extends Controller
{
    /**
     * @var InputResolver
     */
    private $inputResolver;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var PhotoService
     */
    private $photoService;

    /**
     * @var Client
     */
    private $unsplashClient;

    /**
     * @param InputResolver $inputResolver
     * @param UserService $userService
     * @param PhotoService $photoService
     * @param Client $unsplashClient
     */
    public function __construct(InputResolver $inputResolver, UserService $userService, PhotoService $photoService, Client $unsplashClient)
    {
        $this->inputResolver = $inputResolver;
        $this->userService = $userService;
        $this->photoService = $photoService;
        $this->unsplashClient = $unsplashClient;
    }

    /**
     * @return Application|Factory|View
     */
    public function show()
    {
        return view('unsplash.index');
    }

    /**
     * nimmt den input entgegen (username oder URL; foto ID oder URL)
     * prüft ob es sich bei der eingabe um einen user oder ein foto handelt
     * analysiert user oder foto
     *
     * @param UnsplashRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function analyzeInput(UnsplashRequest $request)
    {
        $data = $request->validated();

        $input = $this->inputResolver->resolveInput($data['unsplash-input']);
        $type = $this->inputResolver->resolveType($input);

        if ($type == InputResolver::TYPE_PHOTO) {
            $unsplashPhoto = $this->analyzePhoto($input);
            return redirect()->route('unsplash-photo-detail', $unsplashPhoto);
        } else {
            $unsplashUser = $this->analyzeUser($input);
            return redirect()->route('unsplash-user-detail', $unsplashUser);
        }
    }

    /**
     * analysiert einen user:
     * erstellt einen neuen nutzer, sollte noch keiner existieren
     * andernfalls wird er geupdated
     *
     * @param string $username
     * @return UnsplashUser
     */
    private function analyzeUser(string $username)
    {
        $user = $this->unsplashClient->findUserByUsername($username);
        $username = $this->inputResolver->stripUsername($username);

        if ($unsplashUser = UnsplashUser::where('username', $username)->first()) {
            return $this->userService->update($user->toArray(), $unsplashUser);
        } else {
            return $this->userService->create($user->toArray());
        }
    }

    /**
     * analysiert ein foto:
     * erstellt ein neues foto, sollte noch keins existieren
     * andernfalls wird es geupdated
     *
     * @param string $photoId
     * @return UnsplashPhoto|mixed
     */
    private function analyzePhoto(string $photoId)
    {
        $photo = $this->unsplashClient->findPhotoById($photoId);

        if ($unsplashPhoto = UnsplashPhoto::where('photo_id', $photoId)->first()) {
            return $this->photoService->update($photo->toArray(), $unsplashPhoto);
        } else {
            return $this->photoService->create($photo->toArray());
        }
    }

    /**
     * zeigt die detailseite eines users
     *
     * @param UnsplashUser $unsplashUser
     * @return Application|Factory|View
     */
    public function showUserDetail(UnsplashUser $unsplashUser)
    {
        return view('unsplash.user-detail', [
            'user' => $unsplashUser
        ]);
    }

    /**
     * zeigt die detail seite eines fotos
     *
     * @param UnsplashPhoto $unsplashPhoto
     * @return Application|Factory|View
     */
    public function showPhotoDetail(UnsplashPhoto $unsplashPhoto)
    {
        return view('unsplash.photo-detail', [
            'photo' => $unsplashPhoto
        ]);
    }
}
