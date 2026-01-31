<?php

namespace App\Actions\Core\Dashboard;

use App\Models\License;
use App\Models\Activation;
use App\Models\VerificationLog;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class GetDashboardData
{
    public function execute(): array
    {
        return [
            'stats' => $this->getLicenseStats(),
            'charts' => $this->getChartData(),
            'recentActivations' => $this->getRecentActivations(),
            'expiringSupport' => $this->getExpiringSupport(),
            'serverInfo' => $this->getServerInfo(),
        ];
    }

    private function getLicenseStats(): array
    {
        return [
            'totalLicenses' => License::count(),
            'activeLicenses' => License::where('status', 'active')->count(),
            'totalActivations' => Activation::where('status', 'active')->count(),
            'expiringSupport' => License::expiringSupport(30)->count(),
            'thisMonthSales' => Sale::whereMonth('sale_date', now()->month)
                                    ->whereYear('sale_date', now()->year)
                                    ->count(),
            'totalRevenue' => Sale::sum('net_amount'),
        ];
    }

    private function getChartData(): array
    {
        // Sales Growth (Last 6 months)
        $salesGrowth = Sale::select('sale_date')
            ->where('sale_date', '>=', now()->subMonths(6))
            ->orderBy('sale_date')
            ->get()
            ->groupBy(function ($sale) {
                return $sale->sale_date->format('M Y');
            })
            ->map(fn ($row) => $row->count());

        // License Status Distribution
        $licenseDistribution = License::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status');

        // License Type Distribution
        $typeDistribution = License::select('license_type', DB::raw('COUNT(*) as count'))
            ->groupBy('license_type')
            ->pluck('count', 'license_type');

        // Daily API Calls (Last 7 days)
        $apiCalls = VerificationLog::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date');

        return [
            'salesGrowth' => [
                'labels' => $salesGrowth->keys()->all(),
                'data' => $salesGrowth->values()->all(),
            ],
            'licenseDistribution' => [
                'labels' => $licenseDistribution->keys()->map(fn($s) => ucfirst($s))->all(),
                'data' => $licenseDistribution->values()->all(),
            ],
            'typeDistribution' => [
                'labels' => $typeDistribution->keys()->map(fn($t) => ucfirst($t))->all(),
                'data' => $typeDistribution->values()->all(),
            ],
            'apiCalls' => [
                'labels' => $apiCalls->keys()->map(fn($d) => date('M d', strtotime($d)))->all(),
                'data' => $apiCalls->values()->all(),
            ],
        ];
    }

    private function getRecentActivations()
    {
        return Activation::with(['license.product'])
            ->latest('activated_at')
            ->take(5)
            ->get()
            ->map(fn ($a) => [
                'id' => $a->id,
                'domain' => $a->domain,
                'is_local' => $a->is_local,
                'product' => $a->license?->product?->name ?? 'Unknown',
                'activated_at' => $a->activated_at->diffForHumans(),
            ]);
    }

    private function getExpiringSupport()
    {
        return License::expiringSupport(30)
            ->with('product')
            ->orderBy('supported_until')
            ->take(5)
            ->get()
            ->map(fn ($l) => [
                'id' => $l->id,
                'purchase_code' => substr($l->purchase_code, 0, 8) . '...',
                'product' => $l->product?->name ?? 'Unknown',
                'supported_until' => $l->supported_until->format('M d, Y'),
                'days_left' => $l->supported_until->diffInDays(now()),
            ]);
    }

    private function getServerInfo(): array
    {
        return [
            ['label' => 'PHP', 'value' => phpversion()],
            ['label' => 'Laravel', 'value' => app()->version()],
            ['label' => 'OS', 'value' => PHP_OS],
            ['label' => 'Timezone', 'value' => config('app.timezone')],
            ['label' => 'Debug Mode', 'value' => config('app.debug') ? 'Enabled' : 'Disabled'],
        ];
    }
}

