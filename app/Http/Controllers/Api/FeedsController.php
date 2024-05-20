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

    public function getProducts(Request $request)
    {
        return $this->feedsRepository->getProducts($request);
    }

    public function getCategories(Request $request)
    {
        return $this->feedsRepository->getCategories($request);
    }
}
