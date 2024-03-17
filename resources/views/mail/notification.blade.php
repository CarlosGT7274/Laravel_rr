<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Notification</title>
        <meta name="description" content="Notificacion de HR Control System XUBE">
        <meta name="author" content="HR Control System XUBE">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body style="text-align: center; color: black" >
        <div 
        style="
                min-width: 300px;
                max-width: 700px;
                margin: auto;
                "
        >
            <h2 style="text-align: left;"> HR Control System Xube </h2>

            <div style="color: black">
                <h3 style="text-align: left;">Atención!</h3>
                <p style="text-align: left;">Estás recibiendo este correo porque recibimos una solicitud de cambio de contraseña para su cuenta.</p>
                <p style="text-align: left;">Si usted No solicitó este cambio ignore este correo. De lo contrario haga click en el siguiente botón.</p>
                <h4 style="text-align: left;">Atte. HR Control System Xube</h4>
            </div>
            <div style=" border-top: 2px solid rgba(94, 94, 94, 0.4);" >
                <p style="text-align: left;"> En caso de que haya algún problema con el botón de "Cambiar Contraseña" puede usar el siguiente Link: 
                    <a href="{{$url}}?token={{$token}}">{{$url}}?token={{$token}}</a>
                </p>
            </div>
        </div>
    </body>
</html>