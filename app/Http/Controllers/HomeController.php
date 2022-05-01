<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Services\DataService;
use Illuminate\Http\JsonResponse;

class HomeController extends Controller
{
    /***
     * Budget Homes API
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function budget(Request $request): JsonResponse
    {
        if (
            ! $request->has('minPrice') || ! $request->has('maxPrice')
            || $request->get('minPrice') >= $request->get('maxPrice')
        ) {
            return response()->json(["error" => "Please specify the minPRice,maxPrices parameters"], 400);
        }

        try {
            $data = (new DataService())->getHomesByPrice($request->get('minPrice'), $request->get('maxPrice'));
        } catch (Exception $ex) {
            return response()->json(["error" => "Internal error"], 500);
        }

        return response()->json($data, 200);
    }

    /**
     * Sqft Homes API
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sqft(Request $request): JsonResponse
    {
        if (! $request->has('minSqft')) {
            return response()->json(["error" => "Please specify minSqft parameter"], 400);
        }

        try {
            $data = (new DataService())->getHomesBySqft($request->get('minSqft'));
        } catch (Exception $ex) {
            return response()->json(["error" => "Internal error"], 500);
        }

        return response()->json($data);
    }

    /**
     * Age Homes API
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function age(Request $request): JsonResponse
    {
        if (! $request->has('year')) {
            return response()->json(["error" => "Please specify year parameter"], 400);
        }

        try {
            $data = (new DataService())->getHomesByYear($request->get('year'));
        } catch (Exception $ex) {
            return response()->json(["error" => "Internal error"], 500);
        }

        return response()->json($data);
    }

    /**
     * Standard Price Homes API
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function standardPrice(Request $request): JsonResponse
    {
        try {
            $data = (new DataService())->getHomesWithStandardizedPrices();
        } catch (Exception $ex) {
            return response()->json(["error" => "Internal error"], 500);
        }

        return response()->json($data);
    }
}
