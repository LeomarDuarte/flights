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

    public function index(): \Illuminate\Http\JsonResponse
    {
        try {
            return response()->json($this->flightService->getFlights(), Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['erro' => 'Failed to retrieve flights!'], Response::HTTP_INTERNAL_SERVER_ERRO);
        }
    }

    public function getFlightsOutbound($outbound): \Illuminate\Http\JsonResponse
    {
        try {
            return response()->json($this->flightService->getFlightsOutbound(), Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['erro' => 'Failed to retrieve flights outbounds!'], Response::HTTP_INTERNAL_SERVER_ERRO);
        }
    }

    public function getFlightsInbound($inbound): \Illuminate\Http\JsonResponse
    {
        try {
            return response()->json($this->flightService->getFlightsInbound(), Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['erro' => 'Failed to retrieve flights inbounds!'], Response::HTTP_INTERNAL_SERVER_ERRO);
        }
    }
}
