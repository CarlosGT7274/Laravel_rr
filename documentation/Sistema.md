## Sesiones

### Rutas

| Método | Ruta              | Acción                                                          |
| ------ | ----------------- | --------------------------------------------------------------- |
| POST   | `/login`          | Inicia Sesión                                                   |
| POST   | `/logout`         | Cerrar Sesión e invalidar el token                              |
| POST   | `/refresh`        | Genera un Token nuevo para la sesión actual                     |
| GET    | `/me`             | Obtiene la información del usuario actual                       |
| GET    | `/resetToken`     | Envía por el correo solicitado un token para cambiar contraseña |
| PUT    | `/updatePassword` | Actualiza la contraseña del usuario si se tiene un token válido |

### Parámetros

```json
{
    "email": "email@algo.com",
    "password": "contraseña",
    "token": "Token enviado al correo para renovar contraseña"
}
```

## Usuarios

### Rutas

| Método | Ruta          | Descripción                             |
| ------ | ------------- | --------------------------------------- |
| GET    | `/users`      | Retorna todos los usuarios del sistema. |
| GET    | `/users/{id}` | Retorna la información de un usuario.   |
| POST   | `/users`      | Añade un nuevo usuario al sistema.      |
| PUT    | `/users/{id}` | Cambia la información de un usuario.    |
| DELETE | `/users/{id}` | Elimina un usuario.                     |

### Parámetros de actualización y creación

```json
{
    "email": "email2@algo.com",
    "password": "contraseña",
    "nombre": "Alguien Más",
    "apellidoP": "Algo",
    "apellidoM": "Algún",
    "id_rol": 1,
    "id_empresa": 2
}
```

## Privilegios

### Rutas

| Método | Ruta               | Descripción                                          |
| ------ | ------------------ | ---------------------------------------------------- |
| GET    | `/privileges`      | Retorna todos los privilegios del sistema.           |
| GET    | `/privileges/{id}` | Retorna la información de un privilegio.             |
| POST   | `/privileges`      | Crea un nuevo privilegio en el sistema.              |
| PUT    | `/privileges/{id}` | Actualiza la información de un privilegio existente. |
| DELETE | `/privileges/{id}` | Elimina un privilegio existente.                     |

### Parámetros de actualización y creación

```json
{
    "nombre": "Nuevo Privilegio",
    "padre": 1,
    "endpoint": "/privileges/nuevo",
    "activo": 1
}
```

## Roles

### Rutas

| Método | Ruta          | Descripción                                  |
| ------ | ------------- | -------------------------------------------- |
| GET    | `/roles`      | Retorna todos los roles del sistema.         |
| GET    | `/roles/{id}` | Retorna la información de un rol específico. |
| POST   | `/roles`      | Crea un nuevo rol en el sistema.             |
| PUT    | `/roles/{id}` | Modifica un rol existente en el sistema.     |
| DELETE | `/roles/{id}` | Elimina un rol existente en el sistema.      |

### Parámetros de actualización y creación

```json
{
    "nombre": "AlgunNuevo",
    "permisos": [
        {
            "id_permiso": 1,
            "permiso": -1
        },
        {
            "id_permiso": 2,
            "permiso": -1
        }
    ]
}
```

## Grupos

### Rutas

| Método | Ruta                               | Descripción                                    |
| ------ | ---------------------------------- | ---------------------------------------------- |
| GET    | `/groups`                          | Retorna todos los Grupos del sistema.          |
| GET    | `/groups/{id}`                     | Retorna la información de un grupo específico. |
| POST   | `/groups`                          | Crea un nuevo grupo en el sistema.             |
| PUT    | `/groups/{id}`                     | Modifica la información de un grupo existente. |
| DELETE | `/groups/{id}`                     | Elimina un grupo existente en el sistema.      |
| PUT    | `/groups/{id_group}/add`           | Añade un usuario a un grupo existente.         |
| DELETE | `/groups/{id_group}/remove`        | Elimina un usuario de un grupo existente.      |
| POST   | `/groups/{id_group}/message`       | Guarda un mensaje en un grupo sin enviarlo.    |
| PUT    | `/groups/{id_group}/refresh/{$id}` | Actualiza un mensaje en un grupo sin enviarlo. |
| PUT    | `/groups/{id_group}/send/{$id}`    | Envia un mensaje de un grupo.                  |

### Parámetros de actualización y creación

```json
{
    "nombre": "Nombre del grupo",
    "telefono": "1234567890",
    "email": "algunEmail@ada.com",
    "usuarios": [
        {
            "id_usuario": 3
        },
        {
            "id_usuario": 2
        }
    ]
}
```

### Parametros para añadir o eliminar un usuario

```json
{
    "id_usuario": 3
}
```

### Parametros para iniciar un mensaje o actualizar

```json
{
    "id_usuario": 3,
    "mensaje": "Un mensaje para el grupo"
}
```

### Parametros para enviar un mensaje

```json
{
    "metodo": "1 | 2 | 3"
}
```
