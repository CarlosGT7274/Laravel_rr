@extends('layouts.simple')

@section('content')
    <div style="text-align: center; color: black">
        <h2> HR Control System Xube </h2>
        <div
            style="
                min-width: 300px;
                max-width: 700px;
                margin: auto;
            ">
            <div style="color: black">
                <h3 style="text-align: left;">Atención!</h3>
                <p style="text-align: left;">Estás recibiendo este correo porque recibimos una solicitud de cambio de
                    contraseña para su cuenta.</p>
                <p style="text-align: left;">Si usted No solicitó este cambio ignore este correo. De lo contrario haga click
                    en el siguiente botón.</p>

                <div style="
                        margin: 30px;
                        ">
                    <a href="{{ $url }}?token={{ $token }}"
                        style="
                            text-decoration: none;
                            border-radius: 5px;
                            padding: 8px;
                            color: white;
                            background-color: rgba(94, 94, 94, 0.6);
                            
                        ">
                        Cambiar Contraseña
                    </a>
                </div>

                <h4 style="text-align: left;">Atte. HR Control System Xube</h4>
            </div>
            <div style="
                    border-top: 2px solid rgba(94, 94, 94, 0.4);
                ">
                <p style="text-align: left;"> En caso de que haya algún problema con el botón de "Cambiar Contraseña" puede
                    usar el siguiente Link:
                    <a
                        href="{{ $url }}?token={{ $token }}">{{ $url }}?token={{ $token }}</a>
                </p>
            </div>
        </div>
    </div>
@endsection
