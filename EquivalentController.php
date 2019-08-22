<?php

namespace App\Http\Controllers;

use App\Equivalent;
use App\Category;
use App\Subcategory;
use App\Indicator;
use App\Weight;
use App\Question;
use App\Qlist;
use Illuminate\Http\Request;

class EquivalentController extends Controller
{

    public function __construct() {
        $this->middleware(['auth', 'clearance']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Qlist $qlist)
    {
        //
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $indicators = Indicator::all();
        $weights = Weight::all();
        $questions = Question::all();

        return view('equivalents.create', compact('qlist', 'categories', 'subcategories', 'weights', 'indicators', 'questions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Qlist $qlist)
    {
        $cat = $request['category'];
        $sub = $request['subcategory'];
        $wgt = $request['weight'];
        $ind = $request['indicator'];
        $quests = $request['quests'];

        $e = Equivalent::create([
            'category_id' => $cat,
            'subcategory_id' => $sub,
            'indicator_id' => $ind,
            'weight_id' => $wgt,
        ]);

        if (count($quests) >0) $e->questions()->attach($quests);
        
        $e->save();
        $qlist->equivalents()->attach($e);

        return redirect()->back()->with('flash_message',  __('permissions.qlist_added'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Equivalent  $equivalent
     * @return \Illuminate\Http\Response
     */
    public function show(Qlist $qlist, Equivalent $equiv)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Equivalent  $equivalent
     * @return \Illuminate\Http\Response
     */
    public function edit(Qlist $qlist, Equivalent $equiv)
    {
        //

        $categories = Category::all();
        $subcategories = Subcategory::all();
        $indicators = Indicator::all();
        $weights = Weight::all();
        $questions = Question::all();

        return view('equivalents.create', compact('equiv', 'qlist', 'categories', 'subcategories', 'weights', 'indicators', 'questions'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Equivalent  $equivalent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Qlist $qlist, Equivalent $equivalent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Equivalent  $equivalent
     * @return \Illuminate\Http\Response
     */
    public function destroy(Equivalent $equivalent)
    {
        //
    }
}
