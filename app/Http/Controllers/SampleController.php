<?php

namespace App\Http\Controllers;

use App\Analysis\AwsAnalysisService;
use App\Models\Sample;
use App\Models\Test;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class SampleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('samples.index', [
            'samples' => Sample::query()
                ->with(['test', 'user'])
                ->when($request->filled('type'), function($query) use ($request) {
                    return $query->where('test_id', $request->query('type'));
                })
                ->when($request->filled('outcome'), function($query) use ($request) {
                    return $query->where('result', $request->query('outcome'));
                })
                ->when($request->filled('user'), function($query) use ($request) {
                    return $query->where('user_id', $request->query('user'));
                })
                ->orderByDesc('created_at')
                ->paginate('5')
                ->withQueryString(),
            'filters' => [
                'types' => Test::pluck('type', 'id'),
                'outcomes' => Sample::pluck('result' )->unique(),
                'users' => User::pluck('name', 'id')
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('samples.create', [
            'tests' => Test::all()->pluck('type', 'id'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'test_type' => ['required', 'integer', 'exists:App\Models\Test,id'],
            'test_strip' => ['required', 'mimes:jpg,png'],
        ]);

        $test = Test::find($request->input('test_type'));
        $path = $request->file('test_strip')->store($test->type, ['disk' => 'public']);

        $sample = Sample::create([
            'user_id' => auth()->user()->id,
            'test_id' => $request->input('test_type'),
            'test_strip' => $path,
        ]);

        $analysis = (new AwsAnalysisService($sample))->analyse()->save();

        flash()->success('Your sample has been successfully uploaded');

        return redirect()->route('samples.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
