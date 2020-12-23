<?php


namespace App\Unsplash\Analyzer;


use App\Models\UnsplashPhoto;
use App\Models\UnsplashUser;


/**
 * Class DashboardAnalyzer
 * @package App\Unsplash
 *
 * klasse zur berechnung von statistiken auf dem dashboard
 *
 * @author Fabian Schilf <fabian.schilf@active-value.de>
 * @copyright 2020 active value GmbH
 */
class DashboardAnalyzer
{
    /**
     * liefert das foto, mit dem höchsten wert von $columnName
     *
     * @param string $columnName
     * @return mixed
     */
    public function getMostPopularPhotoByColumn(string $columnName)
    {
        return UnsplashPhoto::all()->sortBy($columnName, SORT_REGULAR, true)->first();
    }

    /**
     * liefert den user, mit dem höchsten wert von $columnName
     *
     * @param string $columnName
     * @return mixed
     */
    public function getMostPopularUserByColumn(string $columnName)
    {
        return UnsplashUser::all()->sortBy($columnName, SORT_REGULAR, true)->first();
    }
}
