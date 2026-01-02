<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Profiel van {{ $profile->username }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <!-- Profile Header -->
                    <div class="text-center mb-8">
                        <div class="flex justify-center mb-4">
                            @if($profile->profile_photo)
                                <img src="{{ asset('storage/' . $profile->profile_photo) }}" alt="{{ $profile->username }}" class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-lg">
                            @else
                                <div class="w-32 h-32 rounded-full bg-primary-100 flex items-center justify-center border-4 border-white shadow-lg text-primary-600 text-4xl font-bold">
                                    {{ strtoupper(substr($profile->username, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <h1 class="text-4xl font-bold text-primary mb-2">{{ $profile->username }}</h1>
                        <p class="text-gray-600 text-lg">{{ $user->name }}</p>
                        
                        <div class="flex justify-center gap-4 mt-2 text-sm text-gray-500">
                            <span>Lid sinds {{ $user->created_at->format('F Y') }}</span>
                            @if($profile->birthday)
                                <span>•</span>
                                <span>Verjaardag: {{ $profile->birthday->format('d-m-Y') }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- About Me Section -->
                    <div class="border-t border-gray-200 pt-6">
                        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Over Mij</h2>
                        @if($profile->about_me)
                            <p class="text-gray-700 whitespace-pre-line">{{ $profile->about_me }}</p>
                        @else
                            <p class="text-gray-500 italic">Deze gebruiker heeft nog geen informatie toegevoegd.</p>
                        @endif
                    </div>

                    <!-- Edit Button (only for own profile) -->
                    @auth
                        @if(auth()->id() === $user->id)
                            <div class="mt-8 pt-6 border-t border-gray-200">
                                <a href="{{ route('profile.page.edit') }}" class="inline-flex items-center px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary-700 transition">
                                    Profiel Bewerken
                                </a>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
