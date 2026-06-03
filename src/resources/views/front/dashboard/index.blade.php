@extends('front.layouts.dashboard')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Dashboard</h1>
            <div class="page-subtitle">
                Executive overview for <span class="text-gold">CarSells Group</span>
            </div>
        </div>

        <div class="actions">
            <button class="btn-outline">Export Report</button>
            <button class="btn-gold">Configure Dashboard</button>
        </div>
    </div>

    <div class="grid-3">
        <div class="card">
            <div class="card-label">Units Sold</div>
            <div class="card-sub">This Month</div>
            <div class="stat-number">{{ $totalSold }}</div>
            <div class="small-muted">
                <span style="color:#f87171;">↓ 12%</span> vs last month
            </div>
        </div>

        <div class="card">
            <div class="card-label">Total Revenue</div>
            <div class="card-sub">Current Quarter</div>
            <div class="stat-number">
                Rp {{ number_format($totalRevenue, 0, ',', '.') }}
            </div>
            <div class="small-muted">
                <span style="color:#f87171;">↓ 8.4%</span> vs forecast
            </div>
        </div>

        <div class="card card-highlight">
            <div class="card-label">Target Progress</div>
            <div class="card-sub">Monthly Goal</div>

            <div style="display:flex; justify-content:space-between; align-items:end;">
                <div class="stat-number">84%</div>
                <div class="small-muted">35/42 Units</div>
            </div>

            <div class="progress">
                <div class="progress-fill"></div>
            </div>
        </div>
    </div>

    <div class="grid-main">
        <div class="card">
            <div style="display:flex; justify-content:space-between;">
                <h2 style="margin:0; font-size:20px; font-weight:400;">Sales Trends</h2>
                <div class="small-muted">7D &nbsp; <span class="text-gold">1M</span> &nbsp; 1Y</div>
            </div>

            <div class="chart">
                <div class="bar" style="height:95px;"></div>
                <div class="bar" style="height:65px;"></div>
                <div class="bar" style="height:120px;"></div>
                <div class="bar" style="height:90px;"></div>
                <div class="bar active" style="height:150px;"></div>
            </div>

            <div style="display:flex; justify-content:space-around;" class="small-muted">
                <span>JAN</span>
                <span>FEB</span>
                <span>MAR</span>
                <span>APR</span>
                <span>MAY</span>
            </div>
        </div>

        <div class="card">
            <div class="card-label" style="margin-bottom:22px;">Recent Activity</div>

            @forelse ($latestSales as $sale)
                <div class="activity">
                    <div class="activity-icon"></div>
                    <div>
                        <div class="activity-title">Sale Confirmed</div>
                        <div class="activity-desc">
                            {{ $sale->customer?->name }} membeli
                            {{ $sale->car?->brand }} {{ $sale->car?->model }}
                        </div>
                        <div class="card-sub" style="margin-top:6px; margin-bottom:0;">
                            {{ $sale->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="small-muted">Belum ada aktivitas transaksi.</div>
            @endforelse
        </div>
    </div>

    <h2 class="section-title">Inventory Spotlight</h2>

    <div class="inventory-grid">
        @forelse ($availableCars as $car)
            <div class="car-card">
                @if ($car->image)
                    <img src="{{ asset('storage/' . $car->image) }}"
                         alt="{{ $car->brand }} {{ $car->model }}">
                @else
                    <div class="car-placeholder">No Image</div>
                @endif

                <div class="car-body">
                    <div class="car-title">
                        {{ $car->year }} {{ $car->brand }} {{ $car->model }}
                    </div>
                    <div class="car-price">
                        Rp {{ number_format($car->selling_price, 0, ',', '.') }}
                    </div>
                </div>
            </div>
        @empty
            <div class="card small-muted">
                Belum ada mobil tersedia.
            </div>
        @endforelse
    </div>
@endsection
