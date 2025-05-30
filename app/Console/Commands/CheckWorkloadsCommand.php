<?php

namespace App\Console\Commands;

use App\Http\Controllers\WorkloadController;
use Illuminate\Console\Command;

class CheckWorkloadsCommand extends Command
{
    protected $signature = 'workloads:check';
    protected $description = 'Check professor workloads and send notifications for low workloads';

    public function handle(WorkloadController $controller)
    {
        $response = $controller->checkWorkloads();
        $result = json_decode($response->getContent(), true);

        $this->info("Notified {$result['notified_users']} professors about low workloads");

        if (!empty($result['errors'])) {
            $this->warn("Errors encountered:");
            foreach ($result['errors'] as $error) {
                $this->warn("- $error");
            }
        }

        return Command::SUCCESS;
    }
}
