<?php

use Illuminate\Http\Response;
use App\Services\Contracts\FlightServiceInterface;

class FlightControllerTest extends TestCase
{
    private $flightService;
    private const OUTBOUND = array('param' => '?outbound=1');
    private const INBOUND = array('param' => '?inbound=1');

    public function setUp(): void
    {
        parent::setUp();
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
        $endPoint = route('flights') . self::OUTBOUND['param'] ;
        
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
        $endPoint = route('flights') . self::INBOUND['param'] ;

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
