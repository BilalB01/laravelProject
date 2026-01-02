<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Profiel Bewerken
            </h2>
            <a href="{{ route('profile.show', $profile->username) }}" class="text-gray-600 hover:text-gray-900">
                Bekijk Profiel
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('profile.page.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <!-- Profile Photo -->
                        <div class="mb-6">
                            <x-input-label for="profile_photo" value="Profielfoto" />
                            @if($profile->profile_photo)
                                <div class="mt-2 mb-4">
                                    <img src="{{ asset('storage/' . $profile->profile_photo) }}" alt="Current Profile Photo" class="w-20 h-20 rounded-full object-cover border border-gray-200">
                                </div>
                            @endif
                            <input id="profile_photo" name="profile_photo" type="file" class="block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-primary-50 file:text-primary-700
                                hover:file:bg-primary-100" />
                            <x-input-error :messages="$errors->get('profile_photo')" class="mt-2" />
                        </div>

                        <!-- Name -->
                        <div class="mb-4">
                            <x-input-label for="name" value="Naam" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $user->name)" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Username -->
                        <div>
                            <x-input-label for="username" value="Gebruikersnaam" />
                            <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username', $profile->username)" required autofocus />
                            <x-input-error :messages="$errors->get('username')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500">Dit is je publieke gebruikersnaam die anderen zien.</p>
                        </div>

                        <!-- Birthday -->
                        <div class="mt-6">
                            <x-input-label for="birthday" value="Geboortedatum" />
                            <x-text-input id="birthday" class="block mt-1 w-full" type="date" name="birthday" :value="old('birthday', $profile->birthday ? $profile->birthday->format('Y-m-d') : '')" />
                            <x-input-error :messages="$errors->get('birthday')" class="mt-2" />
                        </div>

                        <!-- About Me -->
                        <div class="mt-6">
                            <x-input-label for="about_me" value="Over Mij" />
                            <textarea 
                                id="about_me" 
                                name="about_me" 
                                rows="6"
                                class="block mt-1 w-full border-gray-300 focus:border-primary focus:ring-primary rounded-md shadow-sm"
                            >{{ old('about_me', $profile->about_me) }}</textarea>
                            <x-input-error :messages="$errors->get('about_me')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500">Vertel iets over jezelf (maximaal 1000 karakters).</p>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('profile.show', $profile->username) }}" class="text-gray-600 hover:text-gray-900 mr-4">
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
