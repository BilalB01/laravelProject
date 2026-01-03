<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Veelgestelde Vragen (FAQ)
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @forelse ($categories as $category)
                @if($category->faqs->count() > 0)
                    <div class="mb-8">
                        <h3 class="text-2xl font-bold text-primary mb-4">{{ $category->name }}</h3>
                        
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                            @foreach($category->faqs as $index => $faq)
                                <div class="border-b border-gray-200 last:border-b-0">
                                    <button 
                                        class="w-full text-left px-6 py-4 hover:bg-gray-50 transition focus:outline-none focus:bg-gray-50"
                                        onclick="toggleFaq('faq-{{ $category->id }}-{{ $faq->id }}')"
                                    >
                                        <div class="flex justify-between items-center">
                                            <span class="font-semibold text-gray-900">{{ $faq->question }}</span>
                                            <svg class="w-5 h-5 text-primary transform transition-transform" id="icon-faq-{{ $category->id }}-{{ $faq->id }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                    </button>
                                    <div id="faq-{{ $category->id }}-{{ $faq->id }}" class="hidden px-6 pb-4 text-gray-700">
                                        <p class="whitespace-pre-line">{{ $faq->answer }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @empty
                <div class="bg-white rounded-lg shadow-sm p-8 text-center">
                    <p class="text-gray-500 text-lg">Geen FAQ's beschikbaar.</p>
                </div>
            @endforelse
        </div>
    </div>

    <script>
        function toggleFaq(id) {
            const content = document.getElementById(id);
            const icon = document.getElementById('icon-' + id);
            
            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            } else {
                content.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
            }
        }
    </script>
</x-app-layout>
