<?php

namespace App\Jobs;

use App\Mail\SendWelcomeEmail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class JobSendWelcomeEmail implements ShouldQueue
{
    use Queueable;

    /**
     * Criar uma nova instância.
     * 
     * @param int $userId
     */
    public function __construct(public $userId)
    {
        //
    }

    /**
     * Executar o job.
     * 
     * @return void
     */
    public function handle(): void
    {
        //Recuperar dados usuario

        $user = User::find($this->userId);

        //Enviar email de boas vindas
        Mail::to($user->email)->later(now()->addMinute(), new SendWelcomeEmail($user));
        
    }
}
