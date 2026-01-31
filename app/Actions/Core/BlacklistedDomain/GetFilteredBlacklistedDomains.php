<?php

namespace App\Actions\Core\BlacklistedDomain;

use App\Models\BlacklistedDomain;
use Illuminate\Http\Request;

class GetFilteredBlacklistedDomains
{
    public function execute(Request $request): array
    {
        $query = BlacklistedDomain::query();

        if ($request->search) {
            $query->where('pattern', 'like', '%' . $request->search . '%')
                ->orWhere('reason', 'like', '%' . $request->search . '%');
        }

        return [
            'domains' => $query
                ->orderBy('created_at', 'desc')
                ->paginate(15)
                ->withQueryString(),
        ];
    }
}
