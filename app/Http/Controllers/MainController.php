<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use App\Services\Operations;
use Illuminate\Http\Request;


class MainController extends Controller
{
    public function index(){

        $id = session('user.id');

        $notes = User::find($id)->notes()->get()->toArray();
        
        return view('home', ['notes' => $notes]);
    }
    public function newNote(){
        //show new note view
        return view('new_note');
    }
    
    public function newNoteSubmit(Request $request){
        //validate request
            $request->validate(
                [
                   'text_title' => ['required', 'min:3', 'max:200'],
                   'text_note' => ['required', 'min:3', 'max:3000']
                ],

                [
                   'text_title.required' => 'O campo é obrigatorio',
                   'text_note.required' => 'O campo é obrigatorio',

                   'text_title.min' => 'O campo deve ter no minimo :min caracteres',
                   'text_title.max' => 'O campo deve ter no maximo :max caracteres',

                   'text_note.min' => 'O campo deve ter no minimo :min caracteres',
                   'text_note.max' => 'O campo deve ter no maximo :max caracteres',

                ]
            );
            echo 'ok';
        //get user id 
        $id = session('user.id');
        // create new note 
        $note = new Note();
        $note->user_id = $id;
        $note->title = $request->text_title;
        $note->text = $request->text_note;
        //saving in database
        $note->save();
        //redirect to home
        return redirect()->route('home');

    }

    public function editNote($id){
        
        $id = Operations::decryptId($id);
        $note = Note::find($id);

        return view('edit_note', ['note' =>$note]);

        
        
    }

        public function editNoteSubmit(Request $request){
        $request->validate(
                [
                   'text_title' => ['required', 'min:3', 'max:200'],
                   'text_note' => ['required', 'min:3', 'max:3000']
                ],

                [
                   'text_title.required' => 'O campo é obrigatorio',
                   'text_note.required' => 'O campo é obrigatorio',

                   'text_title.min' => 'O campo deve ter no minimo :min caracteres',
                   'text_title.max' => 'O campo deve ter no maximo :max caracteres',

                   'text_note.min' => 'O campo deve ter no minimo :min caracteres',
                   'text_note.max' => 'O campo deve ter no maximo :max caracteres',

                ]
            );

           if($request->note_id == null){
            return redirect()->to('home');
           }
        
        $id = Operations::decryptId($request->note_id);

        $note = Note::find($id);

        $note->title = $request->text_title;
        $note->text = $request->text_note;
        //saving in database
        $note->save();
        //redirect to home
        return redirect()->route('home');

     
    }
    public function deleteNote($id){
        
        $id = Operations::decryptId($id);

        $note = Note::find($id);

        return view('delete_note', ['note' => $note]);

        
    }

    public function deleteNoteConfirm($id){

        $id = Operations::decryptId($id);

        $note = Note::find($id);

        $note->delete();

        return redirect()->route('home');

    }


}
