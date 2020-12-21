<?php

namespace App\Http\Controllers;

use App\Unsplash\DataAnalyzer;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * @var DataAnalyzer
     */
    private $analyzer;

    /**
     * @param DataAnalyzer $analyzer
     */
    public function __construct(DataAnalyzer $analyzer)
    {
        $this->analyzer = $analyzer;
    }

    public function show()
    {
        $data = [
            'user' => [
                'most_downloads' => $this->analyzer->getMostPopularUserByColumn('downloads'),
                'most_likes' => $this->analyzer->getMostPopularUserByColumn('total_likes'),
                'most_views' => $this->analyzer->getMostPopularUserByColumn('total_views')
            ],
            'photo' => [
                'most_views' => $this->analyzer->getMostPopularPhotoByColumn('views'),
                'most_likes' => $this->analyzer->getMostPopularPhotoByColumn('likes'),
                'most_downloads' => $this->analyzer->getMostPopularPhotoByColumn('downloads')
            ]
        ];

        return view('dashboard.index', $data);
    }
}
