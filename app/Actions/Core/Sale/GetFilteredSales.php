<?php

namespace App\Actions\Core\Sale;

use App\Models\Sale;
use App\Models\Product;
use App\Models\Marketplace;
use Illuminate\Http\Request;

class GetFilteredSales
{
    public function execute(Request $request): array
    {
        $query = Sale::with(['license', 'product', 'marketplace']);

        if ($request->search) {
            $query->whereHas('license', function ($q) use ($request) {
                $q->where('purchase_code', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->marketplace_id) {
            $query->where('marketplace_id', $request->marketplace_id);
        }

        if ($request->product_id) {
            $query->where('product_id', $request->product_id);
        }

        if ($request->date_from) {
            $query->whereDate('sale_date', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->whereDate('sale_date', '<=', $request->date_to);
        }

        return [
            'sales' => $query
                ->orderBy('sale_date', 'desc')
                ->paginate(15)
                ->withQueryString(),
            'stats' => [
                'total_revenue' => Sale::sum('net_amount'),
                'total_sales' => Sale::count(),
                'this_month' => Sale::whereMonth('sale_date', now()->month)
                    ->whereYear('sale_date', now()->year)
                    ->sum('net_amount'),
                'marketplace_fees' => Sale::sum('marketplace_fee'),
            ],
            'products' => Product::select('id', 'name')->get(),
            'marketplaces' => Marketplace::select('id', 'name')->get(),
        ];
    }
}
