<?php

namespace App\Http\Controllers\Api;

use App\Dto\CreateDomainDto;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\DataForSeo\DomainHandler;
use App\Http\Resources\Domain\DomainCollection;
use App\Http\Requests\Domain\CreateDomainRequest;

class DomainsController extends Controller
{
    public function create(CreateDomainRequest $request, DomainHandler $handler): JsonResponse
    {
        $dto = new CreateDomainDto($request->validated());

        $domains = $handler->create($dto);

        return response()->json(new DomainCollection($domains));
    }
}
