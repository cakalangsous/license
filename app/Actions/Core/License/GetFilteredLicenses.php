<?php

namespace App\Actions\Core\License;

use App\Models\License;
use App\Models\Product;
use App\Models\Marketplace;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class GetFilteredLicenses
{
    public function execute(Request $request): array
    {
        $query = License::with(['product', 'marketplace'])
            ->withCount(['activations', 'productionActivations', 'localActivations']);

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('purchase_code', 'like', '%' . $request->search . '%')
                    ->orWhere('buyer_email', 'like', '%' . $request->search . '%')
                    ->orWhere('buyer_name', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->product_id) {
            $query->where('product_id', $request->product_id);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->license_type) {
            $query->where('license_type', $request->license_type);
        }

        // Support status filter
        if ($request->support_status) {
            switch ($request->support_status) {
                case 'active':
                    $query->activeSupport();
                    break;
                case 'expiring':
                    $query->expiringSupport(30);
                    break;
                case 'expired':
                    $query->expiredSupport();
                    break;
                case 'lifetime':
                    $query->lifetimeSupport();
                    break;
            }
        }

        // Transform licenses to include support_status
        $licenses = $query->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        // Append support_status to each license
        $licenses->getCollection()->transform(function ($license) {
            $license->append('support_status');
            return $license;
        });

        return [
            'licenses' => $licenses,
            'products' => Product::where('is_active', true)->get(['id', 'name']),
            'marketplaces' => Marketplace::where('is_active', true)->get(['id', 'name']),
        ];
    }
}

