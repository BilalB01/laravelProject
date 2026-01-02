<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nieuws
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($news as $item)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition">
                        @if($item->image_path)
                            <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->title }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-primary-100 flex items-center justify-center">
                                <span class="text-primary-600 text-4xl font-bold">{{ strtoupper(substr($item->title, 0, 1)) }}</span>
                            </div>
                        @endif
                        
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $item->title }}</h3>
                            <p class="text-sm text-gray-500 mb-4">{{ $item->published_at->format('d-m-Y') }}</p>
                            <p class="text-gray-700 mb-4 line-clamp-3">{{ Str::limit($item->content, 150) }}</p>
                            <a href="{{ route('news.show', $item) }}" class="inline-flex items-center text-primary hover:text-primary-700 font-semibold">
                                Lees meer
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-500 text-lg">Geen nieuwsitems beschikbaar.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
