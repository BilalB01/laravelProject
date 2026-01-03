<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Zoekresultaten
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search Form -->
            <div class="mb-8">
                <form method="GET" action="{{ route('search') }}" class="flex gap-2">
                    <input 
                        type="text" 
                        name="q" 
                        value="{{ $query }}" 
                        placeholder="Zoek een persoon of nieuws..."
                        class="flex-1 border-gray-300 focus:border-primary focus:ring-primary rounded-md shadow-sm"
                        autofocus
                    >
                    <button type="submit" class="bg-primary text-white px-6 py-2 rounded-md hover:bg-primary-700 transition">
                        Zoeken
                    </button>
                </form>
            </div>

            @if($query)
                <!-- Users Results -->
                <div class="mb-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Gebruikers ({{ $users->count() }})</h3>
                    
                    @if($users->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($users as $profile)
                                <a href="{{ route('profile.show', $profile->username) }}" class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition border border-gray-100">
                                    <div class="flex items-center space-x-4">
                                        @if($profile->profile_photo)
                                            <img src="{{ asset('storage/' . $profile->profile_photo) }}" alt="{{ $profile->username }}" class="w-16 h-16 rounded-full object-cover">
                                        @else
                                            <div class="w-16 h-16 rounded-full bg-primary-100 flex items-center justify-center">
                                                <span class="text-primary-600 text-xl font-bold">{{ strtoupper(substr($profile->username, 0, 1)) }}</span>
                                            </div>
                                        @endif
                                        
                                        <div>
                                            <h4 class="font-semibold text-gray-900">{{ $profile->user->name }}</h4>
                                            <p class="text-sm text-primary">{{ '@' . $profile->username }}</p>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">Geen gebruikers gevonden.</p>
                    @endif
                </div>

                <!-- News Results -->
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Nieuws ({{ $news->count() }})</h3>
                    
                    @if($news->count() > 0)
                        <div class="space-y-4">
                            @foreach($news as $item)
                                <a href="{{ route('news.show', $item) }}" class="block bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition border border-gray-100">
                                    <div class="flex gap-4">
                                        @if($item->image_path)
                                            <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->title }}" class="w-24 h-24 object-cover rounded">
                                        @endif
                                        
                                        <div class="flex-1">
                                            <h4 class="text-xl font-bold text-gray-900 mb-2">{{ $item->title }}</h4>
                                            <p class="text-sm text-gray-500 mb-2">{{ $item->published_at->format('d-m-Y') }}</p>
                                            <p class="text-gray-700 line-clamp-2">{{ Str::limit($item->content, 150) }}</p>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">Geen nieuwsartikelen gevonden.</p>
                    @endif
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-gray-500 text-lg">Voer een zoekterm in om te beginnen met zoeken.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
