<?php

namespace App\Http\Controllers;

use App\Mail\ValidationMailable;
use App\Models\User;
use Illuminate\Auth\Passwords\DatabaseTokenRepository;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class CodeValidationController extends Controller
{
    public static function sendCode(): void
    {
        $permitted_chars = '123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = substr(str_shuffle($permitted_chars), 0, 6);
        Mail::to(session('email'))->send(new ValidationMailable($code));
        session(['code' => Hash::make($code)]);
    }

    public function codeForm()
    {
        return view('sections.codevalidation.form-contents', [
            'tituloPagina' => 'Validación',
            'titulo' => 'Verificación de código',
            'rutaSiguiente' => 'codeValidation.verifyCode',
            'yield' => 'code',
        ]);
    }

    public function verifyCode(Request $request)
    {
        $inputCode = strtoupper(implode("", $request->except('_token')));
        $hashedCode = session('code');
        if (Hash::check($inputCode, $hashedCode)) {
            session()->forget('code');
            if (null !== session('token')) {
                $email = session('email');
                $token = session('token');
                session()->forget(['email','token']);
                return to_route(session('destination'), [
                    'email' => $email,
                    'token' => $token
                ]);
            }
            return to_route(session('destination'));
        }
        return back()->with('errorVerificacion', "El código no coincide");
    }

    public function prueba()
    {
        $tokenRepository = new DatabaseTokenRepository(DB::connection(),new BcryptHasher(), 'password_reset_tokens', 'bcrypt ');

        return $tokenRepository->create(Password::getUser(['email'=>'alejoimbachihoyos@gmail.com']));
    }
}
