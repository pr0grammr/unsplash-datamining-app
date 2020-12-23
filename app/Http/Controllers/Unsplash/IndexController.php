<?php

namespace App\Http\Controllers\Unsplash;

use App\Http\Controllers\Controller;
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
class IndexController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function show()
    {
        return view('unsplash.index', ['error' => '']);
    }
}
