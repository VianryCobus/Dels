<?php

namespace App\Http\Controllers;

use App\Elibrary;
use App\Http\Requests\ElibraryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ElibraryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arrstts = [
            '0' => 'Nonactive',
            '1' => 'Active',
        ];
        $elibraries = Elibrary::latest()->paginate(10);
        return view('elibrary.index',compact('elibraries','arrstts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ElibraryRequest $request)
    {
        $attr = $request->all();
        $attr['slug'] = "";
        if($request->file('elibrary')) :
            $elibrary = $request->file('elibrary');
            $elibraryUrl = $elibrary->store('elibrary');
            $attr['slug'] = $elibraryUrl;
        endif;
        $act = Elibrary::create($attr);
        if($act) :
            session()->flash('success','E-Library was created');
        else:
            session()->flash('error','E-Library wasn\'t created');
        endif;

        return redirect('elibraries');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Elibrary  $elibrary
     * @return \Illuminate\Http\Response
     */
    public function show(Elibrary $elibrary)
    {
        return $elibrary;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Elibrary  $elibrary
     * @return \Illuminate\Http\Response
     */
    public function edit(Elibrary $elibrary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Elibrary  $elibrary
     * @return \Illuminate\Http\Response
     */
    public function update(ElibraryRequest $request, Elibrary $elibrary)
    {
        $attr = $request->all();
        $attr['slug'] = $elibrary->slug;
        if($request->file('elibrary')) :
            Storage::delete($elibrary->slug);
            $elibraryfile = $request->file('elibrary');
            $elibraryUrl = $elibraryfile->store('elibrary');
            $attr['slug'] = $elibraryUrl;
        endif;
        $act = $elibrary->update($attr);
        if($act) :
            session()->flash('success','E-Library was updated');
        else:
            session()->flash('error','E-Library wasn\'t updated');
        endif;

        return redirect('elibraries');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Elibrary  $elibrary
     * @return \Illuminate\Http\Response
     */
    public function destroy(Elibrary $elibrary)
    {
        Storage::delete($elibrary->slug);
        $act = $elibrary->delete();
        if($act) :
            session()->flash('success', 'The E-Library Was Deleted');
        else :
            session()->flash('error','E-Library Wasn\'t Deleted');
        endif;

        return redirect('elibraries');
    }

    public function downloadelibrary(Elibrary $elibrary){
        return Storage::download($elibrary->slug);
    }

    public function dashboard()
    {
        $elibraries = Elibrary::where('status',1)->get();
        return view('elibrary.dashboard',compact('elibraries'));
    }

    public function pdfStream(Elibrary $elibrary){
        // return PDF::stream($elibrary->slug);
    }
}
