<?php

namespace App\Http\Resources\Domain;

use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DomainCollection extends ResourceCollection
{
	/**
	 * @return array
	 */
    public function toArray($request): array
    {
        return [
            'data' => $this->collection,
            'message' => Redis::get('message'),
			'type' => Redis::get('status'),
        ];
    }
}
