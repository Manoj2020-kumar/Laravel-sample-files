<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Question;
use App\Indicator;
use App\Category;
use App\Qlist;
use App\Equivalent;
use App\Language;

use Carbon\Carbon;

class QuestionController extends Controller
{
    //
    public function __construct() {
        $this->middleware(['canViewQs', 'clearance']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index() { 
        $questions = Question::all();

        return view('questions.index', compact('questions'));
    }

        /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $equivalents = Equivalent::all();
        $languages = Language::all();

        return view('questions.create', compact('equivalents', 'languages'));
    }
        /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $question = Question::findOrFail($id); //Find Qlist of id = $id
        $equivalents = Equivalent::all();

        return view ('questions.show', compact('question', 'equivalents'));
    }

        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Question $question)
    {
        //return 'in store';
        
        $this->validate(request(), [
            'text' => "required|min:2",
            'language_id' => "required",
         ]);


        $question = new Question([
            'danger_response' => request()->get('danger_response'),
            'text' => request()->get('text'),
            'created_at' => Carbon::now(),
            ]);
        $question->save();
        $question->addTranslation(request()->get('text'), null, request()->get('language_id'));
        
        $equivalents= request()->get('equivalent_id');
        foreach ($equivalents as $e){
            $equiv = Equivalent::find($e);
            $equiv->questions()->attach($question->id);
        }

        return redirect('/questions/');
    }

        /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        if (isset($_POST['update']))
        {
            $question->text = $request->text;
            
            if ($request->has('danger_response')) $question->danger_response=$request->danger_response;
            
            $question->save();

            $equivalents= request()->get('equivalent_id');
            $question->updateEquivalents($equivalents);
            return redirect('/questions');
        }       
    }

}
