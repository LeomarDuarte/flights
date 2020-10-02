<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Controllers\Controller;
use App\Services\Contracts\FlightServiceInterface;

class FlightController extends Controller
{
    private $fligthService;

    public function __construct(FlightServiceInterface $flightService)
    {
        $this->flightService = $flightService;
    }

    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            return response()->json($this->flightService->getFlights($request->all()), Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['erro' => 'Failed to retrieve flights!'], Response::HTTP_INTERNAL_SERVER_ERRO);
        }
    }
}
