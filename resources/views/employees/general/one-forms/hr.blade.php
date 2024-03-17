<form class="mt-6 border-b-2 border-b-ldark pb-5" method="POST"
    action="{{ route($base_route . '.update.HR', ['id' => $employee['id_empleado'], 'id_employee' => $employee['id_empleado']]) }}">
    @csrf
    @method('PUT')

    <input type="hidden" readonly name="id_terminal_user" value="{{ $employee['id_terminal_user'] }}">
    <input type="hidden" readonly name="id_empresa" value="{{ session('company') }}">
    <input type="hidden" readonly name="id_usuario" value="{{ $employee['id_usuario'] }}">

    <header class="mb-4 flex flex-row gap-5 items-center">
        <h2 class="text-2xl font-semibold">Atributos de Empelado</h2>
        <div>
            <button name="activarBtn" type="button">
                <i class="fa-solid fa-lg fa-pencil"></i>
            </button>

            <button name="enviarBtn" class="me-4 hover:text-success hidden" type="submit">
                <i class="fa-solid fa-floppy-disk fa-lg"></i>
            </button>

            <button class="hover:text-danger hidden" type="button" name="cancelarBtn">
                <i class="fa-solid fa-xmark fa-lg"></i>
            </button>
        </div>
    </header>

    <section class="p-3 flex flex-col gap-2">
        <header class="py-2 text-lg border-b-2"> Informacion Personal </header>
        <section class="sm:grid sm:grid-cols-2 xl:grid-cols-3 md:gap-8 xl:gap-x-20">
            <div class="flex flex-row items-center gap-2 p-2">
                <label class="w-32" for="cumple">Cumpleaños:</label>
                <input type="date" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1"
                    name="cumpleaños" readonly value="{{ $employee['cumpleaños'] }}" id="cumple">
            </div>

            <div class="flex flex-row items-center gap-2 p-2">
                <label class="w-32" for="lugar_natal">Lugar Natal</label>
                <select disabled class="h-10 border-b-2 border-ldark flex-1" id="lugar_natal" name="lugar_natal">
                    <option disabled>-- Seleccione una opción --</option>
                    @foreach (app('estados_mx') as $key => $estado)
                        @if ($employee['lugarNatal'] == $key)
                            <option value="{{ $key }}" selected> {{ $estado }} </option>
                        @else
                            <option value="{{ $key }}"> {{ $estado }} </option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="flex flex-row items-center gap-2 p-2">
                <label class="w-32" for="estado_civil">Estado Civil</label>
                <select disabled class="h-10 border-b-2 border-ldark flex-1" id="estado_civil" name="estado_civil">
                    <option disabled>-- Seleccione una opción --</option>
                    @foreach (app('estados_civiles') as $key => $estado)
                        @if ($employee['estadoCivil'] == $key)
                            <option value="{{ $key }}" selected> {{ $estado }} </option>
                        @else
                            <option value="{{ $key }}"> {{ $estado }} </option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="flex flex-row items-center gap-2 p-2">
                <label class="w-32" for="rfc">RFC:</label>
                <input type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1"
                    name="rfc" readonly value="{{ $employee['rfc'] }}" id="rfc">
            </div>

            <div class="flex flex-row items-center gap-2 p-2">
                <label class="w-32" for="curp">CURP:</label>
                <input type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1"
                    name="curp" readonly value="{{ $employee['curp'] }}" id="curp">
            </div>


            <div class="flex flex-row items-center gap-2 p-2">
                <label class="w-32" for="sexo">Sexo:</label>
                <input type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1"
                    name="sexo" readonly value="{{ $employee['sexo'] }}" id="sexo">
            </div>
        </section>

        <header class="py-2 text-lg border-b-2"> Datos de Contacto </header>
        <section class="sm:grid sm:grid-cols-2 xl:grid-cols-3 md:gap-8 xl:gap-x-20">
            <div class="flex flex-row items-center gap-2 p-2">
                <label class="w-32" for="tel">Telefono:</label>
                <input type="tel" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1"
                    name="teléfono" readonly value="{{ $employee['telefono'] }}" id="tel">
            </div>

            <div class="flex flex-row items-center gap-2 p-2">
                <label class="w-32" for="tel2">Telefono de Respaldo:</label>
                <input type="tel" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1"
                    name="teléfono_respaldo" readonly value="{{ $employee['telefono2'] }}" id="tel2">
            </div>

            <div class="flex flex-row items-center gap-2 p-2">
                <label class="w-32" for="email2">Email de Respaldo:</label>
                <input type="email" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1"
                    name="email_respaldo" readonly value="{{ $employee['email2'] }}" id="email2">
            </div>
        </section>

        <header class="py-2 text-lg border-b-2">Dirección</header>
        <section class="sm:grid sm:grid-cols-2 xl:grid-cols-3 md:gap-8 xl:gap-x-20">
            <div class="flex flex-row items-center gap-2 p-2">
                <label class="w-32" for="calle">Calle:</label>
                <input type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1"
                    name="calle" readonly value="{{ $employee['calle'] }}" id="calle">
            </div>

            <div class="flex flex-row items-center gap-2 p-2">
                <label class="w-32" for="col">Colonia:</label>
                <input type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1"
                    name="colonia" readonly value="{{ $employee['colonia'] }}" id="col">
            </div>

            <div class="flex flex-row items-center gap-2 p-2">
                <label class="w-32" for="poblacion">Población:</label>
                <input type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1"
                    name="población" readonly value="{{ $employee['poblacion'] }}" id="poblacion">
            </div>

            <div class="flex flex-row items-center gap-2 p-2">
                <label class="w-32" for="ciudad">Ciudad:</label>
                <input type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1"
                    name="ciudad" readonly value="{{ $employee['ciudad'] }}" id="ciudad">
            </div>

            <div class="flex flex-row items-center gap-2 p-2">
                <label class="w-32" for="estado">Estado</label>
                <select disabled class="h-10 border-b-2 border-ldark flex-1" id="estado" name="estado">
                    <option disabled>-- Seleccione una opción --</option>
                    @foreach (app('estados_mx') as $key => $estado)
                        @if ($employee['estado'] == $key)
                            <option value="{{ $key }}" selected> {{ $estado }} </option>
                        @else
                            <option value="{{ $key }}"> {{ $estado }} </option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="flex flex-row items-center gap-2 p-2">
                <label class="w-32" for="codigoP">Código Postal:</label>
                <input type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1"
                    name="código_postal" readonly value="{{ $employee['codigoPostal'] }}" id="codigoP">
            </div>
        </section>

        <header class="py-2 text-lg border-b-2">Datos de Emergencia</header>
        <section class="md:grid md:grid-cols-2 xl:grid-cols-3 md:gap-8 xl:gap-x-20">
            <div class="flex flex-row items-center gap-2 p-2">
                <label class="w-32" for="imss">Clave IMSS:</label>
                <input type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1"
                    name="imss" readonly value="{{ $employee['imss'] }}" id="imss">
            </div>

            <div class="flex flex-row items-center gap-2 p-2">
                <label class="w-32" for="fonacot">Fonacot:</label>
                <input type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1"
                    name="fonacot" readonly value="{{ $employee['fonacot'] }}" id="fonacot">
            </div>

            <div class="flex flex-row items-center gap-2 p-2">
                <label class="w-32" for="tipoSangre">Tipo de Sangre:</label>
                <input type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1"
                    name="tipo_de_sangre" readonly value="{{ $employee['tipoSangre'] }}" id="tipoSangre">
            </div>

            <div class="flex flex-row items-center gap-2 p-2">
                <label class="w-32" for="nombreEmergencia">Contacto de Emergencia:</label>
                <input type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1"
                    name="nombre_de_contacto_de_emergencia" readonly value="{{ $employee['nombreEmergencia'] }}"
                    id="nombreEmergencia">
            </div>

            <div class="flex flex-row items-center gap-2 p-2">
                <label class="w-32" for="telEmergencia">Telefono:</label>
                <input type="tel" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1"
                    name="teléfono_del_contacto_de_emergencia" readonly value="{{ $employee['telEmergencia'] }}"
                    id="telEmergencia">
            </div>

            <div class="flex flex-row items-center gap-2 p-2">
                <label class="w-32" for="unidadMedica">Unidad Medica:</label>
                <input type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1"
                    name="unidad_médica" readonly value="{{ $employee['unidadMedica'] }}" id="unidadMedica">
            </div>

            <div class="col-span-2 xl:col-span-3 flex flex-row items-center gap-2 p-2">
                <label class="w-32" for="dirEmergencia">Dirección Emergencia:</label>
                <input type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1"
                    name="dirección_del_contacto_de_emergencia" readonly value="{{ $employee['dirEmergencia'] }}"
                    id="dirEmergencia">
            </div>

            <div class="col-span-2 xl:col-span-3 p-2">
                <label class="w-32 py-2" for="enfermedades">Enfermedades:</label>
                <textarea type="text" class="border-2 border-ldark cursor-default p-1 text-ldark flex-1 w-full h-96 my-2"
                    name="enfermedades" readonly id="enfermedades"> {{ $employee['enfermedades'] }} </textarea>
            </div>
        </section>

        <header class="py-2 text-lg border-b-2">Datos de Empleo</header>
        <section class="md:grid md:grid-cols-2 xl:grid-cols-3 md:gap-8 xl:gap-x-20">
            <div class="flex flex-row items-center gap-2 p-2">
                <label class="w-32" for="id_departamento">Departamento</label>
                <select disabled class="h-10 border-b-2 border-ldark flex-1" id="id_departamento"
                    name="departamento">
                    <option disabled>-- Seleccione una opción --</option>
                    @foreach ($companyInfo['departamentos'] as $departamento)
                        @if ($employee['id_departamento'] == $departamento['id_departamento'])
                            <option value="{{ $departamento['id_departamento'] }}" selected>
                                {{ $departamento['nombre'] }}
                            </option>
                        @break
                    @endif
                @endforeach
            </select>
        </div>

        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="id_puesto">Puesto</label>
            <select disabled class="h-10 border-b-2 border-ldark flex-1" id="id_puesto" name="puesto">
                @foreach ($companyInfo['puestos'] as $puesto)
                    @if ($employee['id_puesto'] == $puesto['id_puesto'])
                        <option value="{{ $puesto['id_puesto'] }}" selected>
                            {{ $puesto['nombre'] }}
                        </option>
                    @break
                @endif
            @endforeach
        </select>
    </div>



    <div class="flex flex-row items-center gap-2 p-2">
        <label class="w-32" for="id_unidad">Unidad</label>
        <select disabled class="h-10 border-b-2 border-ldark flex-1" id="id_unidad" name="unidad">
            @foreach ($companyInfo['unidades'] as $unidad)
                @if ($employee['id_unidad'] == $unidad['id_unidad'])
                    <option value="{{ $unidad['id_unidad'] }}" selected>
                        {{ $unidad['nombre'] }}
                    </option>
                @break
            @endif
        @endforeach
    </select>
</div>

<div class="flex flex-row items-center gap-2 p-2">
    <label class="w-32" for="id_tipo_empleado">Tipo Empleado</label>
    <select disabled class="h-10 border-b-2 border-ldark flex-1" id="id_tipo_empleado"
        name="tipo_de_empleado">
        <option disabled>-- Seleccione una opción --</option>
        @foreach ($companyInfo['tipos_empleados'] as $tipo_empleado)
            <option value="{{ $tipo_empleado['id_tipo_empleado'] }}"
                @if ($employee['id_tipo_empleado'] == $tipo_empleado['id_tipo_empleado']) selected @endif>
                {{ $tipo_empleado['nombre'] }}
            </option>
        @endforeach
    </select>
</div>


<div class="flex flex-row items-center gap-2 p-2">
    <label class="w-32" for="id_horario">Horario</label>
    <select disabled class="h-10 border-b-2 border-ldark flex-1" id="id_horario" name="horario">
        <option disabled>-- Seleccione una opción --</option>
        @foreach ($companyInfo['horarios'] as $horario)
            <option value="{{ $horario['id_horario'] }}"
                @if ($employee['id_horario'] == $horario['id_horario']) selected @endif>
                {{ $horario['descripcion'] }}
            </option>
        @endforeach
    </select>
</div>

<div class="flex flex-row items-center gap-2 p-2">
    <label class="w-32" for="sueldo">Sueldo:</label>
    <input type="number"
        class="border-b-2 border-ldark p-1 text-ldark flex-1 cursor-default pointer-events-none"
        name="sueldo" readonly value="{{ $employee['sueldo'] }}" id="sueldo" step="0.01">
</div>


<div class="flex flex-row items-center gap-2 p-2">
    <label class="w-32" for="contratoInicio">Fecha de Inicio de Contrato:</label>
    <input type="date" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1"
        name="fecha_de_inicio_de_contrato" readonly value="{{ $employee['contratoInicio'] }}"
        id="fecha_de_inicio_de_contrato">
</div>

<div class="flex flex-row items-center gap-2 p-2">
    <label class="w-32" for="contratoFin">Fecha de Fin de Contrato:</label>
    <input type="date" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1"
        name="fecha_de_fin_del_contrato" readonly value="{{ $employee['contratoFin'] }}"
        id="fecha_de_fin_de_contrato">
</div>

<div class="flex flex-row items-center gap-2 p-2">
    <label class="w-32" for="formaPago">Forma de Pago</label>
    <input type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1"
        name="forma_de_pago" readonly value="{{ $employee['formaPago'] }}" id="formaPago">
</div>

<div class="flex flex-row items-center gap-2 p-2">
    <label class="w-32" for="alta">Fecha Alta:</label>
    <input type="date" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1"
        name="fecha_de_alta" readonly value="{{ $employee['alta'] }}" id="alta">
</div>

<div class="flex flex-row items-center gap-2 p-2">
    <label class="w-32" for="altaFiscal">Fecha Alta Fiscal:</label>
    <input type="date" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1"
        name="fecha_de_alta_fiscal" readonly value="{{ $employee['altaFiscal'] }}" id="altaFiscal">
</div>

<div class="flex flex-row items-center gap-2 p-2">
    <label class="w-32" for="pensAlimenticia">Pensión Alimenticia</label>
    <input type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1"
        name="incluye_pensión_alimenticia" readonly value="{{ $employee['pensAlimenticia'] }}"
        id="pensAlimenticia">
</div>
</section>

<header class="py-2 text-lg border-b-2">Datos de Nomina</header>
<section class="md:grid md:grid-cols-2 xl:grid-cols-3 md:gap-8 xl:gap-x-20">
<div class="flex flex-row items-center gap-2 p-2">
    <label class="w-32" for="nomClave">Clave de Nómina:</label>
    <input type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1"
        name="clave_de_nómina" readonly value="{{ $employee['nomClave'] }}" id="nomClave">
</div>
<div class="flex flex-row items-center gap-2 p-2">
    <label class="w-32" for="nomBanco">Bacno de Nómina:</label>
    <input type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1"
        name="banco_de_nómina" readonly value="{{ $employee['nomBanco'] }}" id="nomBanco">
</div>
<div class="flex flex-row items-center gap-2 p-2">
    <label class="w-32" for="nomLocalidad">Localidad de Nómina:</label>
    <input type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1"
        name="localidad_de_nómina" readonly value="{{ $employee['nomLocalidad'] }}" id="nomLocalidad">
</div>

<div class="flex flex-row items-center gap-2 p-2">
    <label class="w-32" for="nomReferencia">Referencia de Nómina:</label>
    <input type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1"
        name="referencia_de_nómina" readonly value="{{ $employee['nomReferencia'] }}"
        id="nomReferencia">
</div>

<div class="flex flex-row items-center gap-2 p-2">
    <label class="w-32" for="nomCuenta">Cuenta de Nómina:</label>
    <input type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1"
        name="cuenta_de_nómina" readonly value="{{ $employee['nomCuenta'] }}" id="nomCuenta">
</div>

</section>

</section>

</form>
