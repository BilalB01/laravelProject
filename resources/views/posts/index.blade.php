<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Community
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Create Post Form (alleen voor ingelogde gebruikers) -->
            @auth
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Deel iets met de community</h3>
                        
                        <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-4">
                                <textarea 
                                    name="content" 
                                    rows="4"
                                    class="block w-full border-gray-300 focus:border-primary focus:ring-primary rounded-md shadow-sm"
                                    placeholder="Waar denk je aan?"
                                    required
                                >{{ old('content') }}</textarea>
                                <x-input-error :messages="$errors->get('content')" class="mt-2" />
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Afbeelding (optioneel)</label>
                                <input 
                                    type="file" 
                                    name="image" 
                                    accept="image/*"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-primary-700"
                                />
                                <x-input-error :messages="$errors->get('image')" class="mt-2" />
                            </div>

                            <div class="flex justify-end">
                                <x-primary-button>
                                    Plaatsen
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded">
                    <a href="{{ route('login') }}" class="font-semibold hover:underline">Log in</a> om een post te plaatsen.
                </div>
            @endauth

            <!-- Posts Feed -->
            <div class="space-y-4">
                @forelse ($posts as $post)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <!-- Post Header -->
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center space-x-3">
                                    @if($post->user->profile && $post->user->profile->profile_photo)
                                        <img src="{{ asset('storage/' . $post->user->profile->profile_photo) }}" alt="{{ $post->user->name }}" class="w-12 h-12 rounded-full object-cover">
                                    @else
                                        <div class="w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center">
                                            <span class="text-primary-600 text-lg font-bold">
                                                {{ strtoupper(substr($post->user->name, 0, 1)) }}
                                            </span>
                                        </div>
                                    @endif
                                    
                                    <div>
                                        <a href="{{ route('profile.show', $post->user->profile->username ?? $post->user->id) }}" class="font-semibold text-gray-900 hover:text-primary">
                                            {{ $post->user->name }}
                                        </a>
                                        @if($post->user->profile)
                                            <p class="text-sm text-gray-500">{{ '@' . $post->user->profile->username }}</p>
                                        @endif
                                        <p class="text-xs text-gray-400">{{ $post->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>

                                <!-- Delete Button -->
                                @auth
                                    @if(auth()->id() === $post->user_id || auth()->user()->isAdmin())
                                        <button 
                                            onclick="deletePost{{ $post->id }}()"
                                            class="text-red-600 hover:text-red-900 text-sm font-semibold"
                                        >
                                            Verwijderen
                                        </button>

                                        <form id="deleteForm{{ $post->id }}" method="POST" action="{{ route('posts.destroy', $post) }}" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                            @if(auth()->user()->isAdmin() && auth()->id() !== $post->user_id)
                                                <input type="hidden" name="delete_reason" id="deleteReason{{ $post->id }}">
                                            @endif
                                        </form>

                                        <script>
                                            function deletePost{{ $post->id }}() {
                                                @if(auth()->user()->isAdmin() && auth()->id() !== $post->user_id)
                                                    const reason = prompt('Waarom verwijder je deze post? De gebruiker ontvangt een email met deze reden:');
                                                    if (reason && reason.trim()) {
                                                        document.getElementById('deleteReason{{ $post->id }}').value = reason;
                                                        document.getElementById('deleteForm{{ $post->id }}').submit();
                                                    }
                                                @else
                                                    if (confirm('Weet je zeker dat je deze post wilt verwijderen?')) {
                                                        document.getElementById('deleteForm{{ $post->id }}').submit();
                                                    }
                                                @endif
                                            }
                                        </script>
                                    @endif
                                @endauth
                            </div>

                            <!-- Post Content -->
                            <div class="mb-4">
                                <p class="text-gray-900 whitespace-pre-line">{{ $post->content }}</p>
                            </div>

                            <!-- Post Image -->
                            @if($post->image_path)
                                <div class="mb-4">
                                    <img src="{{ asset('storage/' . $post->image_path) }}" alt="Post image" class="rounded-lg max-w-full h-auto">
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-center text-gray-500">
                            Nog geen posts. Wees de eerste om iets te delen!
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
