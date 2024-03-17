# Documentación del programador

En este artículo encontraras lo necesario para abordar el proyecto de la mejor manera

## Tecnologías Utilizadas

A continuación se encuentran todas las tecnologías utilizadas en el proyecto junto con su propósito y un enlace a su documentación oficial.

| Tecnología   | Uso                                                             | Documentación Oficial                                     |
| :----------: | :-------------------------------------------------------------: | :-------------------------------------------------------: |
| `PHP`        | Principal lenguaje de programación                              | [Click aquí](https://www.php.net/manual/es/index.php)     |
| `Laravel`    | Framework utilizado para el front-end y back-end                | [Click aquí](https://laravel.com/docs/10.x)               |
| `Blade`      | Gestor de vistas junto con HTML, CSS y JS                       | [Click aquí](https://laravel.com/docs/10.x/blade)         |
| `Tailwind`   | Librería de CSS para escribir estilos inline                    | [Click aquí](https://tailwindcss.com/docs/installation)   |
| `JavaScript` | Para añadirle interactividad a las vistas                       | [Click aquí](https://www.w3schools.com/jsrEF/default.asp) |
| `Vite`       | Para gestionar los includes en las vistas                       | [Click aquí](https://vitejs.dev/guide/)                   |
| `NPM`        | Gestor de paquetes de JavaScript                                | [Click aquí](https://www.npmjs.com/)                      |
| `Composer`   | Gestor de paquetes de Laravel                                   | [Click aquí](https://getcomposer.org/doc/)                |
| `JWT`        | Token de seguridad para acceder al API mediante una librería    | [Click aquí](https://jwt-auth.readthedocs.io/en/develop/) |
| `SQL`        | Para la creación de la Base de Datos                            | [Click aquí](https://dev.mysql.com/doc/refman/8.0/en/)    |
| `Xampp`      | Gestión y acceso de la Base de datos mediante un servidor local | [Click aquí](https://www.apachefriends.org/es/index.html) |

## Estructura y contenido de carpetas

### Vistazo General

```plain
├── 📂 app
|   ├── 📁 Http
|   |   ├── 📁 Controllers
|   |   |   ├── 📁 API
|   |   |   ├── 📁 Pages
|   |   |   └── 📄 Controller.php
|   |   |  
|   |   ├── 📁 Middleware
|   |   └── 📄 Kernel
|   |   
|   ├── 📁 Mail
|   ├── 📁 Models
|   |   ├── 📁 ATT
|   |   ├── 📁 HR
|   |   ├── 📁 SYS
|   |   └── 📄 modeloBase.php
|   |
|   ├── 📁 Providers
|   └── 📁 ...
|
├── 📂 bootstrap
|   ├── 📁 cache
|   └── 📄 app.php
|
├── 📁 config
├── 📁 db
├── 📂 documentation
├── 📂 node_modules
|   ├── 📁 Librerías de JavaScript
|   └── 📁 ...
|
├── 📂 public
├── 📂 resources
|   ├── 📁 css
|   ├── 📁 icons
|   ├── 📁 js
|   ├── 📁 lang
|   └── 📁 views
|
├── 📁 routes
├── 📂 storage
├── 📁 tests
├── 📂 vendor
|   ├── 📁 Librerías de PHP
|   └── 📁 ...
|
├── 📄 .env
├── 📄 .env.example
├── 📄 composer.json
├── 📄 package.json
├── 📄 tailwind.config.js
├── 📄 vite.config.js
└── 📄 ... archivos de configuración extras ...
```

### Carpeta `Controllers`

Dentro de la carpeta controller se encuentran los archivos del relacionados al API y al front-end donde se hace el procesamiento de datos.

En el caso del API se realizan las operaciones relacionadas con la **base de datos**.

En el front-end se realizan las operaciones de **comunicación entre el API** y el front y se decide que **vista se debe mostrar** al usuario

Varias operaciones generales se realizan mediante funciones en el `Controller.php` del cual extienden todos los demás controladores, como las request al API que se resuelven de manera interna, así como el cambio de nombres en parámetros de una request.

#### API

La carpeta API tiene la siguiente estructura en su interior:

```plain
├── 📁 HR
├── 📂 SYS
├── 📄 DashboardController.php
└── 📄 SimpleCRUDController.php
```

Es importante mencionar que casi todas las operaciones son realizadas mediante el `SimpleCRUDController`, el cual es un controlador general. Todos los demás controladores realizan operaciones más específicas para ciertas entidades del sistema junto con su CRUD para la tabla principal.

La carpeta HR contiene los archivos que controlan las operaciones relacionadas a las tablas de la sección de HR. La carpeta de SYS son los controladores relacionados a las tablas del sistema.

#### Pages

Bajo esta carpeta se encuentran todos los controladores para la gestión de las vistas y conexión al API. Por lo general al igual que en el API se tiene un modelo general el cual en este caso se llama `CompanyController`, el cual toma en cuenta rutas simples y rutas anidadas, junto con su implementación de en los archivos de rutas.

Los demás controladores realizan tareas más específicas como el control de inicio de sesión o el manejo de tablas con relaciones un poco más complejas.

```plain
├── 📄 CompanyController.php
└── 📄 ...
```

### Carpeta `Models`

En esta carpeta se encuentran todas las tablas de la base de datos descritas por un modelo de Laravel mediante su [**ORM Eloquent**](https://laravel.com/docs/10.x/eloquent), estos modelos incluyen información sobre su llave primaria y el nombre de los campos que se pueden llenar. La información sobre el tipo de dato de cada campo se encuentra en los archivos de la base de datos en la carpeta bd la cual se explicará más adelante.

La carpeta tiene la siguiente estructura:

```plain
├── 📁 ATT
|   ├── 📄 modelos relacionados a las tablas att_
|   └── 📄 ...
|
├── 📁 HR
|   ├── 📁 Company
|   |   ├── 📁 Employment
|   |   ├── 📁 General
|   |   └── 📁 Schedule
|   |
|   ├── 📁 Employee
|   |   ├── 📁 General
|   |   ├── 📁 Incidencies
|   |   └── 📁 Info
|   |
|   └── 📄 modeloBase.php
|
├── 📁 ATT
|   ├── 📄 modelos relacionados a las tablas sys
|   └── 📄 ...
|
└── 📄 modeloBase.php
```

Bajo cada carpeta se encuentran los modelos relacionados a esa parte del sistema, por ejemplo bajo `HR` se encuentran únicamente los archivos relacionados a los empleados y empresas. Es importante tener cada tabla declarada en un modelo para poder hacer uso del ORM a lo largo del desarrollo y así poder manipular las tablas de una forma más fácil.

### Carpeta  `db`

La carpeta tiene la siguiente estructura:

```plain
├── 📄 DB Script for Deploy.sql
├── 📄 DB Script for Local.sql
|
├── 📄 Diseño de la BD.sql
├── 📄 Modelo HR.mwb
|
├── 📄 horarios.csv
├── 📄 permisos_roles.csv
└── 📄 permisos.csv
```

La carpeta se divide en 3 tipo de archivos los cuales se explica su importancia y uso a continuación

#### DB Scripts

Los primeros dos archivos de esta carpeta representan la base de datos en SQL para poder ejecutarlo directo en el DBMS que se tenga la diferencia entre el archivo `for Deploy` y el archivo `for Local` es que en el local se le otorga un nombre a la base de datos que posiblemente el no coincida con el nombre de la BD en producción, para lo cual se debe copiar el contenido del archivo `for Local` al archivo `for Deploy` y hacer el cambio de nombre de la base de datos a todo el archivo.

Por ejemplo si se tuviera lo siguiente en el archivo `for Local`:

```sql
-- -----------------------------------------------------
-- Schema nombre_bd_produccion
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `db_hr_control_system` DEFAULT CHARACTER SET utf8 ;
USE `db_hr_control_system` ;

-- -----------------------------------------------------
-- Table `db_hr_control_system`.`sys_roles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_hr_control_system`.`sys_roles` ;

CREATE TABLE IF NOT EXISTS `db_hr_control_system`.`sys_roles` (
  `id_rol` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(15) NOT NULL,
  PRIMARY KEY (`id_rol`))
ENGINE = InnoDB;
```

Se debe convertir a lo siguiente para el archivo `for Deploy`:

```sql
-- -----------------------------------------------------
-- Schema nombre_bd_produccion
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `nombre_bd_produccion` DEFAULT CHARACTER SET utf8 ;
USE `nombre_bd_produccion` ;

-- -----------------------------------------------------
-- Table `nombre_bd_produccion`.`sys_roles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `nombre_bd_produccion`.`sys_roles` ;

CREATE TABLE IF NOT EXISTS `nombre_bd_produccion`.`sys_roles` (
  `id_rol` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(15) NOT NULL,
  PRIMARY KEY (`id_rol`))
ENGINE = InnoDB;
```

#### Modelado de datos

En los siguientes archivos de `MODELO` y de `Diseño` contienen información sobre las tablas, sus relaciones, los tipos de datos de los atributos y su significado.

El archivo de `MODELO` es una representación gráfica de las tablas del cual se puede extraer los Scripts SQL para montar la BD, de igual forma mediante este archivo se pueden realizar cambios en los tipos de datos, añadir o eliminar relaciones de tablas, crear nuevas tablas y sus relaciones, así como realizar acciones `INSERT` en las tablas con datos registros que necesitemos que la base de datos tenga desde el inicio.

Por el momento esto se tiene para preparar la base de datos para su uso en desarrollo, por lo que algunos registros no son necesarios cuando se realiza el deploy de la BD.

Por otro lado, el archivo de `Diseño` otorga una breve descripción de las tablas y sus atributos, así como el tamaño de los datos que se deben de tener.

#### Archivos de Datos

El los archivos de tipo `.csv` se tienen registros para las tablas a las que hace alusión su nombre. Este tipos de archivos se pueden importar de forma fácil al `MODELO` en los inserts de cada tabla, por lo que ayudan a no tener que escribir registros en tablas de forma manual. Hay que tener cuidado cuando se trabaja de esta forma de que los tipos de datos coincidan con los de la base de datos para evitar errores futuros.

### Carpeta `resources`

En esta carpeta se encuentran todos los contenidos que se requieren para el front-end, tanto las vistas como los recursos de css y js que se requieren. El manejo de estos archivos en modo de desarrollo se realiza mediante `Vite`, por lo que una vez que se lleve el proyecto a producción de debe correr el siguiente comando para añadir todos los archivos de js y css a la carpeta public del proyecto:

```bash
npm run build
```

Po otro lado, esta carpeta tiene la siguiente estructura:

```plain
├── 📁 css
├── 📁 icons
├── 📁 js
├── 📁 lang
|   └── 📁 es
|       └── 📄 validation.php
|
└── 📁 views
    ├── 📁 biometrics
    |   ├── 📁 exceptions
    |   ├── 📁 registros
    |   └── 📁 terminals
    |
    ├── 📁 company
    |   ├── 📁 departments
    |   ├── 📁 employee-types
    |   ├── 📁 holidays
    |   ├── 📁 pay-codes
    |   ├── 📁 pay-politics
    |   ├── 📁 positions
    |   ├── 📁 schedules
    |   ├── 📁 trainings
    |   └── 📁 units
    |
    ├── 📁 components
    ├── 📁 employees
    |   ├── 📁 documents
    |   ├── 📁 general
    |   └── 📁 relatives
    |
    ├── 📁 forms
    ├── 📁 home
    ├── 📁 layouts
    ├── 📁 mail
    ├── 📁 Reportes
    ├── 📁 svg
    └── 📁 system
        ├── 📁 companies
        ├── 📁 permisos
        ├── 📁 roles
        └── 📁 users
```

A pesar de haber muchas carpetas dentro de la parte de `views` es para mantener los archivos más organizados y para poder usar el controlador general y solo hacer instancias del mismo para poder manejar más de un solo elemento del sistema.

#### Carpeta `lang`

Esta carpeta cuenta con traducciones que se requieran para algunas partes de la aplicación en este caso se realizó las traducciones para mensajes de error de las validaciones de los controladores a los datos las cuales se explicarán más adelante.

#### Carpeta `layouts`

En la carpeta layouts se tienen estructuras de vistas que se repiten a lo largo de toda la aplicación, en estos archivos se encuentran la base donde se añade la barra de navegación y se deja un espacio para el contenido que será el que irá cambiando a lo largo del sistema. De igual forma tenemos algunos otros layouts que extienden del base pero siguen siendo generales, sobre todo para el uso del controlador general de vistas. De igual forma leer sobre la documentación de como se usan las [Blades de Laravel](https://laravel.com/docs/10.x/blade) no esta de más leer su documentación.

#### Carpeta `components`

Bajo esta carpeta se tienen componentes que se reutilizan a lo largo de todas las blades, los cuales se pueden importar de forma directa o se puede generar una instancia de ellos dándoles los atributos necesarios como un componente de HTML normal.

#### Carpeta `mail`

Dentro de esta carpeta se tienen la vista de los mails que enviará el sistema como port ejemplo la del restablecimiento de contraseña, es importante mencionar que el uso de css dentro de estas Blades se debe realizar mediante el atributo `style=""` de las etiquetas HTML para su correcto funcionamiento.

#### Carpeta `Reportes`

la carpeta de reportes se utiliza para tanto las vistas de los reportes como para las vistas de la generación de PDFs para imprimir la información del reporte de una mejor forma, por lo que para cada reporte se usan dos vistas, y de igual forma que en la de mail los estilos e los PDF se deben manejar mediante la etiqueta `<style></style>` o mediante el atributo `style=""`.

#### Carpetas con más carpetas dentro

Todas las carpetas de `biometrics`, `company`, `employees` y `system` contienen las carpetas para los CRUDs de las tablas asociadas al nombre de la carpeta dentro de cada carpeta se tienen por lo general los siguientes archivos:

```plain
├── 📁 all.php
├── 📁 form.php
└── 📁 one.php
```

El primer archivo da la vista específica para desplegar una vista general del contenido de la tabla limitando por empresa en la mayoría de los casos.

El form hace referencia a la vista donde se tiene el formulario para crear un registro nuevo en la tabla.

El último archivo es la vista donde se despliega toda la información de un solo registro, ahí mismo se tiene las opciones de `UPDATE` y de `DELETE` del registro.

### Carpeta `routes`

En la carpeta se tienen archivos donde se declaran las rutas a las que se van a poder acceder tanto el front-end como el backend. Estos archivos a parte de declarar un endpoint se debe asociar una función, ya sea que se escriba directo en este archivo o sea una función del controlador. De igual forma se puede hacer uso de middlewares para hacer acciones intermedias entre una ruta y otra, además, mediante la declaración del endpoint y la función se pueden dar de alta parámetros que se mandan por mediante la ruta. Para más información consulta la documentación de oficial de [Laravel como realiza su Routing.](https://laravel.com/docs/10.x/routing)

En este caso la carpeta cuenta con los siguientes archivos:

```plain
├── 📄 api.php 
├── 📄 channels.php
├── 📄 console.php
└── 📄 web.php
```

Dentro de esta carpeta los archivos que utilizamos son los de `api.php` y `web.php`, como su nombre lo indica en el primer archivo se dan de alta todos los endpoints del API y en el segundo se tienen todas las rutas del front-end.

### Archivo `.env`

El archivo `.env` contiene todas las variables de entorno del proyecto, dentro de las cuales se encuentran los datos para la conexión con la base de datos, la conexión con el servicio de envío de correos, así como el tiempo de vida de una sesión y un token, el idioma de la aplicación entro otros.

Este archivo se debe modificar cuando se realice el despliegue de la aplicación y cambiar las variables necesarias.

De igual forma se debe mantener una copia bajo el nombre `.env.example`, ya que en caso de usar git o github el archivo `.env` depende de cada entorno por lo que no se sube, sin embargo es de vital importancia para el funcionamiento del sistema.

### Archivo `tailwind.config.js`

El archivo de configuración de Tailwind sirve para poder dar de alta una paleta de colores y utilizarla a lo largo de toda la aplicación.

#### Paleta de colores actual

- ![#1f1f1f](https://via.placeholder.com/15/1f1f1f/000000?text=+) `#1f1f1f` Dark
- ![#353535](https://via.placeholder.com/15/353535/000000?text=+) `#353535` Dark Light
- ![#8c8c8b](https://via.placeholder.com/15/8c8c8b/000000?text=+) `#8c8c8b` Light Dark
- ![#f9f9f9](https://via.placeholder.com/15/f9f9f9/000000?text=+) `#f9f9f9` Light
- ![#0F4B80](https://via.placeholder.com/15/0F4B80/000000?text=+) `#0F4B80` Primary
- ![#1A80C8](https://via.placeholder.com/15/1A80C8/000000?text=+) `#1A80C8` Secondary
- ![#248096](https://via.placeholder.com/15/248096/000000?text=+) `#248096` Tertiary
- ![#c41414](https://via.placeholder.com/15/c41414/000000?text=+) `#c41414` Danger
- ![#3ab62c](https://via.placeholder.com/15/3ab62c/000000?text=+) `#3ab62c` Success

### Archivo `vite.config.js`

En este archivo se tienen que dar de alta todos los archivos de tipo js y css que se utilicen a lo largo de toda la aplicación para hacer esto de una mejor forma se realizó una función que dándole el tipo de archivo y el nombre lo registra. Los archivos deben encontrarse dentro de las carpetas js y css y en el atributo filePath se debe dar el path relativo al archivo y/o el nombre omitiendo la extensión.

A continuación se muestra un ejemplo de uso:

```js
function getResource(type, filePath) {
    return "resources/" + type + "/" + filePath + "." + type;
}

export default defineConfig({
    plugins: [
        laravel({
            input: [
                getResource("js", "app"),
                getResource("css", "app"),
            ],
            refresh: true,
        }),
    ],
});

```

## Información adicional

A parte de conocer la estructura es importante que conozcan la forma en que se realizan las acciones dentro de la aplicación y algunas funciones fundamentales de los controladores.

### Validate

Al momento de hacer una request tanto del front-end al controlador o desde un controlador al API es necesario validar los datos de alguna forma, para ellos Laravel cuenta con una clase mediante la cual para información entre una petición y otra, la cual se llama `Illuminate\Http\Request` esta clase cuanta con una manera de poder validar los atributos del cuerpo de una petición mediante su método `validate` el cual se manda a llamar de la siguiente manera:

```php
$request->validate([
    // Reglas de validación por atributo
    'campo' => 'reglas de validación'
]);
```

Esta herramienta se debe utilizar siempre cuando haya paso de datos entre el usuario y el controlador y el controlador y el API.

Laravel se hace cargo de manejar los errores y arroja los errores correspondientes mediante una variable `$errors` de regreso al front-end.

Para conocer más sobre las reglas de validación visita [la página oficial de Laravel](https://laravel.com/docs/10.x/validation).

### Flujo de datos

```plain
--> Vista del Formulario 
    --> Acción de Submit del Formulario
        --> Validación de Formulario
            --> Manejo de errores
                --> Cambio de nombres y tipos de datos
                    --> Petición al API
                        --> Re-dirección a otro endpoint
```

Laravel exige de dos funciones cuando se tiene un formulario, primero de debe de tener una ruta para mostrar el formulario y la ruta de procesamiento y petición al API. Por otro lado, puede ser que el nombre de los atributos en el API deban de llegar con un nombre especifico que tal vez no es muy intuitivo para el usuario si se usa ese para el front-end, por lo que un cambio de nombre en el atributo es algo muy común para lo cual se desarrolló una función que realiza los cambios.

De igual forma cuando se hace un paso de parámetros del front-end al controlador los datos llegan como un `string` por lo que en caso de necesitar convertirlos a `int` o `float` se puede realizar, sin embargo en caso de necesitar algún otro tipo de dato se debe de implementar.
