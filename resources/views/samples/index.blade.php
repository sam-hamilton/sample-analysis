<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('View samples') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-5 flex place-content-end">
                <form method="GET" action="{{ request()->url() }}">
                    <label for="type">Test type:</label>
                    <select name="type" id="type" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">All</option>
                        @foreach($filters['types'] as $id => $type)
                            <option value="{{ $id }}" @if(request()->query('type') == $id) selected @endif>{{ $type }}</option>
                        @endforeach
                    </select>

                    <label for="outcome" class="ml-3">Outcome:</label>
                    <select name="outcome" id="outcome" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">All</option>
                        @foreach($filters['outcomes'] as $outcome)
                            <option value="{{ $outcome }}" @if(request()->query('outcome') == $outcome) selected @endif>{{ $outcome }}</option>
                        @endforeach
                    </select>

                    <label for="user" class="ml-3">User:</label>
                    <select name="user" id="user" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">All</option>
                        @foreach($filters['users'] as $id => $user)
                            <option value="{{ $id }}" @if(request()->query('user') == $id) selected @endif>{{ $user }}</option>
                        @endforeach
                    </select>

                    <button type="submit" class="ml-3 mt-5 px-4 py-3 bg-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Filter
                    </button>

                    <a href="{{ route(request()->route()->getName()) }}" class="ml-3 mt-5 px-1 py-3 border border-transparent rounded-md font-semibold text-xs text-red-500 uppercase tracking-widest hover:underline disabled:opacity-25 transition ease-in-out duration-150">Clear filters</a>
                </form>
            </div>
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
                                    @if(! is_null($sample->reading_one_value))
                                        <div>{{ $sample->reading_one_name }}: {{ $sample->reading_one_value }}</div>
                                    @endif
                                    @if(! is_null($sample->reading_two_value))
                                        <div>{{ $sample->reading_two_name }}: {{ $sample->reading_two_value }}</div>
                                    @endif
                                </td>
                                <td class="border-b border-slate-100 p-4 pl-8">
                                    @if(! is_null($sample->analysis_failed))
                                        {{ $sample->analysis_failed ? 'Failed' : 'Successful' }}
                                    @endif
                                </td>
                                <td class="border-b border-slate-100 p-4 pl-8">
                                    {{ $sample->user->name }}
                                    <div class="text-gray-500">{{ $sample->created_at->diffForHumans(['short' => true]) }}</div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">There are no samples available.</td>
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
