<?php

namespace App\Services\DataForSeo;

use stdClass;
use Exception;
use App\Models\Domain;
use App\Models\Status;
use App\Enums\DomainStatus;
use Illuminate\Support\Arr;
use App\Dto\CreateDomainDto;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Client\RequestException;
use App\Exceptions\DataForSeo\{
    DomainCreateException,
    CheckStatusCodeException
};

class DomainHandler
{
    /**
     * @var \App\Services\DataForSeo\HttpClient
     */
    private HttpClient $client;

    /**
     * @var int
     */
    private const SUCCESS_STATUS_CODE = 20000;

    /**
     * @param \App\Services\DataForSeo\HttpClient $client
     */
    public function __construct(HttpClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param \App\Dto\CreateDomainDto $dto
     *
     * @return \Illuminate\Support\Collection
     * @throws \App\Exceptions\DataForSeo\DomainCreateException
     * @throws \App\Exceptions\DataForSeo\CheckStatusCodeException
    */
    public function create(CreateDomainDto $dto): Collection
    {
        $action = '/v3/backlinks/domain_intersection/live';
        $createdDomains = collect([]);

        try {
            $response = $this->client->request('POST', $action, $this->getPayload($dto));
            // $response = json_decode(file_get_contents(storage_path('app.json')));

            $this->checkResponseStatusCode($response);

            $intersectionData = $this->getIntersectionsData($response);

            foreach ($dto->getTargetDomains() as $index => $targetDomain) {

                /**
                 * Get top intersection.
                 *
                 * @var stdClass
                 */
                $intersectionItem = Arr::get($intersectionData, "0.0.{$index}");

                $domain = Domain::create([
                    'excluded_target' => $dto->getExcludedTargets(),
                    'target_domain' => $targetDomain,

                    'referring_domain' => $intersectionItem->referring_domain ?? 0,
                    'rank' => $intersectionItem->rank ?? 0,
                    'backlinks' => $intersectionItem->backlinks ?? 0,
                ]);

                $domain->intersections()->createMany(
                    $this->getIntersectionsByIndex($intersectionData, $index)
                );

                $domain->load('intersections');

                $createdDomains->push($domain);
            }

            // \Log::info([$createdDomains->toArray()]);

            return $createdDomains;
        } catch (RequestException $exception) {
            throw new DomainCreateException($exception->getMessage());
        } catch (Exception $exception) {
            throw new DomainCreateException($exception->getMessage());
        }

        return $createdDomains;
    }

    /**
     * @param stdClass $response
     *
     * @return void
     * @throws \App\Exceptions\DataForSeo\CheckStatusCodeException
     */
    private function checkResponseStatusCode(stdClass $response): void
    {
        foreach ($response->tasks as $taskIndex => $task) {
            if (self::SUCCESS_STATUS_CODE === $task->status_code) {
                Redis::set('status', 'success');
                Redis::set('message', 'ok');

                return;
            }

            $status = Status::findByCode($task->status_code);

            Redis::set('status', 'error');
            Redis::set('message', $status->message);

            throw new CheckStatusCodeException($status->message);

            return;
        }

        Redis::set('status', 'success');
        Redis::set('message', 'ok');

        return;
    }

    /**
     * @param \App\Dto\CreateDomainDto $dto
     *
     * @return array
    */
    private function getPayload(CreateDomainDto $dto): array
    {
        $data[] = [
            'targets' => $dto->getTargetDomains(),
            'exclude_targets' => $dto->getExcludedTargets(),
            'limit' => 10,
            'include_subdomains' => false,
            'exclude_internal_backlinks' => true,
            'order_by' => [
                '1.rank,desc'
            ],
        ];

        return [
            'json' => $data
        ];
    }

    /**
     * @param \stdClass $response
     *
     * @return array
     */
    public function getIntersectionsData(stdClass $response): array
    {
        $intersectionData = [];

        foreach ($response->tasks as $taskIndex => $task) {
            if (null === $task->result) {
                continue;
            }

            foreach ($task->result as $result) {
                foreach ($result->items as $index => $item) {
                    foreach ($item->domain_intersection as $intersectionIndex => $intersection) {

                        $intersectionData[$taskIndex][$index][$intersectionIndex] = (object) [
                            'referring_domain' => $intersection->target ?? null,
                            'rank' => $intersection->rank ?? 0,
                            'backlinks' => $intersection->backlinks ?? 0,
                        ];
                    }
                }
            }
        }

        return $intersectionData;
    }

    /**
     * @param array $intersectionsData
     * @param int $index
     *
     * @return array
     */
    private function getIntersectionsByIndex(array $intersectionsData, int $index): array
    {
        if (!$intersections = array_shift($intersectionsData)) {
            return [];
        }

        $data = [];

        foreach ($intersections as $intersection) {
            if (!empty($intersection[$index])) {
                $data[] = (array) $intersection[$index] ?? [];
            }
        }

        return array_filter($data);
    }
}
