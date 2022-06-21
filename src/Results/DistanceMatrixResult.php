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

        $this->distanceMatrixObjects = collect($resultData['rows'])
            ->map(fn(array $row) => collect($row)
                ->map(
                    fn(array $elements) => collect($elements)
                        ->map(fn($element) => new DistanceMatrixObject(
                            $element['distance'],
                            $element['duration'],
                            $element['status']
                        ))
                )
            );

        $this->result = collect([
            'distanceMatrixObjects' => $this->getDistanceMatrixObjects(),
            'destinationAddresses' => $this->getDestinationAddresses(),
            'originAddresses' => $this->getOriginAddresses()
        ]);
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
