<?php

namespace App\Http\Controllers;

use App\Services\RecommendationsService;

class RecommendationsController extends Controller
{
    /**
     * @var RecommendationsService
     */
    private $recommendations;

    /**
     * RecommendationsController constructor.
     * @param RecommendationsService $recommendations
     */
    public function __construct(RecommendationsService $recommendations)
    {
        $this->recommendations = $recommendations;
    }

    public function index()
    {
        return $this->recommendations->loadForGuest();
    }
}
