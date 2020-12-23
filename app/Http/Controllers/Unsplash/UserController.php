<?php


namespace App\Http\Controllers\Unsplash;


use App\Http\Controllers\Controller;
use App\Models\UnsplashUser;
use App\Unsplash\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;


/**
 * Class UserController
 * @package App\Http\Controllers
 *
 * @author Fabian Schilf <fabian.schilf@active-value.de>
 * @copyright 2020 active value GmbH
 */
class UserController extends Controller
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

    /**
     * request an unsplash API um follower zu bekommen und anzuzeigen
     *
     * @param UnsplashUser $unsplashUser
     * @param Request $request
     * @return Application|Factory|View
     * @throws GuzzleException
     */
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
