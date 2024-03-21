<?php

namespace App\Console\Commands;

use Exception;
use App\Models\Status;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use App\Services\DataForSeo\HttpClient;

class ErrorsStatusesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appendix:errors';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load and store appendix list errors.';

    /**
     * @var \App\Services\DataForSeo\HttpClient
     */
    private HttpClient $client;

    /**
     * @var int
     */
    private const SUCCESS_STATUS = 20000;

    /**
     * Create a new ErrorsStatusesCommand instance.
     *
     * @param \App\Services\DataForSeo\HttpClient $client
     *
     * @return void
     */
    public function __construct(HttpClient $client)
    {
        $this->client = $client;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $response = $this->client->request('GET', 'v3/appendix/errors');

        if (self::SUCCESS_STATUS !== $response->status_code) {
            $this->warn("Error response from API");

            return 0;
        }

        /**
         * @var \Illuminate\Support\Collection $statuses
         */
        $statuses = collect();

        foreach ($response->tasks as $task) {
            foreach ($task->result as $status) {
                $statuses->push($status);
            }
        }

        $this->storeStatuses($statuses);

        return 1;
    }

    /**
     * Creating statuses into database.
     *
     * @param \Illuminate\Support\Collection $statuses
     *
     * @return void
     */
    private function storeStatuses(Collection $statuses): void
    {
        foreach ($statuses as $item) {
            try {
                if ($status = Status::findByCode($item->code)) {
                    $status->update([
                        'message' => $item->message
                    ]);

                    $this->info("Status: {$status->code} \"{$status->message}\" has been successfully updated");

                    continue;
                }

                
                $status = Status::create((array) $item);

                $this->info("Status: {$status->code} ({$status->message}) has been successfully created!");
            } catch (Exception $e) {
                $this->error("Error when creating/updating status code: {$item->code}");
                $this->error("    Message: "  . $e->getMessage() . PHP_EOL);
            }
        }
    }
}
