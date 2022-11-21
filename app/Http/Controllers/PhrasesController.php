<?php

namespace App\Http\Controllers;

use Error;
use App\Models\Phrases;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\PhrasesResource;

class PhrasesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAll()
    {
        $phrases = Phrases::all();
        return PhrasesResource::collection($phrases);
    }
    public function showThis($id)
    {
        $phrases = Phrases::find($id);
        if(!$phrases) throw new Error("This phrase does not exist");
        return new PhrasesResource($phrases);
    }
    public function showMine()
    {
        $id=Auth::id();
        $phrases = Phrases::where('created_by', $id)->get();
        return PhrasesResource::collection($phrases);
    }

    public function showMineId($id)
    {
        $userID= Auth::id();
        $phrases = Phrases::find($id);
        if(!$phrases) throw new Error("This phrase does not exist");
        if(!$phrases::where('created_by', $userID)->get()) throw new Error("This phrase has not been posted by you");
        return new PhrasesResource($phrases);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request -> validate([
            'description' => 'required',
        ]);
        $phrases= new Phrases;
        $phrases->description =$request->description;
        $phrases->created_by = $id  = Auth::id();
        $phrases -> save();
        return new PhrasesResource($phrases);
    }
    public function edit(Request $request, $id){
        $userID=Auth::id();
        $phrases =Phrases::find($id);
        if(!$phrases) throw new Error("This phrase does not exist");
        if(!$phrases::where('created_by', $userID)->get()) throw new Error("This phrase has not been posted by you");
        $phrases->description =$request->description;
        $phrases->created_by = $id  = Auth::id();
        $phrases -> save();
        return new PhrasesResource($phrases);
    }

    public function delete($id){
        $userID=Auth::id();
        $phrases =Phrases::find($id);
        if(!$phrases) throw new Error("This phrase does not exist");
        if(!$phrases::where('created_by', $userID)->get()) throw new Error("This phrase has not been posted by you");
        $phrases-> delete();
        return "Phrase has been deleted";
    }

}
