<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('View samples') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-3">
                {{ $samples->links() }}
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="border-collapse table-auto w-full text-sm">
                        <thead>
                        <tr>
                            <th class="border-b font-semibold p-4 pl-8 pt-0 pb-3 text-left">id</th>
                            <th class="border-b font-semibold p-4 pl-8 pt-0 pb-3 text-left">test type</th>
                            <th class="border-b font-semibold p-4 pl-8 pt-0 pb-3 text-left">test card</th>
                            <th class="border-b font-semibold p-4 pl-8 pt-0 pb-3 text-left">result</th>
                            <th class="border-b font-semibold p-4 pl-8 pt-0 pb-3 text-left">readings</th>
                            <th class="border-b font-semibold p-4 pl-8 pt-0 pb-3 text-left">analysis</th>
                            <th class="border-b font-semibold p-4 pl-8 pt-0 pb-3 text-left">uploaded by</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($samples as $sample)
                            <tr>
                                <td class="border-b border-slate-100 p-4 pl-8">{{ $sample->id }}</td>
                                <td class="border-b border-slate-100 p-4 pl-8">{{ $sample->test->type }}</td>
                                <td class="border-b border-slate-100 p-4 pl-8"><a href="{{ asset('storage/' . $sample->test_strip) }}" target="_blank" title="test strip image" class="underline text-blue-600 hover:text-blue-800 visited:text-purple-600">view image</a></td>
                                <td class="border-b border-slate-100 p-4 pl-8">{{ $sample->result }}</td>
                                <td class="border-b border-slate-100 p-4 pl-8">
                                    <div>{{ $sample->reading_one_name }}: {{ $sample->reading_one_value }}</div>
                                    <div>{{ $sample->reading_two_name }}: {{ $sample->reading_two_value }}</div>
                                </td>
                                <td class="border-b border-slate-100 p-4 pl-8">{{ $sample->analysis_failed ? 'Failed' : 'Successful' }}</td>
                                <td class="border-b border-slate-100 p-4 pl-8">
                                    {{ $sample->user->name }}
                                    <div class="text-gray-500">{{ $sample->created_at->diffForHumans(['short' => true]) }}</div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">There are no samples available.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mt-3">
                {{ $samples->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
