<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\LowWorkloadNotification;
use App\Models\WorkloadProfile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WorkloadController extends Controller
{
    public function checkWorkloads()
    {
        try {
            // Get workload profiles indexed by 'type'
            $profiles = WorkloadProfile::all()->keyBy('type');

            $professors = User::whereIn('role', ['professor', 'vacataire'])
                ->with('assignments.teachingUnit')
                ->get();

            $notifiedCount = 0;
            $errors = [];

            foreach ($professors as $prof) {
                $role = $prof->role;

                // Check if a profile exists for this role
                if (!isset($profiles[$role])) {
                    $errors[] = "No workload profile found for role: {$role}";
                    continue;
                }

                // Get the min hours for this role
                $minimum = $profiles[$role]->min_hours;

                $workload = $prof->assignments->sum(function ($assignment) {
                    return $assignment->teachingUnit?->hours ?? 0;
                });

                if ($workload < $minimum) {
                    try {
                        // Try to use the manual notification method
                        $this->manualNotify($prof, $workload, $minimum);
                        $notifiedCount++;
                    } catch (\Exception $e) {
                        $errors[] = "Failed to notify professor {$prof->id}: {$e->getMessage()}";
                        Log::error("Notification error: " . $e->getMessage());
                    }
                }
            }

            return response()->json([
                'status' => 'ok',
                'notified_users' => $notifiedCount,
                'errors' => $errors,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // Manual notification function that bypasses Laravel's notification system
    protected function manualNotify($user, $workload, $minimum)
    {
        // Create notification data for database
        $notificationData = [
            'id' => Str::uuid()->toString(),
            'type' => 'App\\Notifications\\LowWorkloadNotification',
            'notifiable_type' => get_class($user),
            'notifiable_id' => $user->id,
            'data' => json_encode([
                'title' => 'Low Teaching Workload Warning',
                'current_workload' => $workload,
                'minimum_required' => $minimum,
                'message' => 'Your workload is below the minimum.',
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Insert directly into database
        $inserted = DB::table('notifications')->insert($notificationData);

        Log::info("Manual notification for user {$user->id}: " . ($inserted ? "Success" : "Failed"));

        return $inserted;
    }
}
