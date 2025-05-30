<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Notifications\LowWorkloadNotification;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class DebugNotificationsCommand extends Command
{
    protected $signature = 'debug:notifications';
    protected $description = 'Debug notifications system';

    public function handle()
    {
        $this->info("Starting notification debugging...");

        // Check database connection
        try {
            DB::connection()->getPdo();
            $this->info("Database connection successful: " . DB::connection()->getDatabaseName());
        } catch (\Exception $e) {
            $this->error("Database connection error: " . $e->getMessage());
            return Command::FAILURE;
        }

        // Check notifications table
        try {
            $tableExists = DB::getSchemaBuilder()->hasTable('notifications');
            $this->info("Notifications table exists: " . ($tableExists ? "Yes" : "No"));

            if ($tableExists) {
                $columns = DB::getSchemaBuilder()->getColumnListing('notifications');
                $this->info("Notifications table columns: " . implode(", ", $columns));
            }
        } catch (\Exception $e) {
            $this->error("Error checking notifications table: " . $e->getMessage());
        }

        // Try direct database insert
        try {
            $user = User::first();

            if (!$user) {
                $this->error("No users found in the database");
                return Command::FAILURE;
            }

            $this->info("Testing direct database insert with user: {$user->name} (ID: {$user->id})");

            // Create notification data
            $notificationData = [
                'id' => Str::uuid()->toString(),
                'type' => 'App\\Notifications\\LowWorkloadNotification',
                'notifiable_type' => get_class($user),
                'notifiable_id' => $user->id,
                'data' => json_encode([
                    'title' => 'Low Teaching Workload Warning',
                    'current_workload' => 10,
                    'minimum_required' => 20,
                    'message' => 'Your workload is below the minimum.',
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Attempt direct insert
            $inserted = DB::table('notifications')->insert($notificationData);

            $this->info("Direct database insert result: " . ($inserted ? "Success" : "Failed"));

            // Check if notification was saved
            $notificationCount = DB::table('notifications')
                ->where('notifiable_id', $user->id)
                ->count();

            $this->info("Notifications in database after direct insert: {$notificationCount}");

        } catch (\Exception $e) {
            $this->error("Error with direct database insert: " . $e->getMessage());
            return Command::FAILURE;
        }

        // Try the regular notification system
        try {
            $user = User::first();
            $this->info("Testing notification with user: {$user->name} (ID: {$user->id})");

            // Create test notification
            $notification = new LowWorkloadNotification(10, 20);

            // Log notification details
            $this->info("Notification channels: " . implode(", ", $notification->via($user)));

            // Bypass queue and send notification synchronously
            config(['queue.default' => 'sync']);

            // Send notification
            $user->notify($notification);

            // Check if notification was saved
            $notificationCount = DB::table('notifications')
                ->where('notifiable_id', $user->id)
                ->count();

            $this->info("Notifications in database after sending: {$notificationCount}");

        } catch (\Exception $e) {
            $this->error("Error sending test notification: " . $e->getMessage());
            $this->error("Stack trace: " . $e->getTraceAsString());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
