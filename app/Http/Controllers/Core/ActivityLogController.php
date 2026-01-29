<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\CoreController;
use Illuminate\Http\Request;
use Inertia\Response;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends CoreController
{
    public function index(Request $request): Response
    {
        $query = Activity::query()->with('causer');

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('description', 'like', "%{$search}%")
                ->orWhereHas('causer', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
        }

        $activities = $query->latest()->paginate(15)->transform(function ($activity) {
            return [
                'id' => $activity->id,
                'description' => $activity->description, // e.g., 'created', 'updated'
                'subject_type' => class_basename($activity->subject_type),
                'subject_id' => $activity->subject_id,
                'causer' => $activity->causer ? $activity->causer->name : 'System',
                'properties' => $activity->properties,
                'created_at' => $activity->created_at->format('Y-m-d H:i:s'),
                'created_at_human' => $activity->created_at->diffForHumans(),
            ];
        });

        return inertia('Core/Admin/ActivityLog/Index', [
            'activities' => $activities,
        ]);
    }
}
