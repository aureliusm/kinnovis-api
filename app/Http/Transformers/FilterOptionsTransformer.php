<?php

namespace App\Http\Transformers;

use Illuminate\Database\Eloquent\Collection;

class FilterOptionsTransformer
{
    /**
     * Transform a collection into an array applicable for filters.
     *
     * @param  string  $valueField The field name for the value.
     * @param  string  $labelField The field name for the label.
     * @return array<int, mixed> The transformed array.
     *
     * @phpstan-ignore-next-line
     */
    public function transformCollection(Collection $collection, string $valueField, string $labelField): array
    {
        return $collection->map(function ($item) use ($valueField, $labelField) {
            return [
                'value' => $item->{$valueField},
                'label' => __($item->{$labelField}),
            ];
        })->toArray();
    }

    /**
     * Transform an array of enmus into an array applicable for filters.
     *
     * @param  array<int, string>  $array
     * @return array<int, mixed> The transformed array.
     */
    public function transformEnumArray(array $array): array
    {
        return collect($array)->map(function ($item) {
            return [
                'value' => $item,
                'label' => __($item),
            ];
        })->toArray();
    }
}
