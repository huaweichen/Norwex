<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use RuntimeException;

class CustomerResource extends JsonResource
{
    /**
     * @var array
     */
    public const VALID_COLORS = ['red', 'orange', 'green'];

    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        if (!in_array($this->resource->color, self::VALID_COLORS, true)) {
            throw new RuntimeException('Incorrect color.');
        }

        return [
            'customer_name' => $this->resource->name,
            'total_order_count' => $this->resource->count,
            'display_color' => $this->resource->color
        ];
    }
}
