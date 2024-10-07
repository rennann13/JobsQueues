<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Jobs\JobSendWelcomeEmail;
use App\Mail\SendWelcomeEmail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    // Carregar o formulário cadastrar novo usuário
    public function create(){

        // Carregar VIEW
        return view('users.create');
    }

    public function store(UserRequest $request){
        
        //Validar dados
        $request->validated();

        //Marca o ponto inicial de uma transação
        DB::beginTransaction();

        try{

            // Cadastrar no banco de dados na tabela usuários
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ]);

            //Enviar e-mail
            //Mail::to($user->email)->send(new SendWelcomeEmail($user));

            //Agendar o envio do e-mail no job
            JobSendWelcomeEmail::dispatch($user->id)->onQueue('default');

            //Operação concluida com exito
            DB::commit();

            //Redirecionar o usuário, e enviar mensagem de sucesso.
            return redirect()->route('users.create')->with('success', 'Usuário cadastrado com sucesso!');
            
        } catch (Exception $e){

            // Operacação não foi concluída com êxito
            DB::rollBack();

            // Redirecionar o usuário, enviar mensagem de erro
            return back()->withInput()->with('error', 'Usuário não cadastrado');
        }

    }
}
