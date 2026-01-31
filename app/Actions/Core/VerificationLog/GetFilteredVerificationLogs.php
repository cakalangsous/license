<?php

namespace App\Actions\Core\VerificationLog;

use App\Models\VerificationLog;
use Illuminate\Http\Request;

class GetFilteredVerificationLogs
{
    public function execute(Request $request): array
    {
        $query = VerificationLog::with(['license', 'activation']);

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('domain', 'like', '%' . $request->search . '%')
                    ->orWhere('ip_address', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->request_type) {
            $query->where('request_type', $request->request_type);
        }

        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        return [
            'logs' => $query
                ->orderBy('created_at', 'desc')
                ->paginate(25)
                ->withQueryString(),
            'stats' => [
                'total_requests' => VerificationLog::count(),
                'success_count' => VerificationLog::where('status', 'success')->count(),
                'failed_count' => VerificationLog::where('status', 'failed')->count(),
                'today_count' => VerificationLog::whereDate('created_at', today())->count(),
            ],
        ];
    }
}
