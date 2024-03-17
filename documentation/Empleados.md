## Empleados

### Rutas

| Método | Ruta                                      | Acción                           |
| ------ | ----------------------------------------- | -------------------------------- |
| GET    | `/employees`                              | Solicitud de todos los empleados |
| GET    | `/employees/{id}`                         | Solicitud de un solo empleado    |
| POST   | `/employees`                              | Crear un nuevo empleado          |
| PUT    | `/employees/{id}`                         | Actualizar un empleado existente |
| DELETE | `/employees/{id}`                         | Eliminar un empleado             |
| POST   | `/employees/{id_employee}/youAreFired`    | Dar de baja a un empleado        |
| POST   | `/employees/{id_employee}/changePosition` | Cambiar posición de un empleado  |

### Parámetros para actualización y creación

```json
{
    "id_usuario": 1,
    "telefono": "1234567890",
    "telefono2": "9876543210",
    "email2": "correo@ejemplo.com",
    "rfc": "ABCDE1234567F",
    "curp": "ABC123456789012345",
    "sexo": true,
    "estadoCivil": 1,
    "cumpleaños": "1990-01-01",
    "lugarNatal": 1,
    "calle": "Calle Principal",
    "colonia": "Colonia Ejemplo",
    "poblacion": "Población",
    "ciudad": "Ciudad",
    "estado": 1,
    "codigoPostal": 12345,
    "nombreEmergencia": "Contacto de Emergencia",
    "dirEmergencia": "Calle de Emergencia",
    "telEmergencia": "9876543210",
    "imss": "12345678901",
    "tipoSangre": "A+",
    "enfermedades": "Ninguna",
    "fonacot": "12345",
    "unidadMedica": 1,
    "alta": "2023-09-11",
    "altaFiscal": "2023-09-11",
    "contratoInicio": "2023-09-11",
    "contratoFin": "2023-09-12",
    "sueldo": 50000,
    "formaPago": "A",
    "pensAlimenticia": true,
    "nomClave": "Clave",
    "nomBanco": 1,
    "nomLocalidad": "Localidad",
    "nomReferencia": "Referencia",
    "nomCuenta": "Cuenta",
    "id_unidad": 1,
    "id_departamento": 1,
    "id_puesto": 1,
    "id_tipo_empleado": 1,
    "id_horario": 1,
    "id_empresa": 1,
    "id_terminal_user": 1
}
```

### Parámetros para dar de baja un empleado

```json
{
    "observaciones": "Motivo de la baja",
    "infoBaja": 0
}
```

### Parámetros para cambiar de posición

```json
{
    "movimiento": "C",
    "estado": 1,
    "id_unidad": 2,
    "id_puesto": 3,
    "id_departamento": 4,
    "sueldo": 2500.5,
    "observaciones": "Este empleado ha sido promovido."
}
```

## Documentos de Empleados

### Rutas

| Método | Ruta                                      | Acción                                 |
| ------ | ----------------------------------------- | -------------------------------------- |
| GET    | `/employees/{id_employee}/documents`      | Todos los documentos de un empleado    |
| GET    | `/employees/{id_employee}/documents/{id}` | Un documento específico de un empleado |
| POST   | `/employees/{id_employee}/documents`      | Agregar un nuevo documento al empleado |
| PUT    | `/employees/{id_employee}/documents/{id}` | Actualizar un documento del empleado   |
| DELETE | `/employees/{id_employee}/documents/{id}` | Eliminar un documento del empleado     |

### Parámetros para Crear y Actualizar Documentos

```json
{
    "nombre": "Documento3",
    "tipo": 3,
    "info": "Información del documento 3 en base64"
}
```

## Imágenes de Empleados

### Rutas

| Método | Ruta                                   | Acción                               |
| ------ | -------------------------------------- | ------------------------------------ |
| GET    | `/employees/{id_employee}/images`      | Todas las imágenes de un empleado    |
| GET    | `/employees/{id_employee}/images/{id}` | Una imagen específica de un empleado |
| POST   | `/employees/{id_employee}/images`      | Agregar una nueva imagen al empleado |
| PUT    | `/employees/{id_employee}/images/{id}` | Actualizar una imagen del empleado   |
| DELETE | `/employees/{id_employee}/images/{id}` | Eliminar una imagen del empleado     |

### Parámetros para Crear y Actualizar Imágenes

```json
{
    "info": "Información de la imagen 3"
}
```

#### Rutas

| Método | Ruta                                   | Acción                               |
| ------ | -------------------------------------- | ------------------------------------ |
| GET    | `/employees/{id_employee}/images`      | Todas las imágenes de un empleado    |
| GET    | `/employees/{id_employee}/images/{id}` | Una imagen específica de un empleado |
| POST   | `/employees/{id_employee}/images`      | Agregar una nueva imagen al empleado |
| PUT    | `/employees/{id_employee}/images/{id}` | Actualizar una imagen del empleado   |
| DELETE | `/employees/{id_employee}/images/{id}` | Eliminar una imagen del empleado     |

## Familiares de Empleados

### Rutas

| Método | Ruta                                      | Acción                                |
| ------ | ----------------------------------------- | ------------------------------------- |
| GET    | `/employees/{id_employee}/relatives`      | Todos los familiares de un empleado   |
| GET    | `/employees/{id_employee}/relatives/{id}` | Un familiar específico de un empleado |
| POST   | `/employees/{id_employee}/relatives`      | Agregar un nuevo familiar al empleado |
| PUT    | `/employees/{id_employee}/relatives/{id}` | Actualizar un familiar del empleado   |
| DELETE | `/employees/{id_employee}/relatives/{id}` | Eliminar un familiar del empleado     |

### Parámetros para Crear y Actualizar Familiares

```json
{
    "nombre": "Familiar3",
    "apellidoP": "Apellido5",
    "apellidoM": "Apellido6",
    "parentesco": 3,
    "telefono": "5556667777",
    "telefono2": "8889990000"
}
```
