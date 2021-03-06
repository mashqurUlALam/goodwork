<?php

namespace App\Mail;

use App\Models\Token;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class SendInvitationToRegister extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(Request $request)
    {
        $token = hash_hmac('sha256', str_random('40'), env('APP_KEY'));
        Token::create(['token' => $token, 'email' => $request->email]);

        return $this->view('emails.invite')
                    ->subject(Auth::user()->name . ' invited you to join Goodwork')
                    ->with([
                'token' => $token,
                'name' => $request->name
            ]);
    }
}
