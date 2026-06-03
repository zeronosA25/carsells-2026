@extends('front.layouts.app')

@section('content')
    <section class="max-w-7xl mx-auto px-4 py-12">
        <h1 class="text-3xl font-bold mb-6">
            Inventory Mobil
        </h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse ($cars as $car)
                <div class="bg-white rounded-xl shadow overflow-hidden">
                    @if ($car->image)
                        <img src="{{ asset('storage/' . $car->image) }}"
                             alt="{{ $car->brand }} {{ $car->model }}"
                             class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">
                            No Image
                        </div>
                    @endif

                    <div class="p-5">
                        <h2 class="text-lg font-bold">
                            {{ $car->brand }} {{ $car->model }}
                        </h2>

                        <p class="text-sm text-gray-500">
                            {{ $car->year }} • {{ ucfirst($car->transmission) }}
                        </p>

                        <p class="mt-3 text-xl font-bold text-blue-600">
                            Rp {{ number_format($car->selling_price, 0, ',', '.') }}
                        </p>

                        <a href="{{ route('cars.show', $car) }}"
                           class="mt-4 inline-block w-full text-center bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                            Detail Mobil
                        </a>
                    </div>
                </div>
            @empty
                <p class="text-gray-500">
                    Belum ada mobil tersedia.
                </p>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $cars->links() }}
        </div>
    </section>
@endsection
