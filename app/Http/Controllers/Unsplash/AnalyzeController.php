<?php

namespace App\Http\Controllers\Unsplash;

use App\Http\Controllers\Controller;
use App\Http\Requests\UnsplashRequest;
use App\Unsplash\Analyzer\PhotoAnalyzer;
use App\Unsplash\Analyzer\UserAnalyzer;
use App\Unsplash\InputResolver;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Unsplash\Exception;


/**
 * Class UnsplashController
 * @package App\Http\Controllers
 *
 * @author Fabian Schilf <fabian.schilf@active-value.de>
 * @copyright 2020 active value GmbH
 */
class AnalyzeController extends Controller
{
    /**
     * @var PhotoAnalyzer
     */
    private $photoAnalyzer;

    /**
     * @var UserAnalyzer
     */
    private $userAnalyzer;

    /**
     * @var InputResolver
     */
    private $inputResolver;

    /**
     * @param PhotoAnalyzer $photoAnalyzer
     * @param UserAnalyzer $userAnalyzer
     * @param InputResolver $inputResolver
     */
    public function __construct(PhotoAnalyzer $photoAnalyzer, UserAnalyzer $userAnalyzer, InputResolver $inputResolver)
    {
        $this->photoAnalyzer = $photoAnalyzer;
        $this->userAnalyzer = $userAnalyzer;
        $this->inputResolver = $inputResolver;
    }

    /**
     * nimmt den input entgegen (username oder URL; foto ID oder URL)
     * prüft ob es sich bei der eingabe um einen user oder ein foto handelt
     * analysiert user oder foto
     *
     * @param UnsplashRequest $request
     * @return Application|Factory|View|RedirectResponse
     */
    public function analyzeInput(UnsplashRequest $request)
    {
        $data = $request->validated();

        $input = $this->inputResolver->resolveInput($data['unsplash-input']);
        $type = $this->inputResolver->resolveType($input);

        try {
            if ($type == InputResolver::TYPE_PHOTO) {
                $unsplashPhoto = $this->photoAnalyzer->analyze($input);
                return redirect()->route('unsplash-photo-detail', $unsplashPhoto);
            } else {
                $unsplashUser = $this->userAnalyzer->analyze($input);
                return redirect()->route('unsplash-user-detail', $unsplashUser);
            }
        } catch (Exception $exception) {
            $message = json_decode($exception->getMessage())[0];
            return view('unsplash.index', [
                'error' => $message
            ]);
        }
    }
}
