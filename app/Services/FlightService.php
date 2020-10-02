<?php

namespace App\Services;

use App\Services\Contracts\GuzzleClientInterface;
use App\Services\Contracts\FlightServiceInterface;

class FlightService implements FlightServiceInterface
{
    private $guzzleClient;
    private $endPoint;
    private $flights;
    private const INITIAL_PRICE = 0.0;

    public function __construct(GuzzleClientInterface $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
        $this->endPoint = env('API_URL_FLIGHTS');
        $this->flights['flights'] = $this->guzzleClient->makeRequest('get', $this->endPoint);
        $this->flights['groups']  = [];
    }

    public function getFlights(array $departureType = [])
    {
        try {
            switch (array_key_first($departureType)) {
                case 'outbound':
                    return $this->getFlightsOutbound();

                case 'inbound':
                    return $this->getFlightsInbound();

                default:
                    $this->groupFlights();
                break;
            }
            
            return $this->flights;
        } catch (\Throwable $th) {
            return ['erro' => 'Failed to retrieve '];
        }
    }

    public function groupFlights(): void
    {
        $newGroup = [];

        $outboundsFlights = $this->getFlightsOutbound();
        $inboundsFlights  = $this->getFlightsInbound();
    
        foreach ($outboundsFlights as $key => $outFlight) {
                
            $newGroup['uniqueId']   = $this->generateUniqueGroupId();
            $newGroup['totalPrice'] = self::INITIAL_PRICE;
            $newGroup['outbound']   = $this->groupFlightsOutbound($outFlight);
            
            if ($key < count($inboundsFlights)) {
                $newGroup['inbound']  = $this->groupFlighsInbound($inboundsFlights[$key]);
            }

            $newGroup['totalPrice'] = $this->getTotalPriceByGroup($newGroup);
            array_push($this->flights['groups'], $newGroup);
        }

        $this->flights['totalGroups']   = $this->getTotalGroups();
        $this->flights['totalFlights']  = $this->getTotalFlights();
        $this->flights['cheapestPrice'] = $this->getCheapestPriceGroup();
        $this->flights['cheapestGroup'] = $this->getCheapestGroupId();
    }
    
    public function groupFlightsOutbound(array $outFlight): array
    {
        $groupOutFlights = [];
        
        $outboundsFlights = $this->getFlightsOutbound($this->flights['flights']);
        foreach ($outboundsFlights as $flight) {
            if ($flight['fare'] == $outFlight['fare'] && $flight['price'] == $outFlight['price']) {
                array_push($groupOutFlights, [
                    'id' => $flight['id'],
                    'cia' => $flight['cia'],
                    'fare' => $flight['fare'],
                    'flightNumber' => $flight['flightNumber'],
                    'origin' => $flight['origin'],
                    'destination' => $flight['destination'],
                    'departureDate' => $flight['departureDate'],
                    'arrivalDate' => $flight['arrivalDate'],
                    'departureTime' => $flight['departureTime'],
                    'arrivalTime' => $flight['arrivalTime'],
                    'classService' => $flight['classService'],
                    'price' => $flight['price'],
                    'tax' => $flight['tax'],
                    'outbound' => $flight['outbound'],
                    'inbound' => $flight['inbound'],
                    'duration' => $flight['duration']
                ]);
            }
        }

        return $groupOutFlights;
    }

    public function getFlightsOutbound(): array
    {
        $outFlights = [];
        foreach ($this->flights['flights'] as $flight) {
            if ($flight->outbound) {
                array_push($outFlights, [
                    'id' => $flight->id,
                    'cia' => $flight->cia,
                    'fare' => $flight->fare,
                    'flightNumber' => $flight->flightNumber,
                    'origin' => $flight->origin,
                    'destination' => $flight->destination,
                    'departureDate' => $flight->departureDate,
                    'arrivalDate' => $flight->arrivalDate,
                    'departureTime' => $flight->departureTime,
                    'arrivalTime' => $flight->arrivalTime,
                    'classService' => $flight->classService,
                    'price' => $flight->price,
                    'tax' => $flight->tax,
                    'outbound' => $flight->outbound,
                    'inbound' => $flight->inbound,
                    'duration' => $flight->duration
                    ]
                );
            }
        }

        return $outFlights;
    }

    public function groupFlighsInbound(array $inFlight): array
    {
        $groupInFlights = [];
        
        $inboundsFlights = $this->getFlightsInbound($this->flights['flights']);
        foreach ($inboundsFlights as $flight) {
            if ($flight['fare'] == $inFlight['fare'] && $flight['price'] == $inFlight['price']) {
                array_push($groupInFlights, [
                    'id' => $flight['id'],
                    'cia' => $flight['cia'],
                    'fare' => $flight['fare'],
                    'flightNumber' => $flight['flightNumber'],
                    'origin' => $flight['origin'],
                    'destination' => $flight['destination'],
                    'departureDate' => $flight['departureDate'],
                    'arrivalDate' => $flight['arrivalDate'],
                    'departureTime' => $flight['departureTime'],
                    'arrivalTime' => $flight['arrivalTime'],
                    'classService' => $flight['classService'],
                    'price' => $flight['price'],
                    'tax' => $flight['tax'],
                    'outbound' => $flight['outbound'],
                    'inbound' => $flight['inbound'],
                    'duration' => $flight['duration']
                ]);
            }
        }

        return $groupInFlights;
    }

    public function getFlightsInbound(): array
    {
        $inFlights = [];
        foreach ($this->flights['flights'] as $flight) {
            if ($flight->inbound) {
                array_push($inFlights, [
                    'id' => $flight->id,
                    'cia' => $flight->cia,
                    'fare' => $flight->fare,
                    'flightNumber' => $flight->flightNumber,
                    'origin' => $flight->origin,
                    'destination' => $flight->destination,
                    'departureDate' => $flight->departureDate,
                    'arrivalDate' => $flight->arrivalDate,
                    'departureTime' => $flight->departureTime,
                    'arrivalTime' => $flight->arrivalTime,
                    'classService' => $flight->classService,
                    'price' => $flight->price,
                    'tax' => $flight->tax,
                    'outbound' => $flight->outbound,
                    'inbound' => $flight->inbound,
                    'duration' => $flight->duration
                    ]
                );
            }
        }

        return $inFlights;
    }

    public function generateUniqueGroupId(): int
    {
        return count($this->flights['groups']) + 1;
    }

    public function getTotalPriceByGroup(array $group): string
    {
        $indice = array_key_first($group['outbound']);
        $totalPrice  = $group['outbound'][$indice]['price'] + $group['inbound'][$indice]['price'];

        return \NumberFormatter::create('pt_BR',\NumberFormatter::CURRENCY)->format($totalPrice);
    }

    public function getTotalGroups(): int
    {
        return count($this->flights['groups']);
    }

    public function getTotalFlights(): int
    {
        return count($this->flights['flights']);
    }

    public function getCheapestPriceGroup(): string
    {   
        $cheapestPrices = [];
        foreach ($this->flights['groups'] as $group) {
            array_push($cheapestPrices, $this->convertStringNumberToCurrency($group['totalPrice']));
        }

        $lowestPrice = min($cheapestPrices);
        return \NumberFormatter::create('pt_BR',\NumberFormatter::CURRENCY)->format($lowestPrice);
    }

    public function getCheapestGroupId(): int
    {
        $indice = array_rand($this->flights['groups']);
        $lowestPrice = $this->convertStringNumberToCurrency($this->flights['groups'][$indice]['totalPrice']);
        $uniqueIdCheapestGroup = $this->flights['groups'][$indice]['uniqueId'];

        foreach ($this->flights['groups'] as $key => $group) {
            if ($lowestPrice > $this->convertStringNumberToCurrency($group['totalPrice'])) {
                $lowestPrice = $this->convertStringNumberToCurrency($group['totalPrice']);
                $uniqueIdCheapestGroup = $group['uniqueId'];
            }
        }
        
        return $uniqueIdCheapestGroup;
    }

    public function convertStringNumberToCurrency(string $value): float
    {
        $numberFormatter = new \NumberFormatter( 'pt_BR', \NumberFormatter::CURRENCY );
        return $numberFormatter->parseCurrency($value, $curr); 
    }
}
