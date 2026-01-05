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

            <!-- Comments Section -->
            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">
                        Reacties ({{ $news->comments()->whereNull('parent_id')->count() }})
                    </h3>

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Comment Form (alleen voor ingelogde gebruikers) -->
                    @auth
                        <div class="mb-8 pb-8 border-b border-gray-200">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Plaats een reactie</h4>
                            
                            <form method="POST" action="{{ route('news.comments.store', $news) }}">
                                @csrf

                                <div class="mb-4">
                                    <textarea 
                                        name="comment" 
                                        rows="4"
                                        class="block w-full border-gray-300 focus:border-primary focus:ring-primary rounded-md shadow-sm"
                                        placeholder="Schrijf je reactie..."
                                        required
                                    >{{ old('comment') }}</textarea>
                                    <x-input-error :messages="$errors->get('comment')" class="mt-2" />
                                </div>

                                <div class="flex justify-end">
                                    <x-primary-button>
                                        Plaats reactie
                                    </x-primary-button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded mb-8">
                            <a href="{{ route('login') }}" class="font-semibold hover:underline">Log in</a> om een reactie te plaatsen.
                        </div>
                    @endauth

                    <!-- Comments List (alleen top-level comments) -->
                    <div class="space-y-6">
                        @forelse ($news->comments()->whereNull('parent_id')->latest()->get() as $comment)
                            <div class="comment-thread">
                                <!-- Main Comment -->
                                <div class="flex space-x-4">
                                    <!-- User Avatar -->
                                    <div class="flex-shrink-0">
                                        @if($comment->user->profile && $comment->user->profile->profile_photo)
                                            <img src="{{ asset('storage/' . $comment->user->profile->profile_photo) }}" alt="{{ $comment->user->name }}" class="w-10 h-10 rounded-full object-cover">
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center">
                                                <span class="text-primary-600 font-bold">
                                                    {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Comment Content -->
                                    <div class="flex-1">
                                        <div class="bg-gray-50 rounded-lg p-4">
                                            <div class="flex items-start justify-between mb-2">
                                                <div>
                                                    <span class="font-semibold text-gray-900">{{ $comment->user->name }}</span>
                                                    @if($comment->user->profile)
                                                        <span class="text-sm text-gray-500">{{ '@' . $comment->user->profile->username }}</span>
                                                    @endif
                                                </div>
                                                <span class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p class="text-gray-700 whitespace-pre-line">{{ $comment->comment }}</p>
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="mt-2 flex items-center space-x-4">
                                            @auth
                                                <!-- Reply Button -->
                                                <button 
                                                    onclick="toggleReplyForm({{ $comment->id }})"
                                                    class="text-sm text-primary hover:text-primary-700 font-semibold"
                                                >
                                                    Beantwoorden
                                                </button>

                                                <!-- Delete Button -->
                                                @if(auth()->id() === $comment->user_id || auth()->user()->isAdmin())
                                                    <form method="POST" action="{{ route('news.comments.destroy', $comment) }}" class="inline" onsubmit="return confirm('Weet je zeker dat je deze reactie wilt verwijderen?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-sm text-red-600 hover:text-red-900">
                                                            Verwijderen
                                                        </button>
                                                    </form>
                                                @endif
                                            @endauth

                                            @if($comment->replies->count() > 0)
                                                <span class="text-sm text-gray-500">{{ $comment->replies->count() }} {{ $comment->replies->count() === 1 ? 'antwoord' : 'antwoorden' }}</span>
                                            @endif
                                        </div>

                                        <!-- Reply Form (hidden by default) -->
                                        @auth
                                            <div id="replyForm{{ $comment->id }}" class="mt-4 hidden">
                                                <form method="POST" action="{{ route('news.comments.store', $news) }}" class="bg-gray-50 p-4 rounded-lg">
                                                    @csrf
                                                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                                    
                                                    <textarea 
                                                        name="comment" 
                                                        rows="3"
                                                        class="block w-full border-gray-300 focus:border-primary focus:ring-primary rounded-md shadow-sm mb-3"
                                                        placeholder="Schrijf je antwoord..."
                                                        required
                                                    ></textarea>
                                                    
                                                    <div class="flex justify-end space-x-2">
                                                        <button 
                                                            type="button"
                                                            onclick="toggleReplyForm({{ $comment->id }})"
                                                            class="px-4 py-2 text-sm text-gray-700 hover:text-gray-900"
                                                        >
                                                            Annuleren
                                                        </button>
                                                        <button type="submit" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-700 text-sm">
                                                            Antwoorden
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endauth

                                        <!-- Nested Replies -->
                                        @if($comment->replies->count() > 0)
                                            <div class="mt-4 ml-8 space-y-4 border-l-2 border-gray-200 pl-4">
                                                @foreach($comment->replies as $reply)
                                                    <div class="flex space-x-3">
                                                        <!-- Reply Avatar -->
                                                        <div class="flex-shrink-0">
                                                            @if($reply->user->profile && $reply->user->profile->profile_photo)
                                                                <img src="{{ asset('storage/' . $reply->user->profile->profile_photo) }}" alt="{{ $reply->user->name }}" class="w-8 h-8 rounded-full object-cover">
                                                            @else
                                                                <div class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center">
                                                                    <span class="text-primary-600 text-sm font-bold">
                                                                        {{ strtoupper(substr($reply->user->name, 0, 1)) }}
                                                                    </span>
                                                                </div>
                                                            @endif
                                                        </div>

                                                        <!-- Reply Content -->
                                                        <div class="flex-1">
                                                            <div class="bg-gray-50 rounded-lg p-3">
                                                                <div class="flex items-start justify-between mb-1">
                                                                    <div>
                                                                        <span class="font-semibold text-gray-900 text-sm">{{ $reply->user->name }}</span>
                                                                        @if($reply->user->profile)
                                                                            <span class="text-xs text-gray-500">{{ '@' . $reply->user->profile->username }}</span>
                                                                        @endif
                                                                    </div>
                                                                    <span class="text-xs text-gray-400">{{ $reply->created_at->diffForHumans() }}</span>
                                                                </div>
                                                                <p class="text-gray-700 text-sm whitespace-pre-line">{{ $reply->comment }}</p>
                                                            </div>

                                                            <!-- Delete Reply Button -->
                                                            @auth
                                                                @if(auth()->id() === $reply->user_id || auth()->user()->isAdmin())
                                                                    <form method="POST" action="{{ route('news.comments.destroy', $reply) }}" class="mt-1" onsubmit="return confirm('Weet je zeker dat je dit antwoord wilt verwijderen?');">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="text-xs text-red-600 hover:text-red-900">
                                                                            Verwijderen
                                                                        </button>
                                                                    </form>
                                                                @endif
                                                            @endauth
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-8">Nog geen reacties. Wees de eerste!</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleReplyForm(commentId) {
            const form = document.getElementById('replyForm' + commentId);
            form.classList.toggle('hidden');
        }
    </script>
</x-app-layout>
