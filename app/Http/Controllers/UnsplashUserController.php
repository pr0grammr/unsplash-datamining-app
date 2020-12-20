<?php


namespace App\Http\Controllers;


use App\Models\UnsplashUser;
use App\Unsplash\Client;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;


/**
 * Class UnsplashUserController
 * @package App\Http\Controllers
 *
 * @author Fabian Schilf <fabian.schilf@active-value.de>
 * @copyright 2020 active value GmbH
 */
class UnsplashUserController extends Controller
{
    /**
     * @var Client
     */
    private $unsplashClient;

    /**
     * @param Client $unsplashClient
     */
    public function __construct(Client $unsplashClient)
    {
        $this->unsplashClient = $unsplashClient;
    }

    /**
     * zeigt die detailseite eines users
     *
     * @param UnsplashUser $unsplashUser
     * @return Application|Factory|View
     */
    public function show(UnsplashUser $unsplashUser)
    {
        return view('unsplash.user-detail', [
            'user' => $unsplashUser
        ]);
    }

    public function showFollowers(UnsplashUser $unsplashUser, Request $request)
    {
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 10);

        $response = $this->unsplashClient->getFollowersOfUser($unsplashUser->username, $page, $limit);

        return view('unsplash.user-detail-followers', [
            'user' => $unsplashUser,
            'followers' => $response['data'],
            'pagination' => $response['pagination']
        ]);
    }
}
