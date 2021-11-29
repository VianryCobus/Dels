<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Str;

class CategoryController extends Controller
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
        return view('categories.index', [
            'categories' => Category::latest()->paginate(5),
            'arrstts' => $arrstts
        ]);
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
    public function store(CategoryRequest $request)
    {
        $attr = $request->all();
        $attr['slug'] = Str::slug(request('name'));

        $act = Category::create($attr);
        if($act) :
            session()->flash('success','Training Category was created');
        else:
            session()->flash('error','Training Category wasn\'t created');
        endif;

        return redirect('categories');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return $category;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $attr = $request->all();
        $act = $category->update($attr);

        if($act) : 
            session()->flash('success', 'The Category was Updated');
        else :
            session()->flash('error', 'The Updated action for Category was failed');
        endif;

        // return back();
        return redirect('categories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $act = $category->delete();
        if($act) :
            session()->flash('success', 'The Category Was Deleted');
        else :
            session()->flash('error','Category Wasn\'t Deleted');
        endif;

        return redirect('categories');
    }
}
