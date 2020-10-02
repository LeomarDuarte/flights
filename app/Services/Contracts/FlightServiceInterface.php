<?php

namespace App\Services\Contracts;

interface FlightServiceInterface
{
    public function getFlights();

    public function groupFlights(): void;

    public function groupFlightsOutbound(array $outFlight): array;

    public function getFlightsOutbound(): array;

    public function groupFlighsInbound(array $inFlight): array;

    public function getFlightsInbound(): array;

    public function generateUniqueGroupId(): int;

    public function getTotalPriceByGroup(array $group): string;

    public function getTotalGroups(): int;

    public function getTotalFlights(): int;

    public function getCheapestPriceGroup(): string;

    public function getCheapestGroupId(): int;

    public function convertStringNumberToCurrency(string $value): float;
}
