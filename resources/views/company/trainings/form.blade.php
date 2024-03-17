@extends('layouts.form')

@section('inputs')
    <section class="w-5/6 md:w-2/3 lg:w-5/6 xl:gap-x-20 gap-y-12">
        <div>
            <label for="name">Nombre</label>
            <x-input id="name" icon="" autocomplete="" type="text" name="nombre"
                placeholder="Nombre de la capacitación" />
        </div>

        <div class="flex flex-col">
            <label for="descripción">Descripción</label>
            <textarea class="my-2 p-3 border-2 border-ldark hover:border-primary resize-none" name="descripción"
                placeholder="Descripción de la capacitación" id="" cols="30" rows="10"></textarea>
        </div>

        @if (!empty($empleados))
            <div>
                <label for="empleados">Empleados</label>
                <div
                    class="mb-1 border-b-2 border-b-ldark flex flex-row gap-2 items-center justify-around hover:border-b-primary p-2">
                    <select class="" id="empleados">
                        @for ($i = 0; $i < count($empleados); $i++)
                            <option value="{{ $i }}">
                                {{ $empleados[$i]['nombre'] . ' ' . $empleados[$i]['apellidoP'] . ' ' . $empleados[$i]['apellidoM'] }}
                            </option>
                        @endfor
                    </select>

                    <button
                        class="border-2 text-primary border-primary rounded-lg p-2 hover:bg-primary hover:text-light font-semibold"
                        type="button" onclick="addUser()">Agregar empleado</button>
                </div>
            </div>

            <section class="grid md:grid-cols-2 xl:grid-cols-4 gap-16" id="empleados_container">
            </section>
        @endif
    </section>

    <script>
        const empleados = @json($empleados);
        let empleadosCap = [];

        function addUser() {
            let select = document.getElementById("empleados")
            let emp_i = select.value

            if (!empleadosCap.includes(emp_i)) {
                const newEmployee = document.createElement("div")
                newEmployee.className = "container";

                const botonEliminar = document.createElement("button");
                botonEliminar.type = 'button';
                botonEliminar.name = emp_i;
                botonEliminar.className = "p-2 border-r-2 h-10 border-ldark"

                const icon = document.createElement("i")
                icon.className = "fa-solid fa-trash text-danger"

                botonEliminar.appendChild(icon)

                botonEliminar.addEventListener("click", function() {
                    const index = empleadosCap.indexOf(botonEliminar.name)
                    empleadosCap.splice(index, 1);
                    newEmployee.remove();
                });

                newEmployee.appendChild(botonEliminar);

                const inputContainer = document.createElement("div");
                inputContainer.className = "employee";

                const label = document.createElement("label")
                label.innerHTML = empleados[emp_i]['nombre'] + ' ' + empleados[emp_i]['apellidoP'] + ' ' + empleados[
                    emp_i]['apellidoM']
                label.className = "font-semibold"
                label.for = `empleados[${empleadosCap.length}][fecha]`

                const inputDate = document.createElement("input")
                inputDate.id = `empleados[${empleadosCap.length}][fecha]`
                inputDate.type = 'date';
                inputDate.name = `empleados[${empleadosCap.length}][fecha]`;
                inputDate.value = new Date().toISOString().split('T')[0];
                inputDate.className = "cursor-pointer"

                var id_employee = document.createElement("input");
                id_employee.type = "hidden";
                id_employee.name = `empleados[${empleadosCap.length}][id_empleado]`;
                id_employee.value = empleados[emp_i]['id_empleado'];

                inputContainer.appendChild(label)
                inputContainer.appendChild(inputDate)
                inputContainer.appendChild(id_employee)

                newEmployee.appendChild(inputContainer)


                document.getElementById("empleados_container").appendChild(newEmployee)

                empleadosCap.push(emp_i);
            }
        }
    </script>
@endsection
