# Documentación de la API

Esta documentación describe la API de Sistema Control de Recursos Humanos de la empresa XUBE.

## Introducción

La API se utiliza para realizar operaciones relacionadas con usuarios, autenticación y operaciones CRUD. A continuación, se detallan los endpoints disponibles y cómo utilizarlos.

Por otro lado el api se encuentra bajo el siguiente endpoint base: `/api/v1`

Los parámetros necesarios en los endpoints de creación por lo general son todos necesarios y en los de actualización son todos opcionales a menos que se indique lo contrario en la documentación del endpoint.

Todas Las respuestas del API se mandan con el siguiente formato:

```json
{
    "error": true,
    "mensaje": "string",
    "data": "información en [] o {}"
}
```

El atributo de `error` indica con un true en caso de que algo haya fallado al momento de realizar la consulta.

En el `mensaje` se mostrará un indicativo en caso de que se requiera.

En `data` se envía toda la información que se haya solicitado, el formato de esta parte depende el endpoint de consulta, como se muestra en la documentación de cada endpoint.

En caso de que ocurra algún error con las solicitudes como no mandar los campos requeridos o no mandar el tipo de dato correcto el API regresa un código `422` con un atributo en lugar del `data` con el nombre de `errors` con los errores ocurridos.

## Headers

Es Necesario para hacer uso de la API mandar en los headers de la petición dos campos adicionales una vez que se ha iniciado sesión.

| Parámetro       | Tipo     | Descripción                                          |
| :-------------- | :------- | :--------------------------------------------------- |
| `Authorization` | `string` | **Necesario después de Login**. Bearer { JTW token } |

En caso de que algo falte el api regresa un código `401` con el mensaje `No autorizado`.

## Endpoints

La documentación de los endpoints se encuentran dependiendo del contexto de los mismos como se muestra en a continuación

| Contexto           | Ubicación                                                                                                    |
| :----------------- | :----------------------------------------------------------------------------------------------------------- |
| 🖥 Sistema          | [documentation/Sistema.md](https://github.com/C4ncino/HR_Service/blob/main/documentation/Sistema.md)         |
| 🏢 Empresas        | [documentation/Empresas.md](https://github.com/C4ncino/HR_Service/blob/main/documentation/Empresas.md)       |
| 👩🏼‍🤝‍🧑🏻 Empleados | [documentation/Empleados.md](https://github.com/C4ncino/HR_Service/blob/main/documentation/Empleados.md)     |
| 🕓 Biométricos     | [documentation/Biometricos.md](https://github.com/C4ncino/HR_Service/blob/main/documentation/Biometricos.md) |
| 📊 Dashboard       | [documentation/Dashboard.md](https://github.com/C4ncino/HR_Service/blob/main/documentation/Dashboard.md)     |
