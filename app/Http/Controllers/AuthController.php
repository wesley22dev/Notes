<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDOException;
use PhpParser\Node\Stmt\TryCatch;

class AuthController extends Controller
{

    public function login(){

        return view('login');
    }


    public function loginSubmit(Request $request){

            $request->validate(
                [
                   'text_username' => ['required', 'email'],
                   'text_password' => ['required', 'min:6', 'max:16']
                ],

                [
                   'text_username.required' => 'o campo é obrigatorio',
                   'text_username.email' => 'o campo deve ser um email',
                   'text_password.required' => 'o campo é obrigatorio',
                   'text_password.min' => 'o campo deve ter no minimo :min caracteres',
                   'text_password.max' => 'o campo deve ter no maximo :max caracteres',

                ]
            );
      $username = $request->input('text_username'); 
      $password = $request->input('text_password');

        $user = User::where('username', $username)
                -> where('deleted_at', NULL)
                ->first();
            //check if user exist
            if(!$user){
                return redirect()
                ->back()
                ->withInput()
                ->with('loginError', 'Username ou password incorretos.');
            }
            
            //check if password is correct
            if(!password_verify($password, $user->password)){
                    return redirect()
                ->back()
                ->withInput()
                ->with('loginError', 'Username ou password incorretos.');
            };

        //update last login

        $user->last_login = date('Y-m-d H:i:s');
        $user->save();

        //login user
        session([
            'user' => [
                'id' => $user->id,
                'username' => $user->username
            ]
        ]);

        //return to index
        return redirect('/');
    }

    public function createSubmit(Request $request){
        $request->validate(
            [
                'text_username' => ['required', 'email'],
                'text_password' => ['required', 'min:6', 'max:16'],
                'text_password_confirm' => ['required', 'same:text_password']
            ],
            [
                'text_username.required' => 'O campo é obrigatório',
                'text_username.email' => 'O campo deve ser um e-mail válido',
                'text_password.required' => 'O campo é obrigatório',
                'text_password.min' => 'A senha deve ter no mínimo :min caracteres',
                'text_password.max' => 'A senha deve ter no máximo :max caracteres',
                'text_password_confirm.required' => 'Confirme a senha',
                'text_password_confirm.same' => 'As senhas devem coincidir'
            ]
        );

        $username = $request->input('text_username');
        $password = $request->input('text_password');

        $userExists = User::where('username', $username)->first();

        if ($userExists) {
            return redirect()->back()->withInput()->with('loginError', 'Já existe um usuário com esse e-mail.');
        }

        $user = new User();
        $user->username = $username;
        $user->password = bcrypt($password);
        $user->last_login = null; 
        $user->save();

        // Redirect to login page with message
        return redirect('/login')->with('success', 'Usuário criado com sucesso! Faça login para continuar.');
    }
    //just logout
    public function logout(){

        session()->forget('user');
        return redirect('/login');

    }
    //logout with delete message
    public function logout2(){

        session()->forget('user');
        return redirect('/login')->with('delete', 'Usuário removido com sucesso');;

    }
}
