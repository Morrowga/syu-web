<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\Api\FeedsRepositoryInterface;

class FeedsController extends Controller
{
    private FeedsRepositoryInterface $feedsRepository;

    public function __construct(FeedsRepositoryInterface $feedsRepository)
    {
        $this->feedsRepository = $feedsRepository;
    }

    public function getFeeds(Request $request)
    {
        return $this->feedsRepository->getFeeds($request);
    }

}
