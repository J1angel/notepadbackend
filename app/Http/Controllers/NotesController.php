<?php

namespace App\Http\Controllers;


use App\Http\Requests\NotesRequest;
use App\Http\Resources\NotesResource;
use App\Models\Notes;
use Illuminate\Http\Request;

class NotesController extends Controller
{
    public function addNote(NotesRequest $request){
        try {
            $validated = $request->validated();
            Notes::create([
                'title' => $validated['title'],
                'notes' => $request->notes,
            ]);

            return response()->json([
               'message' => 'Successfully saved.'
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function getNotes(){
        return new NotesResource(Notes::select('id','title','notes')->latest()->get());
    }

    public function updateNote(Request $request, $id){
        Notes::find($id)->update([
            'notes' => $request->notes,
        ]);
        return response()->json(['success'=>'Notes updated successfully!']);
    }


}
