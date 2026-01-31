<?php

namespace App\Actions\Core\Marketplace;

use App\Models\Marketplace;
use Illuminate\Http\Request;

class GetFilteredMarketplaces
{
    public function execute(Request $request): array
    {
        $query = Marketplace::query();

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        return [
            'marketplaces' => $query
                ->withCount(['licenses', 'sales'])
                ->orderBy('created_at', 'desc')
                ->paginate(15)
                ->withQueryString(),
        ];
    }
}
