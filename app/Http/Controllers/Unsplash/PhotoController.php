<?php

namespace App\Http\Controllers\Unsplash;

use App\Http\Controllers\Controller;
use App\Models\UnsplashPhoto;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;


/**
 * Class PhotoController
 * @package App\Http\Controllers
 *
 * @author Fabian Schilf <fabian.schilf@active-value.de>
 * @copyright 2020 active value GmbH
 */
class PhotoController extends Controller
{
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
