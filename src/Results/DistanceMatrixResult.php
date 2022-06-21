<?php
declare(strict_types=1);

namespace KielD01\LaravelGoogleApi\Results;

use Illuminate\Support\Collection;
use KielD01\LaravelGoogleApi\Objects\Address;
use KielD01\LaravelGoogleApi\Objects\DistanceMatrixObject;
use KielD01\LaravelGoogleApi\Result;

/**
 * @property Address[] $destinationAddresses
 * @property Address[] $originAddresses
 * @property
 */
class DistanceMatrixResult extends Result
{
    private Collection $destinationAddresses;
    private Collection $originAddresses;
    private Collection $distanceMatrixObjects;

    protected function processResult()
    {
        $resultData = $this->getRawResult();

        $this->destinationAddresses = collect($resultData['destination_addresses'])
            ->map(fn(string $destinationAddress) => new Address($destinationAddress));

        $this->originAddresses = collect($resultData['origin_addresses'])
            ->map(fn(string $destinationAddress) => new Address($destinationAddress));

        $this->distanceMatrixObjects = $this->makeDistanceMatrixObjects($resultData['rows']);

        $this->result = collect([
            'distanceMatrixObjects' => $this->getDistanceMatrixObjects(),
            'destinationAddresses' => $this->getDestinationAddresses(),
            'originAddresses' => $this->getOriginAddresses()
        ]);
    }

    private function makeDistanceMatrixObjects(array $rows = []): Collection
    {
        $items = collect();

        collect($rows)
            ->each(function (array $row) use (&$items) {
                collect($row['elements'])
                    ->each(function (array $element) use (&$items) {
                        $items->push(
                            new DistanceMatrixObject(
                                $element['distance'],
                                $element['duration'],
                                $element['status']
                            )
                        );
                    });
            });

        return $items;
    }

    public function getDestinationAddresses(): Collection
    {
        return $this->destinationAddresses;
    }

    public function getOriginAddresses(): Collection
    {
        return $this->originAddresses;
    }

    public function getDistanceMatrixObjects(): Collection
    {
        return $this->distanceMatrixObjects;
    }
}
