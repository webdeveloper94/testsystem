<div>
    {{-- Nothing in the world is as soft and yielding as water. --}}
    <div class="flex justify-between items-center mb-4">
        <div class="flex-1 pr-4">
            <div class="relative">
                <input
                    type="search"
                    wire:model.live="search"
                    class="w-full pl-10 pr-4 py-2 rounded-lg border focus:border-blue-300 focus:outline-none focus:shadow-outline"
                    placeholder="Testlarni qidirish..."
                >
                <div class="absolute top-0 left-0 inline-flex items-center p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400" viewBox="0 0 24 24"
                         stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                         stroke-linejoin="round">
                        <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                        <circle cx="10" cy="10" r="7" />
                        <line x1="21" y1="21" x2="15" y2="15" />
                    </svg>
                </div>
            </div>
        </div>
        <div>
            <a href="{{ route('admin.tests.create') }}"
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Yangi test
            </a>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
            <tr>
                <th wire:click="sortBy('id')" class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                    ID
                    @if ($sortField === 'id')
                        @if ($sortDirection === 'asc')
                            &#8593;
                        @else
                            &#8595;
                        @endif
                    @endif
                </th>
                <th wire:click="sortBy('title')" class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                    Sarlavha
                    @if ($sortField === 'title')
                        @if ($sortDirection === 'asc')
                            &#8593;
                        @else
                            &#8595;
                        @endif
                    @endif
                </th>
                <th wire:click="sortBy('created_at')" class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                    Yaratilgan sana
                    @if ($sortField === 'created_at')
                        @if ($sortDirection === 'asc')
                            &#8593;
                        @else
                            &#8595;
                        @endif
                    @endif
                </th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                    Amallar
                </th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            @foreach($tests as $test)
                <tr>
                    <td class="px-6 py-4 whitespace-no-wrap">
                        {{ $test->id }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $test->title }}
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap">
                        {{ $test->created_at->format('Y-m-d H:i') }}
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap text-right text-sm font-medium">
                        <a href="{{ route('admin.tests.edit', $test) }}" class="text-indigo-600 hover:text-indigo-900">Tahrirlash</a>
                        <button wire:click="delete({{ $test->id }})" class="ml-4 text-red-600 hover:text-red-900">O'chirish</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $tests->links() }}
    </div>
</div>
