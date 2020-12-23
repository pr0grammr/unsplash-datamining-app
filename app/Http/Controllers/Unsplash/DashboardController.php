<?php

namespace App\Http\Controllers\Unsplash;

use App\Http\Controllers\Controller;
use App\Unsplash\Analyzer\DashboardAnalyzer;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;


/**
 * Class DashboardController
 * @package App\Http\Controllers\Unsplash
 *
 * @author Fabian Schilf <fabian.schilf@active-value.de>
 * @copyright 2020 active value GmbH
 */
class DashboardController extends Controller
{
    /**
     * @var DashboardAnalyzer
     */
    private $dashboardAnalyzer;

    /**
     * @param DashboardAnalyzer $dashboardAnalyzer
     */
    public function __construct(DashboardAnalyzer $dashboardAnalyzer)
    {
        $this->dashboardAnalyzer = $dashboardAnalyzer;
    }

    /**
     * @return Application|Factory|View
     */
    public function show()
    {
        $data = [
            'user' => [
                'most_downloads' => $this->dashboardAnalyzer->getMostPopularUserByColumn('downloads'),
                'most_likes' => $this->dashboardAnalyzer->getMostPopularUserByColumn('total_likes'),
                'most_views' => $this->dashboardAnalyzer->getMostPopularUserByColumn('total_views')
            ],
            'photo' => [
                'most_views' => $this->dashboardAnalyzer->getMostPopularPhotoByColumn('views'),
                'most_likes' => $this->dashboardAnalyzer->getMostPopularPhotoByColumn('likes'),
                'most_downloads' => $this->dashboardAnalyzer->getMostPopularPhotoByColumn('downloads')
            ]
        ];

        return view('dashboard.index', $data);
    }
}
