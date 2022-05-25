<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Analyse sample') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    @if ($errors->any())
                        <div class="p-5 bg-red-100 border-b border-red-200 text-red-800">
                            <p class="mb-3">You have some errors trying to submit your sample!</p>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    Please provide your sample.

                    <form method="POST" action="{{ route('samples.create') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mt-5">
                            <label for="test_type">Test Type:</label>
                            <select name="test_type" id="test_type" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                <option value="">Please select</option>
                                @foreach($tests as $id => $test)
                                    <option value="{{ $id }}">{{ $test }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-5">
                            <label for="test_strip">Test Strip:</label>
                            <input type="file" id="test_strip" name="test_strip" required>
                        </div>
                        <button type="submit" class="mt-5 px-4 py-2 bg-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Submit
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
