<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nieuwsitem Bewerken
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.news.update', $news) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <!-- Title -->
                        <div>
                            <x-input-label for="title" value="Titel" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $news->title)" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Current Image -->
                        @if($news->image_path)
                            <div class="mt-6">
                                <x-input-label value="Huidige Afbeelding" />
                                <img src="{{ asset('storage/' . $news->image_path) }}" alt="{{ $news->title }}" class="mt-2 w-48 h-32 object-cover rounded">
                            </div>
                        @endif

                        <!-- Image -->
                        <div class="mt-6">
                            <x-input-label for="image" value="Nieuwe Afbeelding (optioneel)" />
                            <input id="image" name="image" type="file" class="block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-primary-50 file:text-primary-700
                                hover:file:bg-primary-100" />
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>

                        <!-- Published At -->
                        <div class="mt-6">
                            <x-input-label for="published_at" value="Publicatiedatum" />
                            <x-text-input id="published_at" class="block mt-1 w-full" type="datetime-local" name="published_at" :value="old('published_at', $news->published_at->format('Y-m-d\TH:i'))" required />
                            <x-input-error :messages="$errors->get('published_at')" class="mt-2" />
                        </div>

                        <!-- Content -->
                        <div class="mt-6">
                            <x-input-label for="content" value="Content" />
                            <textarea 
                                id="content" 
                                name="content" 
                                rows="10"
                                class="block mt-1 w-full border-gray-300 focus:border-primary focus:ring-primary rounded-md shadow-sm"
                                required
                            >{{ old('content', $news->content) }}</textarea>
                            <x-input-error :messages="$errors->get('content')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.news.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
                                Annuleren
                            </a>
                            <x-primary-button>
                                Bijwerken
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
