<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nieuwe FAQ
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.faqs.store') }}">
                        @csrf

                        <!-- Category -->
                        <div>
                            <x-input-label for="category_id" value="Categorie" />
                            <select id="category_id" name="category_id" class="block mt-1 w-full border-gray-300 focus:border-primary focus:ring-primary rounded-md shadow-sm" required>
                                <option value="">Selecteer een categorie</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                        </div>

                        <!-- Question -->
                        <div class="mt-6">
                            <x-input-label for="question" value="Vraag" />
                            <x-text-input id="question" class="block mt-1 w-full" type="text" name="question" :value="old('question')" required autofocus />
                            <x-input-error :messages="$errors->get('question')" class="mt-2" />
                        </div>

                        <!-- Answer -->
                        <div class="mt-6">
                            <x-input-label for="answer" value="Antwoord" />
                            <textarea 
                                id="answer" 
                                name="answer" 
                                rows="6"
                                class="block mt-1 w-full border-gray-300 focus:border-primary focus:ring-primary rounded-md shadow-sm"
                                required
                            >{{ old('answer') }}</textarea>
                            <x-input-error :messages="$errors->get('answer')" class="mt-2" />
                        </div>

                        <!-- Order -->
                        <div class="mt-6">
                            <x-input-label for="order" value="Volgorde" />
                            <x-text-input id="order" class="block mt-1 w-full" type="number" name="order" :value="old('order', 0)" required />
                            <x-input-error :messages="$errors->get('order')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500">Lagere nummers verschijnen eerst binnen de categorie.</p>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.faqs.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
                                Annuleren
                            </a>
                            <x-primary-button>
                                Opslaan
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
