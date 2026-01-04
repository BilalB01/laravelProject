<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Contactbericht Details
            </h2>
            <a href="{{ route('admin.contact.index') }}" class="text-primary hover:text-primary-700">
                &larr; Terug naar overzicht
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Contactbericht Details -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Ontvangen Bericht</h3>

                    <div class="mb-6">
                        <h4 class="text-sm font-medium text-gray-500">Van</h4>
                        <p class="mt-1 text-lg font-semibold text-gray-900">{{ $contactMessage->name }}</p>
                    </div>

                    <div class="mb-6">
                        <h4 class="text-sm font-medium text-gray-500">Email</h4>
                        <p class="mt-1 text-lg">
                            <a href="mailto:{{ $contactMessage->email }}" class="text-primary hover:text-primary-700">
                                {{ $contactMessage->email }}
                            </a>
                        </p>
                    </div>

                    <div class="mb-6">
                        <h4 class="text-sm font-medium text-gray-500">Onderwerp</h4>
                        <p class="mt-1 text-lg font-semibold text-gray-900">{{ $contactMessage->subject }}</p>
                    </div>

                    <div class="mb-6">
                        <h4 class="text-sm font-medium text-gray-500">Bericht</h4>
                        <div class="mt-1 bg-gray-50 p-4 rounded-lg">
                            <p class="text-gray-900 whitespace-pre-line">{{ $contactMessage->message }}</p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h4 class="text-sm font-medium text-gray-500">Ontvangen op</h4>
                        <p class="mt-1 text-gray-700">{{ $contactMessage->created_at->format('d F Y \o\m H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Antwoord Formulier -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Antwoord Versturen</h3>
                    
                    <form method="POST" action="{{ route('admin.contact.reply', $contactMessage) }}">
                        @csrf

                        <div class="mb-6">
                            <x-input-label for="reply_message" value="Je antwoord" />
                            <textarea 
                                id="reply_message" 
                                name="reply_message" 
                                rows="8"
                                class="block mt-1 w-full border-gray-300 focus:border-primary focus:ring-primary rounded-md shadow-sm"
                                required
                                placeholder="Typ hier je antwoord aan {{ $contactMessage->name }}..."
                            >{{ old('reply_message') }}</textarea>
                            <x-input-error :messages="$errors->get('reply_message')" class="mt-2" />
                            <p class="mt-2 text-sm text-gray-500">
                                Dit antwoord wordt verzonden naar: <strong>{{ $contactMessage->email }}</strong>
                            </p>
                        </div>

                        <div class="flex items-center justify-end">
                            <x-primary-button>
                                Verstuur Antwoord
                            </x-primary-button>
                        </div>
                    </form>

                    <!-- Delete Button (separate form) -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <form method="POST" action="{{ route('admin.contact.destroy', $contactMessage) }}" onsubmit="return confirm('Weet je zeker dat je dit bericht wilt verwijderen?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 font-semibold">
                                Bericht verwijderen
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
