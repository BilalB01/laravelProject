<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $news->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if($news->image_path)
                    <img src="{{ asset('storage/' . $news->image_path) }}" alt="{{ $news->title }}" class="w-full h-96 object-cover">
                @endif
                
                <div class="p-8">
                    <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $news->title }}</h1>
                    <p class="text-gray-500 mb-6">Gepubliceerd op {{ $news->published_at->format('d F Y') }}</p>
                    
                    <div class="prose max-w-none">
                        <p class="text-gray-700 whitespace-pre-line">{{ $news->content }}</p>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <a href="{{ route('news.index') }}" class="inline-flex items-center text-primary hover:text-primary-700 font-semibold">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Terug naar overzicht
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
