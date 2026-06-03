@extends('front.layouts.app')

@section('content')
    <section class="max-w-7xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                @if ($car->image)
                    <img src="{{ asset('storage/' . $car->image) }}"
                         alt="{{ $car->brand }} {{ $car->model }}"
                         class="w-full rounded-xl shadow object-cover">
                @else
                    <div class="w-full h-96 bg-gray-200 rounded-xl flex items-center justify-center text-gray-500">
                        No Image
                    </div>
                @endif
            </div>

            <div class="bg-white p-6 rounded-xl shadow">
                <h1 class="text-3xl font-bold mb-2">
                    {{ $car->brand }} {{ $car->model }}
                </h1>

                <p class="text-gray-500 mb-4">
                    {{ $car->year }} • {{ ucfirst($car->transmission) }} • {{ $car->fuel_type ?? '-' }}
                </p>

                <p class="text-3xl font-bold text-blue-600 mb-6">
                    Rp {{ number_format($car->selling_price, 0, ',', '.') }}
                </p>

                <div class="space-y-3 text-sm">
                    <div class="flex justify-between border-b pb-2">
                        <span class="text-gray-500">Plat Nomor</span>
                        <span>{{ $car->plate_number ?? '-' }}</span>
                    </div>

                    <div class="flex justify-between border-b pb-2">
                        <span class="text-gray-500">Warna</span>
                        <span>{{ $car->color ?? '-' }}</span>
                    </div>

                    <div class="flex justify-between border-b pb-2">
                        <span class="text-gray-500">Kilometer</span>
                        <span>{{ number_format($car->mileage, 0, ',', '.') }} KM</span>
                    </div>

                    <div class="flex justify-between border-b pb-2">
                        <span class="text-gray-500">Status</span>
                        <span class="font-semibold text-green-600">
                            Available
                        </span>
                    </div>
                </div>

                <div class="mt-6">
                    <h2 class="font-bold mb-2">Deskripsi</h2>
                    <p class="text-gray-600">
                        {{ $car->description ?? 'Belum ada deskripsi.' }}
                    </p>
                </div>

                <a href="https://wa.me/6281234567890?text=Saya%20tertarik%20dengan%20mobil%20{{ urlencode($car->brand . ' ' . $car->model) }}"
                   target="_blank"
                   class="mt-6 inline-block w-full text-center bg-green-600 text-white px-4 py-3 rounded-lg hover:bg-green-700">
                    Hubungi via WhatsApp
                </a>
            </div>
        </div>
    </section>
@endsection
