<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnsplashRequest;
use App\Unsplash\InputResolver;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;


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
     * @param InputResolver $inputResolver
     */
    public function __construct(InputResolver $inputResolver)
    {
        $this->inputResolver = $inputResolver;
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

        $input = $this->inputResolver->resolveInput($data['input']);
        $type = $this->inputResolver->resolveType($input);

        if ($type == InputResolver::TYPE_IMAGE) {
            $a = 1;
        } else {
            $a = 1;
        }
    }
}
