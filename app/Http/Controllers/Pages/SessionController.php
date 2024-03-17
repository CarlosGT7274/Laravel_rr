<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SessionController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function login()
    {
        session(['token' => '']);

        $data = [
            'pageTitle' => 'Login',
            'message' =>  ''
        ];

        return view('forms.login', $data);
    }

    public function submit(Request $request)
    {
        $request->validate([
            'correo' => 'required | email',
            'contraseña' => 'required | string',
        ]);

        $response = $this->apiRequest('login', 'POST', [
            'email' => $request->correo,
            'password' => $request->contraseña,
        ]);

        if ($response['error']) {
            return view('forms.login', [
                'pageTitle' => 'Login',
                'message' =>  $response['mensaje']
            ]);
        } else {
            session(['token' => $response['data']['token']]);
            session(['user' => $response['data']['usuario']]);
            session(['company' => $response['data']['empresa']]);
            session(['permissions' => $response['data']['permisos']]);
            return redirect()->route('home');
        }
    }

    public function getEmail()
    {
        $data = [
            'pageTitle' => 'Restablecer Contraseña',
            'message' =>  ''
        ];

        return view('forms.resetPassword', $data);
    }

    public function sendToken(Request $request)
    {
        $request->validate([
            'correo' => 'required | email',
        ]);

        $response = $this->apiRequest('resetToken', 'GET', [
            'email' => $request->correo,
        ]);

        if ($response['code'] == 200) {
            $data = [
                'pageTitle' => 'Email Enviado',
                'message' => '¡Email enviado correctamente!',
                'submessage' => 'Se ha enviado un email a su correo con indicaciones para realizar el cambio de contraseña'
            ];

            return view('forms.successMessage', $data);
        } else {
            $data = [
                'pageTitle' => 'Restablecer Contraseña',
                'message' =>  $response['mensaje']
            ];

            return view('forms.resetPassword', $data);
        }
    }

    public function changePassword(Request $request)
    {
        $data = [
            'pageTitle' => 'Restablecer Contraseña',
            'message' =>  '',
            'token' => $request->token
        ];

        return view('forms.changePassword', $data);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'accessToken' => 'required | string',
            'contraseña' => 'required | string',
            'de_confirmacion' => 'required | string | same:contraseña'
        ]);

        $response = $this->apiRequest('updatePassword', 'PUT', [
            'password' => $request->contraseña,
            'token' => $request->accessToken
        ]);

        if ($response['code'] == 200) {
            $data = [
                'pageTitle' => 'Cambio Exitoso',
                'message' => '¡Contraseña cambiada Correctamente!',
                'submessage' => 'Tu contraseña ha sido cambiada de manera correcta'
            ];

            return view('forms.successMessage', $data);
        } else {
            $data = [
                'pageTitle' => 'Restablecer Contraseña',
                'message' =>  $response['mensaje'],
                'token' => ''
            ];

            return view('forms.changePassword', $data);
        }
    }

    public function logout()
    {
        $this->apiRequest('logout', 'POST', []);

        session()->flush();

        return redirect()->route('login.form');
    }
}
