<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnsplashRequest;
use App\Models\UnsplashUser;
use App\Unsplash\Client;
use App\Unsplash\InputResolver;
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
     * @var Client
     */
    private $unsplashClient;

    /**
     * @param InputResolver $inputResolver
     * @param UserService $userService
     * @param Client $unsplashClient
     */
    public function __construct(InputResolver $inputResolver, UserService $userService, Client $unsplashClient)
    {
        $this->inputResolver = $inputResolver;
        $this->userService = $userService;
        $this->unsplashClient = $unsplashClient;
    }

    /**
     * @return Application|Factory|View
     */
    public function show()
    {
        return view('unsplash.index');
    }

    public function analyzeInput(UnsplashRequest $request)
    {
        $data = $request->validated();

        $input = $this->inputResolver->resolveInput($data['unsplash-input']);
        $type = $this->inputResolver->resolveType($input);

        if ($type == InputResolver::TYPE_IMAGE) {

        } else {
            $unsplashUser = $this->analyzeUser($input);
            return redirect()->route('unsplash-user-detail', $unsplashUser);
        }
    }

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

    private function analyzePhoto(string $photoId)
    {

    }

    public function showUserDetail(UnsplashUser $unsplashUser)
    {
        return view('unsplash.user-detail', [
            'user' => $unsplashUser
        ]);
    }
}
