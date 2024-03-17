## Empresas

### Rutas

| Método | Ruta              | Acción                                      |
| ------ | ----------------- | ------------------------------------------- |
| GET    | `/companies`      | Solicitud de todas las empresas registradas |
| GET    | `/companies/{id}` | Solicitud de todas las empresas registradas |
| POST   | `/companies`      | Crear una nueva empresa                     |
| PUT    | `/companies/{id}` | Actualizar una empresa existente            |
| DELETE | `/companies/{id}` | Eliminar una empresa                        |

### Parámetros para actualización y creación

```json
{
    "razonSocial": "Mi Empresa S.A. de C.V.",
    "rfc": "ABCD123456789",
    "giroComercial": "Servicios de Tecnología",
    "contacto": "Juan Pérez",
    "telefono": "1234567890",
    "email": "juan.perez@example.com",
    "fax": "987654321",
    "web": "http://www.miempresa.com",
    "calle": "Calle Principal #123",
    "colonia": "Colonia Centro",
    "poblacion": "Ciudad de Ejemplo",
    "estado": 1,
    "logo": "http://www.miempresa.com/logo.png"
}
```

## Departamentos

### Rutas

| Método | Ruta                                       | Acción                                    |
| ------ | ------------------------------------------ | ----------------------------------------- |
| GET    | `/companies/{id_company}/departments`      | Retorna todos los departamentos           |
| GET    | `/companies/{id_company}/departments/{id}` | Retorna la información de un departamento |
| POST   | `/companies/{id_company}/departments`      | Crea un nuevo departamento                |
| PUT    | `/companies/{id_company}/departments/{id}` | Actualiza un departamento existente       |
| DELETE | `/companies/{id_company}/departments/{id}` | Elimina un departamento                   |

### Parámetros para actualización y creación

```json
{
    "nombre": "Nuevo Departamento"
}
```

## Puestos

### Rutas

| Método | Ruta                                     | Acción                                       |
| ------ | ---------------------------------------- | -------------------------------------------- |
| GET    | `/companies/{id_company}/positions`      | Retorna todos los puestos de la compañía     |
| GET    | `/companies/{id_company}/positions/{id}` | Retorna la información de un puesto          |
| POST   | `/companies/{id_company}/positions`      | Crea un nuevo puesto en la compañía          |
| PUT    | `/companies/{id_company}/positions/{id}` | Actualiza un puesto existente en la compañía |
| DELETE | `/companies/{id_company}/positions/{id}` | Elimina un puesto de la compañía             |

### Parámetros para actualización y creación

```json
{
    "nombre": "Nuevo Puesto",
    "sueldoSug": 2200.0,
    "sueldoMax": 2800.0,
    "riesgo": 1
}
```

## Unidades

### Rutas

| Método | Ruta                                 | Acción                                        |
| ------ | ------------------------------------ | --------------------------------------------- |
| GET    | `/companies/{id_company}/units`      | Retorna todas las unidades de la compañía     |
| GET    | `/companies/{id_company}/units/{id}` | Retorna la información de una unidad          |
| POST   | `/companies/{id_company}/units`      | Crea una nueva unidad en la compañía          |
| PUT    | `/companies/{id_company}/units/{id}` | Actualiza una unidad existente en la compañía |
| DELETE | `/companies/{id_company}/units/{id}` | Elimina una unidad de la compañía             |

### Parámetros para actualización y creación

```json
{
    "nombre": "Nueva Unidad",
    "tipo": "Tipo Nuevo",
    "poblacion": "Nueva Población",
    "estado": 2,
    "region": "Nueva Región"
}
```

## Feriados

### Rutas

| Método | Ruta                                    | Acción                                         |
| ------ | --------------------------------------- | ---------------------------------------------- |
| GET    | `/companies/{id_company}/holidays`      | Retorna todos los días feriados de la compañía |
| GET    | `/companies/{id_company}/holidays/{id}` | Retorna la información de un día feriado       |
| POST   | `/companies/{id_company}/holidays`      | Crea un nuevo día feriado en la compañía       |
| PUT    | `/companies/{id_company}/holidays/{id}` | Actualiza un día feriado existente             |
| DELETE | `/companies/{id_company}/holidays/{id}` | Elimina un día feriado de la compañía          |

### Parámetros para actualización y creación

```json
{
    "nombre": "Nuevo Feriado",
    "tipo": 1,
    "inicio": "2023-12-25",
    "fin": "2023-12-25"
}
```

## Capacitaciones

### Rutas

| Método | Ruta                                     | Acción                                                                    |
| ------ | ---------------------------------------- | ------------------------------------------------------------------------- |
| GET    | `/companies/{id_company}/trainings`      | Retorna todas las capacitaciones de la compañía                           |
| GET    | `/companies/{id_company}/trainings/{id}` | Retorna la información de una capacitación y los empleados que la tomaron |
| POST   | `/companies/{id_company}/trainings`      | Crea una nueva capacitación en la compañía                                |
| PUT    | `/companies/{id_company}/trainings/{id}` | Actualiza una capacitación existente                                      |
| DELETE | `/companies/{id_company}/trainings/{id}` | Elimina una capacitación de la compañía                                   |

### Parámetros para actualización y creación

```json
{
    "nombre": "Nueva Capacitación",
    "descripcion": "Descripción de Nueva Capacitación",
    "empleados": [
        {
            "id_empleado": 1,
            "fecha": "2023-09-29"
        },
        {
            "id_empleado": 2,
            "fecha": "2023-09-29"
        },
        {
            "id_empleado": 3
        }
    ]
}
```

## Tipos de Empleados

### Rutas

| Método | Ruta                                         | Acción                                              |
| ------ | -------------------------------------------- | --------------------------------------------------- |
| GET    | `/companies/{id_company}/employeeTypes`      | Retorna todos los tipos de empleados de la compañía |
| GET    | `/companies/{id_company}/employeeTypes/{id}` | Retorna la información de un tipo de empleado       |
| POST   | `/companies/{id_company}/employeeTypes`      | Crea un nuevo tipo de empleado en la compañía       |
| PUT    | `/companies/{id_company}/employeeTypes/{id}` | Actualiza un tipo de empleado existente             |
| DELETE | `/companies/{id_company}/employeeTypes/{id}` | Elimina un tipo de empleado de la compañía          |

### Parámetros para actualización y creación

```json
{
    "nombre": "Nuevo Tipo de Empleado"
}
```

## Horarios de Trabajo

### Rutas

| Método | Ruta                                     | Acción                                               |
| ------ | ---------------------------------------- | ---------------------------------------------------- |
| GET    | `/companies/{id_company}/schedules`      | Retorna todos los horarios de trabajo de la compañía |
| GET    | `/companies/{id_company}/schedules/{id}` | Retorna la información de un horario de trabajo      |
| POST   | `/companies/{id_company}/schedules`      | Crea un nuevo horario de trabajo en la compañía      |
| PUT    | `/companies/{id_company}/schedules/{id}` | Actualiza un horario de trabajo existente            |
| DELETE | `/companies/{id_company}/schedules/{id}` | Elimina un horario de trabajo de la compañía         |

### Parámetros para actualización y creación

```json
{
    "descripcion": "Nuevo Horario",
    "conComida": 0,
    "estado": 1,
    "detalles": [
        {
            "dia": 1,
            "inicio": "08:00:00",
            "fin": "16:00:00",
            "toleranciaIn": 15,
            "toleranciaFin": 15,
            "tipo": 1
        }
    ]
}
```

## Códigos de Pago

### Rutas

| Método | Ruta                                    | Acción                                           |
| ------ | --------------------------------------- | ------------------------------------------------ |
| GET    | `/companies/{id_company}/payCodes`      | Retorna todos los códigos de pago de la compañía |
| GET    | `/companies/{id_company}/payCodes/{id}` | Retorna la información de un código de pago      |
| POST   | `/companies/{id_company}/payCodes`      | Crea un nuevo código de pago en la compañía      |
| PUT    | `/companies/{id_company}/payCodes/{id}` | Actualiza un código de pago existente            |
| DELETE | `/companies/{id_company}/payCodes/{id}` | Elimina un código de pago de la compañía         |

### Parámetros para actualización y creación

```json
{
    "descripcion": "Nuevo Código",
    "codexport": "NCP",
    "siglas": "NC",
    "tipo": 0
}
```

## Políticas de Pago

### Rutas

| Método | Ruta                                                            | Acción                                                                                 |
| ------ | --------------------------------------------------------------- | -------------------------------------------------------------------------------------- |
| GET    | `/companies/{id_company}/payCodes/{id_payCod}/payPolitics`      | Retorna todas las políticas de pago asociadas a un código de pago específico           |
| GET    | `/companies/{id_company}/payCodes/{id_payCod}/payPolitics/{id}` | Retorna la información de una política de pago específica asociada a un código de pago |
| POST   | `/companies/{id_company}/payCodes/{id_payCod}/payPolitics`      | Crea una nueva política de pago asociada a un código de pago                           |
| PUT    | `/companies/{id_company}/payCodes/{id_payCod}/payPolitics/{id}` | Actualiza una política de pago asociada a un código de pago existente                  |
| DELETE | `/companies/{id_company}/payCodes/{id_payCod}/payPolitics/{id}` | Elimina una política de pago asociada a un código de pago                              |

### Parámetros para actualización y creación

```json
{
    "nombre": "Nueva Política",
    "activo": 1,
    "pagaFeriados": 1,
    "pagaExtras": 0
}
```
