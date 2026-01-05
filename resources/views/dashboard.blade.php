<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ auth()->user()->isAdmin() ? __('Dashboard') : __('Home') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Admin Statistics (alleen voor admins) -->
            @if($stats)
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Overzicht</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                        <!-- Users Card -->
                        <a href="{{ route('admin.users.index') }}" class="bg-white rounded-lg shadow-md border border-gray-100 p-4 hover:shadow-lg transition">
                            <p class="text-2xl font-bold text-gray-900 mb-1">{{ $stats['users'] }}</p>
                            <p class="text-sm text-gray-500">Gebruikers</p>
                            <p class="text-xs text-gray-400 mt-1">{{ $stats['admins'] }} admins</p>
                        </a>

                        <!-- News Card -->
                        <a href="{{ route('admin.news.index') }}" class="bg-white rounded-lg shadow-md border border-gray-100 p-4 hover:shadow-lg transition">
                            <p class="text-2xl font-bold text-gray-900 mb-1">{{ $stats['news'] }}</p>
                            <p class="text-sm text-gray-500">Nieuwsartikelen</p>
                        </a>

                        <!-- Posts Card -->
                        <div class="bg-white rounded-lg shadow-md border border-gray-100 p-4">
                            <p class="text-2xl font-bold text-gray-900 mb-1">{{ $stats['posts'] }}</p>
                            <p class="text-sm text-gray-500">Community Posts</p>
                        </div>

                        <!-- FAQs Card -->
                        <a href="{{ route('admin.faq-categories.index') }}" class="bg-white rounded-lg shadow-md border border-gray-100 p-4 hover:shadow-lg transition">
                            <p class="text-2xl font-bold text-gray-900 mb-1">{{ $stats['faqs'] }}</p>
                            <p class="text-sm text-gray-500">FAQ Items</p>
                        </a>

                        <!-- Contacts Card -->
                        <a href="{{ route('admin.contact.index') }}" class="bg-white rounded-lg shadow-md border border-gray-100 p-4 hover:shadow-lg transition">
                            <p class="text-2xl font-bold text-gray-900 mb-1">{{ $stats['contacts'] }}</p>
                            <p class="text-sm text-gray-500">Contact Berichten</p>
                        </a>
                    </div>
                </div>
            @endif
            <!-- News and Community Feed -->
            <div class="grid md:grid-cols-2 gap-8">
                <!-- Latest News -->
                <div>
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Laatste Nieuws</h2>
                        <a href="{{ route('news.index') }}" class="text-primary hover:text-primary-700 font-semibold">Alles bekijken →</a>
                    </div>
                    
                    <div class="space-y-4">
                        @forelse($news as $item)
                            <div class="bg-white rounded-lg shadow-md border border-gray-100 overflow-hidden hover:shadow-lg transition">
                                @if($item->image_path)
                                    <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->title }}" class="w-full h-48 object-cover">
                                @endif
                                <div class="p-4">
                                    <h3 class="font-bold text-lg text-gray-900 mb-2">{{ $item->title }}</h3>
                                    <p class="text-sm text-gray-500 mb-2">{{ $item->published_at->format('d F Y') }}</p>
                                    <p class="text-gray-600 mb-3">{{ Str::limit($item->content, 100) }}</p>
                                    <a href="{{ route('news.show', $item) }}" class="text-primary hover:text-primary-700 font-semibold text-sm">
                                        Lees meer →
                                    </a>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-8">Nog geen nieuwsartikelen.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Latest Community Posts -->
                <div>
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Community Posts</h2>
                        <a href="{{ route('posts.index') }}" class="text-primary hover:text-primary-700 font-semibold">Alles bekijken →</a>
                    </div>
                    
                    <div class="space-y-4">
                        @forelse($posts as $post)
                            <div class="bg-white rounded-lg shadow-md border border-gray-100 p-4 hover:shadow-lg transition">
                                <div class="flex items-start space-x-3 mb-3">
                                    @if($post->user->profile && $post->user->profile->profile_photo)
                                        <img src="{{ asset('storage/' . $post->user->profile->profile_photo) }}" alt="{{ $post->user->name }}" class="w-10 h-10 rounded-full object-cover">
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center">
                                            <span class="text-primary-600 font-bold">
                                                {{ strtoupper(substr($post->user->name, 0, 1)) }}
                                            </span>
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <span class="font-semibold text-gray-900">{{ $post->user->name }}</span>
                                            <span class="text-xs text-gray-400">{{ $post->created_at->diffForHumans() }}</span>
                                        </div>
                                        @if($post->user->profile)
                                            <span class="text-sm text-gray-500">{{ '@' . $post->user->profile->username }}</span>
                                        @endif
                                    </div>
                                </div>
                                <p class="text-gray-700 mb-2">{{ Str::limit($post->content, 150) }}</p>
                                @if($post->image_path)
                                    <img src="{{ asset('storage/' . $post->image_path) }}" alt="Post image" class="rounded-lg w-full h-48 object-cover mb-2">
                                @endif
                                <a href="{{ route('posts.index') }}" class="text-primary hover:text-primary-700 font-semibold text-sm">
                                    Bekijk in Community →
                                </a>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-8">Nog geen community posts.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
