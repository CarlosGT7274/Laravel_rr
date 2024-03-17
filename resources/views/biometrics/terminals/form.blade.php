@extends('layouts.form')

@section('inputs')
    <section class="w-5/6 md:w-2/3 lg:w-5/6 grid lg:grid-cols-2 lg:gap-x-20 gap-y-12">

        <div>
            <label for="poblacion">terminal id:</label>
            <x-input id="tipo" icon="" type="number" step="" max="" min="0" name="terminal_id"
                placeholder="terminal_id" />
        </div>

        <div>
            <label for="poblacion">Número:</label>
            <x-input id="poblacion" icon="" type="number" step="" step='' min='0' max='' name="Número"
                placeholder="numero del terminal" />
        </div>
        <div>
            <label for="tipo">Estado:</label>
            <x-input id="tipo" icon="" type="number" step="" max="1" min="0" name="estado"
            placeholder="Estado" />
        </div>

        <div>
            <label for="poblacion">Nombre:</label>
            <x-input id="poblacion" icon="" type="text" name="Nombre"
                placeholder="Nombre" />
        </div>

        <div>
            <label for="region">Ubicación:</label>
            <x-input id="region" icon="" type="text" name="Ubicación"
                placeholder="Ubicacion" />
        </div>

        <div>
            <label for="region">Tipo de conexión:</label>
            <x-input id="region" icon="" type="number" step="" step='' min='0' max='' name="tipo_de_conexión"
                placeholder="Tipo de conexión" />
        </div>

        <div>
            <label for="pass">Contraseña:</label>
        <x-input id="pass" icon="" type="password" name="contraseña_de_la_terminal"
                placeholder="Contraseña" />
        </div>
        <div>
            <label for="region">Nombre del Dominio:</label>
            <x-input id="region" icon="" type="text" name="Nombre_del_Dominio"
                placeholder="Nombre del Dominio" />
        </div>
        <div>
            <label for="region">Dirección TCP/IP:</label>
            <x-input id="region" icon="" type="text" name="Dirección_tcp_ip"
                placeholder="Dirección TCP/IP" />
        </div>
        <div>
            <label for="region">Puerto:</label>
            <x-input id="region" icon="" type="text" name="Puerto"
                placeholder="Puerto" />
        </div>
        <div>
            <label for="region">Número Serial:</label>
            <x-input id="region" icon="" type="text" name="Número_Serial"
                placeholder="Número Serial" />
        </div>
        <div>
            <label for="region">Tasa de Baudios:</label>
            <x-input id="region" icon="" type="text" name="Tasa_de_Baudios"
                placeholder="Tasa de Baudios de la terminal" />
        </div> 
        <div>
            <label for="region">Tipo:</label>
            <x-input id="region" icon="" type="text" name="Tipo"
                placeholder="Tipo" />
        </div>
        <div>
            <label for="region">Usuarios:</label>
            <x-input id="region" icon="" type="text" name="Usuarios"
                placeholder="Usuarios" />
        </div>

        <div>
            <label for="region">Huella Digital:</label>
            <x-input id="region" icon="" type="text" name="Huella_Digital"
                placeholder="Huella Digital" />
        </div>

        <div>
            <label for="region">Punches:</label>
            <x-input id="region" icon="" type="text" name="Punches"
                placeholder="Punches" />
        </div>
        <div>
            <label for="region">faces:</label>
            <x-input id="region" icon="" type="text" name="Faces"
                placeholder="terminal_faces" />
        </div>
        <div>
            <label for="region">zem:</label>
            <x-input id="region" icon="" type="text" name="Zem"
                placeholder="zem" />
        </div>
        <div>
            <label for="region">kind:</label>
            <x-input id="region" icon="" type="text" name="kind"
                placeholder="terminal_kind" />
        </div>
        <div>
            <label for="region">IsSelect:</label>
            <x-input id="region" icon="" type="text" name="IsSelect"
                placeholder="Esta seleccionado?" />
        </div>
        <div>
            <label for="region">time checked:</label>
            <x-input id="region" icon="" type="text" name="time_checked"
                placeholder="time checked" />
        </div>

        <div>
            <label for="region">last checked:</label>
            <x-input id="region" icon="" type="text" name="last_checked"
                placeholder="last checked" />
        </div>

    </section>
@endsection
