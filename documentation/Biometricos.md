## Terminales

### Rutas

| Método | Ruta                         | Acción                            |
| ------ | ---------------------------- | --------------------------------- |
| GET    | `/biometrics/terminals`      | Solicitud de todas las terminales |
| GET    | `/biometrics/terminals/{id}` | Solicitud de una sola terminal    |
| POST   | `/biometrics/terminals`      | Crear una nueva terminal          |
| PUT    | `/biometrics/terminals/{id}` | Actualizar una terminal existente |
| DELETE | `/biometrics/terminals/{id}` | Eliminar una terminal             |

### Parámetros para actualización y creación

```json
{
    "teminal_no": 67890,
    "terminal_status": 1,
    "terminal_name": "Nueva Terminal",
    "terminal_location": "Nueva Ubicación",
    "termnal_conecttype": 2,
    "terminal_conectpwd": "pwd789",
    "terminal_domainname": "nuevodominio",
    "terminal_tcpip": "192.168.1.3",
    "terminal_port": 8082,
    "terminal_serial": "serial789",
    "terminal_baudrate": 19200,
    "terminal_type": "Tipo 3",
    "terminal_users": 300,
    "terminal_fingerprints": 1500,
    "terminal_punches": 3000,
    "terminal_faces": 600,
    "terminal_zem": "zem789",
    "terminal_kind": 3,
    "IsSelect": 1,
    "terminal_timechk": 15,
    "terminal_lastchk": "2023-09-15: 12:00:00"
}
```

## Parámetros en Terminal

### Rutas

| Método | Ruta                                                  | Acción                                            |
| ------ | ----------------------------------------------------- | ------------------------------------------------- |
| GET    | `/biometrics/terminals/{id_terminal}/parameters`      | Solicitud de todos los parámetros de una terminal |
| GET    | `/biometrics/terminals/{id_terminal}/parameters/{id}` | Solicitud de un solo parámetro de terminal        |
| POST   | `/biometrics/terminals/{id_terminal}/parameters`      | Crear un nuevo parámetro de terminal              |
| PUT    | `/biometrics/terminals/{id_terminal}/parameters/{id}` | Actualizar un parámetro de terminal existente     |
| DELETE | `/biometrics/terminals/{id_terminal}/parameters/{id}` | Eliminar un parámetro de terminal                 |

### Parámetros para actualización y creación

```json
{
    "parameter_name": "Nuevo Parametro",
    "parameter_value": "Nuevo Valor",
    "infoid": 789
}
```

## Empleados en Terminal

### Rutas

| Método | Ruta                                                 | Acción                                           |
| ------ | ---------------------------------------------------- | ------------------------------------------------ |
| GET    | `/biometrics/terminals/{id_terminal}/employees`      | Solicitud de todos los empleados en una terminal |
| GET    | `/biometrics/terminals/{id_terminal}/employees/{id}` | Solicitud de un solo empleado en una terminal    |
| POST   | `/biometrics/terminals/{id_terminal}/employees`      | Crear un nuevo empleado en una terminal          |
| PUT    | `/biometrics/terminals/{id_terminal}/employees/{id}` | Actualizar un empleado en una terminal existente |
| DELETE | `/biometrics/terminals/{id_terminal}/employees/{id}` | Eliminar un empleado de una terminal             |

### Parámetros para actualización y creación

```json
{
    "emp_pin": 103,
    "emp_status": 1,
    "last_sync": "2023-09-15 15:00:00",
    "Isdone": 1,
    "IsSelect": 1
}
```

## Empleados

### Rutas

| Método | Ruta                         | Acción                           |
| ------ | ---------------------------- | -------------------------------- |
| GET    | `/biometrics/employees`      | Solicitud de todos los empleados |
| GET    | `/biometrics/employees/{id}` | Solicitud de un solo empleado    |
| POST   | `/biometrics/employees`      | Crear un nuevo empleado          |
| PUT    | `/biometrics/employees/{id}` | Actualizar un empleado existente |
| DELETE | `/biometrics/employees/{id}` | Eliminar un empleado             |

### Parámetros para actualización y creación

```json
{
    "emp_pin": 1003,
    "emp_code": "EMP003",
    "emp_role": "ROLE_USER",
    "emp_firstname": "Alice",
    "emp_lastname": "Smith",
    "emp_username": "alicesmith",
    "emp_pwd": "password",
    "emp_privilege": "user",
    "emp_group": "group3",
    "emp_active": 1,
    "emp_cardNumber": "101112",
    "IsSelect": 1
}
```

## Plantillas

### Rutas

| Método | Ruta                                                 | Acción                             |
| ------ | ---------------------------------------------------- | ---------------------------------- |
| GET    | `/biometrics/employees/{employee_id}/templates`      | Solicitud de todas las plantillas  |
| GET    | `/biometrics/employees/{employee_id}/templates/{id}` | Solicitud de una sola plantilla    |
| POST   | `/biometrics/employees/{employee_id}/templates`      | Crear una nueva plantilla          |
| PUT    | `/biometrics/employees/{employee_id}/templates/{id}` | Actualizar una plantilla existente |
| DELETE | `/biometrics/employees/{employee_id}/templates/{id}` | Eliminar una plantilla             |

### Parámetros para actualización y creación

```json
{
    "effective": 1,
    "template_type": 2,
    "template_len": 512,
    "template_str": "Base64EncodedString3",
    "template_obj": "BinaryData3",
    "template_remark": "Template 3"
}
```

## Registros

### Parámetros para actualización y creación

### Rutas

| Método | Ruta                         | Acción                           |
| ------ | ---------------------------- | -------------------------------- |
| GET    | `/biometrics/registers`      | Solicitud de todos los registros |
| GET    | `/biometrics/registers/{id}` | Solicitud de un solo registro    |
| POST   | `/biometrics/registers`      | Crear un nuevo registro          |
| PUT    | `/biometrics/registers/{id}` | Actualizar un registro existente |
| DELETE | `/biometrics/registers/{id}` | Eliminar un registro             |

```json
{
    "emp_id": 1003,
    "punch_time": "2023-09-15 09:30:00",
    "workcode": "WC003",
    "workstate": "IN",
    "terminal_id": 3,
    "punch_type": "Card",
    "operator": "Operator3",
    "operator_reason": "Reason3",
    "operator_time": "2023-09-15 09:35:00",
    "IsSelect": 1
}
```

## Excepciones

### Rutas

| Método | Ruta                          | Acción                             |
| ------ | ----------------------------- | ---------------------------------- |
| GET    | `/biometrics/exceptions`      | Solicitud de todas las excepciones |
| GET    | `/biometrics/exceptions/{id}` | Solicitud de una sola excepción    |
| POST   | `/biometrics/exceptions`      | Crear una nueva excepción          |
| PUT    | `/biometrics/exceptions/{id}` | Actualizar una excepción           |
| DELETE | `/biometrics/exceptions/{id}` | Eliminar una excepción             |

### Parámetros para actualización y creación

```json
{
    "fecha_excep": "2023-09-17",
    "tiempoini": "2023-09-17 08:00:00",
    "tiempofin": "2023-09-17 17:00:00",
    "observacion": "Excepción 3",
    "id_codpag": 103,
    "id_trabajador": 1003
}
```
