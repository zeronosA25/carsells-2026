@extends('front.layouts.dashboard')

@section('content')
    <style>
        .inventory-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 28px;
        }

        .inventory-title {
            margin: 0;
            font-size: 38px;
            font-weight: 300;
            color: #e5e7eb;
        }

        .inventory-subtitle {
            margin-top: 6px;
            color: #9ca3af;
            max-width: 520px;
            line-height: 1.5;
        }

        .filter-row {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 16px;
            margin-bottom: 22px;
        }

        .filter-input,
        .filter-select {
            width: 100%;
            background: #171d27;
            border: 1px solid rgba(255, 255, 255, 0.08);
            color: #d1d5db;
            padding: 13px 16px;
            outline: none;
        }

        .inventory-table-card {
            background: #171d27;
            border: 1px solid rgba(255, 255, 255, 0.06);
            overflow: hidden;
        }

        .inventory-table {
            width: 100%;
            border-collapse: collapse;
        }

        .inventory-table th {
            text-align: left;
            color: #f4d24b;
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            font-weight: 600;
            padding: 18px 22px;
            background: rgba(255, 255, 255, 0.02);
        }

        .inventory-table td {
            padding: 18px 22px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            color: #d1d5db;
            font-size: 14px;
        }

        .vehicle-cell {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .vehicle-image {
            width: 72px;
            height: 42px;
            object-fit: cover;
            background: #0d1118;
            border: 1px solid rgba(255, 255, 255, 0.06);
        }

        .vehicle-name {
            color: #e5e7eb;
            font-weight: 600;
        }

        .vehicle-code {
            color: #6b7280;
            font-size: 11px;
            margin-top: 4px;
        }

        .color-dot {
            width: 11px;
            height: 11px;
            border-radius: 999px;
            display: inline-block;
            margin-right: 8px;
            background: #f4d24b;
        }

        .price-text {
            color: #f4d24b;
            font-weight: 600;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 999px;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .status-available {
            background: rgba(34, 197, 94, 0.12);
            color: #86efac;
        }

        .status-booked {
            background: rgba(244, 210, 75, 0.12);
            color: #f4d24b;
        }

        .status-sold {
            background: rgba(156, 163, 175, 0.12);
            color: #9ca3af;
        }

        .inventory-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 22px;
            color: #9ca3af;
            font-size: 12px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
            margin-top: 26px;
        }

        .summary-card {
            background: #171d27;
            border: 1px solid rgba(255, 255, 255, 0.06);
            padding: 24px;
        }

        .summary-label {
            font-size: 11px;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 22px;
        }

        .summary-value {
            font-size: 32px;
            color: #e5e7eb;
            font-weight: 300;
        }

        .summary-sub {
            color: #f4d24b;
            font-size: 11px;
            margin-top: 6px;
        }

        .pagination-wrap {
            margin-top: 16px;
            color: #d1d5db;
        }

        @media (max-width: 900px) {
            .inventory-header,
            .inventory-footer {
                flex-direction: column;
                gap: 14px;
                align-items: flex-start;
            }

            .filter-row,
            .summary-grid {
                grid-template-columns: 1fr;
            }

            .inventory-table {
                min-width: 900px;
            }

            .inventory-table-card {
                overflow-x: auto;
            }
        }
    </style>

    <div class="inventory-header">
        <div>
            <h1 class="inventory-title">Global Inventory</h1>
            <div class="inventory-subtitle">
                Manage and monitor your fleet across all principal regions. Precision tracking for ultimate control.
            </div>
        </div>

        <a href="/admin/cars/create" class="btn-gold">
            + Add New Unit
        </a>
    </div>

    <form method="GET" action="{{ route('front.inventory.index') }}" class="filter-row">
        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Search by brand, model, plate number..."
            class="filter-input"
        >

        <select name="brand" class="filter-select" onchange="this.form.submit()">
            <option value="">All Brands</option>
            @foreach ($brands as $brand)
                <option value="{{ $brand }}" @selected(request('brand') === $brand)>
                    {{ $brand }}
                </option>
            @endforeach
        </select>

        <select name="status" class="filter-select" onchange="this.form.submit()">
            <option value="">All Statuses</option>
            <option value="available" @selected(request('status') === 'available')>Available</option>
            <option value="booked" @selected(request('status') === 'booked')>Booked</option>
            <option value="sold" @selected(request('status') === 'sold')>Sold</option>
        </select>
    </form>

    <div class="inventory-table-card">
        <table class="inventory-table">
            <thead>
                <tr>
                    <th>Vehicle Unit</th>
                    <th>Type</th>
                    <th>Specifications</th>
                    <th>Valuation</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($cars as $car)
                    <tr>
                        <td>
                            <div class="vehicle-cell">
                                @if ($car->image)
                                    <img
                                        src="{{ asset('storage/' . $car->image) }}"
                                        alt="{{ $car->brand }} {{ $car->model }}"
                                        class="vehicle-image"
                                    >
                                @else
                                    <div class="vehicle-image"></div>
                                @endif

                                <div>
                                    <div class="vehicle-name">
                                        {{ $car->brand }} {{ $car->model }}
                                    </div>
                                    <div class="vehicle-code">
                                        VIN: {{ $car->plate_number ?? 'N/A' }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td>
                            {{ $car->year }} {{ ucfirst($car->transmission) }}
                        </td>

                        <td>
                            <span class="color-dot"></span>
                            {{ $car->color ?? '-' }} / {{ $car->fuel_type ?? '-' }}
                        </td>

                        <td class="price-text">
                            Rp {{ number_format($car->selling_price, 0, ',', '.') }}
                        </td>

                        <td>
                            <span class="status-badge status-{{ $car->status }}">
                                {{ $car->status }}
                            </span>
                        </td>

                        <td>
                            <a href="/admin/cars/{{ $car->id }}/edit" class="text-gold">
                                Edit
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center; color:#9ca3af; padding:40px;">
                            Belum ada data mobil.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="inventory-footer">
            <div>
                Showing {{ $cars->firstItem() ?? 0 }} to {{ $cars->lastItem() ?? 0 }}
                of {{ $cars->total() }} executive units
            </div>

            <div>
                Page {{ $cars->currentPage() }} of {{ $cars->lastPage() }}
            </div>
        </div>
    </div>

    <div class="pagination-wrap">
        {{ $cars->links() }}
    </div>

    <div class="summary-grid">
        <div class="summary-card">
            <div class="summary-label">Total Value</div>
            <div class="summary-value">
                Rp {{ number_format($totalValue, 0, ',', '.') }}
            </div>
            <div class="summary-sub">
                Inventory valuation
            </div>
        </div>

        <div class="summary-card">
            <div class="summary-label">Active Reservations</div>
            <div class="summary-value">
                {{ $activeReservations }} Units
            </div>
            <div class="summary-sub">
                Estimated closing 4 days
            </div>
        </div>

        <div class="summary-card">
            <div class="summary-label">Available Units</div>
            <div class="summary-value">
                {{ $availableUnits }} Units
            </div>
            <div class="summary-sub">
                Ready for transaction
            </div>
        </div>
    </div>
@endsection
