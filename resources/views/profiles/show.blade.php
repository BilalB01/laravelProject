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

                    <!-- Profile Messages Wall -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Berichten ({{ $messages->count() }})</h2>
                        
                        <!-- Post Message Form (only for other users when logged in) -->
                        @auth
                            @if(auth()->id() !== $user->id)
                                <form action="{{ route('profile.messages.store', $profile->username) }}" method="POST" class="mb-6">
                                    @csrf
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <textarea 
                                            name="message" 
                                            rows="3" 
                                            class="w-full border-gray-300 rounded-lg focus:border-primary focus:ring-primary"
                                            placeholder="Schrijf een bericht op het profiel van {{ $profile->username }}..."
                                            required
                                            maxlength="500"
                                        ></textarea>
                                        @error('message')
                                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                        <div class="flex justify-between items-center mt-2">
                                            <span class="text-sm text-gray-500">Max 500 karakters</span>
                                            <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-700 transition">
                                                Bericht Plaatsen
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            @endif
                        @else
                            <div class="bg-gray-50 rounded-lg p-4 mb-6 text-center">
                                <p class="text-gray-600">
                                    <a href="{{ route('login') }}" class="text-primary hover:underline">Log in</a> om een bericht te plaatsen
                                </p>
                            </div>
                        @endauth

                        <!-- Messages List -->
                        <div class="space-y-4">
                            @forelse($messages as $message)
                                <div class="bg-white border border-gray-200 rounded-lg p-4">
                                    <div class="flex items-start justify-between">
                                        <div class="flex items-start space-x-3 flex-1">
                                            <!-- Sender Avatar -->
                                            @if($message->sender->profile && $message->sender->profile->profile_photo)
                                                <img src="{{ asset('storage/' . $message->sender->profile->profile_photo) }}" 
                                                     alt="{{ $message->sender->name }}" 
                                                     class="w-10 h-10 rounded-full object-cover">
                                            @else
                                                <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center">
                                                    <span class="text-primary-600 font-bold">
                                                        {{ strtoupper(substr($message->sender->name, 0, 1)) }}
                                                    </span>
                                                </div>
                                            @endif

                                            <div class="flex-1">
                                                <div class="flex items-center space-x-2">
                                                    <a href="{{ route('profile.show', $message->sender->profile->username) }}" 
                                                       class="font-semibold text-gray-900 hover:text-primary">
                                                        {{ $message->sender->name }}
                                                    </a>
                                                    <span class="text-sm text-gray-500">{{ '@' . $message->sender->profile->username }}</span>
                                                    <span class="text-sm text-gray-400">•</span>
                                                    <span class="text-sm text-gray-400">{{ $message->created_at->diffForHumans() }}</span>
                                                </div>
                                                <p class="text-gray-700 mt-1 whitespace-pre-line">{{ $message->message }}</p>
                                            </div>
                                        </div>

                                        <!-- Delete Button -->
                                        @auth
                                            @if(auth()->id() === $message->sender_id || auth()->id() === $message->receiver_id || auth()->user()->isAdmin())
                                                <form action="{{ route('profile.messages.destroy', $message) }}" method="POST" 
                                                      onsubmit="return confirm('Weet je zeker dat je dit bericht wilt verwijderen?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                                                        Verwijderen
                                                    </button>
                                                </form>
                                            @endif
                                        @endauth
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8 text-gray-500">
                                    <p>Nog geen berichten op dit profiel.</p>
                                    @auth
                                        @if(auth()->id() !== $user->id)
                                            <p class="mt-2">Wees de eerste om een bericht achter te laten!</p>
                                        @endif
                                    @endauth
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
