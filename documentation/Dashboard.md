## Dashboard

### Método: `GET`

La seccion del dashboard tiene 5 secciones las cuales se detallan a continuación. Todas las url soportan los siguientes parametros con los cuales se puede ir

```json
{
    "date": "Y-m-d",
    "position": *1,
    "department": *1,
    "region": "*una región",
    "unit": *1
}
```

### General `dashboard/general`

#### Respuesta

Regresa la información de lo empleados seleccionados por los parametros recibidos, donde se obtiene el total que se divide en hombres y mujeres, así como la información para el gráfico de edades y de hijos, al final se da en **porcentaje** de capacitación del personal de la empresa

#### Ejemplo de Respuesta

```json
{
    "total": 12,
    "hombres": {
        "total": 4,
        "con_hijos": 1,
        "edades": {
            "<25": 2,
            "25-35": 1,
            "35-49": 0,
            "50+": 1
        }
    },
    "mujeres": {
        "total": 8,
        "con_hijos": 5,
        "edades": {
            "<25": 2,
            "25-35": 3,
            "35-49": 2,
            "50+": 1
        }
    },
    "capacitaciones": 20
}
```

### Asistencias `dashboard/attendance`

#### Respuesta

Las asistencias se retornan por día donde se indica el número de faltas y el número de asistencias tomando en cuenta los dias laborales dados por los detalles del horario del empleado para el número de faltas.

#### Ejemplo de Respuesta

```json
{
    "dates": {
        "2023-09-29": {
            "asistencias": 0,
            "faltas": 0
        },
        "2023-09-28": {
            "asistencias": 0,
            "faltas": 0
        },
        "2023-09-27": {
            "asistencias": 0,
            "faltas": 0
        },
        "2023-09-26": {
            "asistencias": 0,
            "faltas": 0
        },
        "2023-09-25": {
            "asistencias": 0,
            "faltas": 0
        },
        "2023-09-24": {
            "asistencias": 0,
            "faltas": 0
        },
        "2023-09-23": {
            "asistencias": 0,
            "faltas": 0
        }
    }
}
```

### Cumpleaños `dashboard/birthdays`

#### Respuesta

Retorna todos los empleados que cumplan con el mes de la fecha enviada en los parámetros de la petición

#### Ejemplo de Respuesta

```json
[
    {
        "nombre": "Mr.",
        "apellidoP": "Empleado",
        "apellidoM": "1",
        "unidad": "Food Truck",
        "puesto": "Administrado general",
        "cumpleaños": "1998-08-05",
        "telefono": "1234567890",
        "email": "algo@nada.com"
    },
    {
        "nombre": "Mr. ",
        "apellidoP": "Empleado",
        "apellidoM": "3",
        "unidad": "Restaurante",
        "puesto": "Mesero",
        "cumpleaños": "1994-08-23",
        "telefono": "6789012345",
        "email": "nada@otro.com"
    }
]
```

### Salarios `dashboard/salaries`

#### Respuesta

Otorga la información para el gráfico de salarios

#### Ejemplo de Respuesta

```json
{
    "total": 415.5899999999999,
    "puestos": [
        {
            "puesto": "Administrado general",
            "unidad": "Food Truck",
            "empleados": 1,
            "salario": 15.36
        },
        {
            "puesto": "Cocinero",
            "unidad": "Restaurante",
            "empleados": 1,
            "salario": 25.36
        },
        {
            "puesto": "Mesero",
            "unidad": "Restaurante",
            "empleados": 1,
            "salario": 18.65
        }
    ]
}
```

### Rotaciones `dashboard/rotations`

#### Respuesta

El gráfico de rotaciones otorga la información relevante para los gráficos de bajas

**falta la parte de caracterisiticas de baja como Firma de Finiquito, etc**

#### Ejemplo de Respuesta

```json
{
    "total": 5,
    "hombres": 2,
    "mujeres": 3,
    "unidades":[
      {
        "puestos":[
          {
            "total": 1,
            "puesto": 1
          }
        ]
        "motivos":[
          {
            "total": 1,
            "motivo": "Nada"
          }
        ]
      }
    ]
}
```
