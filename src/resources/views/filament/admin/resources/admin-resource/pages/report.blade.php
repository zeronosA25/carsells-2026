<x-filament-panels::page>
    @php
        $stats = $this->getStats();
        $latestSales = $this->getLatestSales();
    @endphp
    
    <x-filament::section>
        <x-slot name="heading">
        Filter Report
    </x-slot>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <div>
            <label class="text-sm font-medium">
                Tanggal Mulai
            </label>

            <x-filament::input.wrapper class="mt-1">
                <x-filament::input
                    type="date"
                    wire:model.live="startDate"
                />
            </x-filament::input.wrapper>
        </div>

        <div>
            <label class="text-sm font-medium">
                Tanggal Akhir
            </label>

            <x-filament::input.wrapper class="mt-1">
                <x-filament::input
                    type="date"
                    wire:model.live="endDate"
                />
            </x-filament::input.wrapper>
        </div>
    </div>
</x-filament::section>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
        <x-filament::section>
            <div class="text-sm text-gray-500">Total Mobil</div>
            <div class="mt-2 text-3xl font-bold">
                {{ $stats['total_cars'] }}
            </div>
        </x-filament::section>

        <x-filament::section>
            <div class="text-sm text-gray-500">Mobil Tersedia</div>
            <div class="mt-2 text-3xl font-bold text-success-600">
                {{ $stats['available_cars'] }}
            </div>
        </x-filament::section>

        <x-filament::section>
            <div class="text-sm text-gray-500">Mobil Terjual</div>
            <div class="mt-2 text-3xl font-bold text-danger-600">
                {{ $stats['sold_cars'] }}
            </div>
        </x-filament::section>

        <x-filament::section>
            <div class="text-sm text-gray-500">Mobil Booked</div>
            <div class="mt-2 text-3xl font-bold text-warning-600">
                {{ $stats['booked_cars'] }}
            </div>
        </x-filament::section>
    </div>

    <div class="grid grid-cols-1 gap-4 mt-4 md:grid-cols-2 xl:grid-cols-4">
        <x-filament::section>
            <div class="text-sm text-gray-500">Total Customer</div>
            <div class="mt-2 text-3xl font-bold">
                {{ $stats['total_customers'] }}
            </div>
        </x-filament::section>

        <x-filament::section>
            <div class="text-sm text-gray-500">Total Transaksi</div>
            <div class="mt-2 text-3xl font-bold">
                {{ $stats['total_sales'] }}
            </div>
        </x-filament::section>

        <x-filament::section>
            <div class="text-sm text-gray-500">Pendapatan Lunas</div>
            <div class="mt-2 text-2xl font-bold text-success-600">
                Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}
            </div>
        </x-filament::section>

        <x-filament::section>
            <div class="text-sm text-gray-500">Pembayaran Pending</div>
            <div class="mt-2 text-2xl font-bold text-warning-600">
                Rp {{ number_format($stats['pending_payment'], 0, ',', '.') }}
            </div>
        </x-filament::section>
    </div>

    <x-filament::section class="mt-6">
        <x-slot name="heading">
            Riwayat Transaksi Terbaru
        </x-slot>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b">
                        <th class="px-3 py-2 text-left">Invoice</th>
                        <th class="px-3 py-2 text-left">Customer</th>
                        <th class="px-3 py-2 text-left">Mobil</th>
                        <th class="px-3 py-2 text-left">Tanggal</th>
                        <th class="px-3 py-2 text-left">Status</th>
                        <th class="px-3 py-2 text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($latestSales as $sale)
                        <tr class="border-b">
                            <td class="px-3 py-2">
                                {{ $sale->invoice_number }}
                            </td>

                            <td class="px-3 py-2">
                                {{ $sale->customer?->name ?? '-' }}
                            </td>

                            <td class="px-3 py-2">
                                {{ $sale->car?->brand }} {{ $sale->car?->model }}
                            </td>

                            <td class="px-3 py-2">
                                {{ $sale->sale_date?->format('d M Y') }}
                            </td>

                            <td class="px-3 py-2">
                                {{ ucfirst($sale->payment_status) }}
                            </td>

                            <td class="px-3 py-2 text-right">
                                Rp {{ number_format($sale->total_price, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-3 py-4 text-center text-gray-500">
                                Belum ada transaksi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-filament::section>
</x-filament-panels::page>
