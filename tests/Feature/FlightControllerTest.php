<?php

use Illuminate\Http\Response;
use Laravel\Lumen\Testing\WithoutMiddleware;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Services\Contracts\FlightServiceInterface;

class FlightControllerTest extends TestCase
{
    private $flightService;
    private const OUTBOUND = 1;
    private const INBOUND = 1;

    public function setUp(): void
    {
        parent::setUp();
        $this->flightService = $this->app->make('App\Services\Contracts\FlightServiceInterface');
    }

	/** @test */
    public function should_return_all_flights()
    {
        $endPoint = route('flights');

        $this->get($endPoint, []);

        $this->seeStatusCode(Response::HTTP_OK);
        $this->seeJsonStructure([
            'flights' => [
                '*' => [
                    'id',
                    'cia',
                    'fare',
                    'flightNumber',
                    'origin',
                    'destination',
                    'departureDate',
                    'arrivalDate',
                    'departureTime',
                    'arrivalTime',
                    'classService',
                    'price',
                    'tax',
                    'outbound',
                    'inbound',
                    'duration'
                ]
            ]    
        ]);
    }

    /** @test */
    public function should_return_all_flights_outbound()
    {
        $endPoint = route('flights.outbound') . self::OUTBOUND;
        
        $this->get($endPoint, []);
        
        $this->seeStatusCode(Response::HTTP_OK);        
        $this->seeJsonStructure([
            '*' => [
                'id',
                'cia',
                'fare',
                'flightNumber',
                'origin',
                'destination',
                'departureDate',
                'arrivalDate',
                'departureTime',
                'arrivalTime',
                'classService',
                'price',
                'tax',
                'outbound',
                'inbound',
                'duration'
            ]
        ]);
    }

    /** @test */
    public function should_return_all_flights_inbound()
    {
        $endPoint = route('flights.inbound') . self::INBOUND;

        $this->get($endPoint, []);

        $this->seeStatusCode(Response::HTTP_OK);
        $this->seeJsonStructure([
            '*' => [
                'id',
                'cia',
                'fare',
                'flightNumber',
                'origin',
                'destination',
                'departureDate',
                'arrivalDate',
                'departureTime',
                'arrivalTime',
                'classService',
                'price',
                'tax',
                'outbound',
                'inbound',
                'duration'
            ]
        ]);
        
    }
}
