<?php

namespace App\Interfaces\Api;

use Illuminate\Http\Request;

interface FeedsRepositoryInterface
{
    public function getFeeds(Request $request);
}
