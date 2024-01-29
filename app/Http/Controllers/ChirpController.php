<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Auth;
class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():Response
    {
        // return response("new project using inertia js");
        return Inertia::render('chirps/index',[
            'chirps' => Chirp::with('user:id,name')->latest()->get(),       //This will show all message to all users
            // 'chirps' => Chirp::where('user_id',Auth::user()->id)->with('user:id,name')->latest()->get(),         //this will show only users own message
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);
 
        // return $request;
        // return Auth::user();
        // $request->user()->chirps()->create($validated);

        $abcd = new Chirp;
        $abcd ->user_id = Auth::user()->id;
        $abcd->message = $request->message;
        $abcd->save();
 
        return redirect(route('chirps.index'));

    }

    /**
     * Display the specified resource.
     */
    public function show(Chirp $chirp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp): RedirectResponse
    {
        $validated = $request->validate([
            'message' => 'required'
        ]);

        $updateMessage = Chirp::findOrFail($chirp->id);
        $updateMessage ->message = $request->message;
        $updateMessage -> user_id = Auth::user()->id;
        $updateMessage->save();

        return redirect(route('chirps.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp) : RedirectResponse
    {
        $chirp = Chirp:: findOrFail($chirp->id);
        $chirp->delete();

        return redirect(route('chirps.index'));
    }
}
