## Indice

1. [Como Funcionamiento?](#Funcionamiento)
2. [Technologies](#technologies)
3. [Installation](#installation)
4. [Collaboration](#collaboration)

---

# MVC PHP framework

Este proyecto tiene como objetivo proveer un MVC PHP framework para que lo uses en tus proyectos. Podras conseguir un ejemplo para que se pueda visualizar de forma mas practica el funcionamiento del framework, adicionalmente para dar una vision general sobre como crear proyectos con este patron.

---

## QUE ES MVC? (Model View Controller)

Se resume en un patron de diseño usado ampliamente en proyectos ya que como resultado tendremos una estructura escalable, facilita la identificacion de como esta estructurado y adicionalmente facilita el mantenimiento. La estructura del proyecto esta basada en 3 modulos:

> _Models_ ................. Responsable por la conexion a la base de dato

> _Views_.................. Responsable por la parte visua

> _Controllers_............ Responsable por la logica de negocion (llama a las vistas pasandole la data y se conecta con los modelos para enviar y recibir datos)

---

## FUNCIONAMIENTO BASICO DEL PROYECTO

---

usaremos la URL para indicar el llamado de las clases controllador responsables de invocar las vistas y los metodos, asi como los parametros que necesarios para estos metodos.

> URL => localhost/UrlProyecto/posts/edit/1

> > /posts => llamara a la clase controllador que se ejecutara

> > /edit => metodo de la clase controller que llamara la respectiva vista y tendra la logica del manejo de datos

> > /1 => sera el parametro a utilizar el metodo

Tendremos un archivo **bootstrap** que se encargara de cargar las librerias creadas en la carpeta **libraries**

---

1. ## _llamado de los controllers_

Tendremos un archivo **Core.php** que es una libreria en el archivo **libraries**. Su trabajo sera leer la URL, separarla de la siguiente manera:

      $url = http//localhost/myApp/user/edit/1

```php
if(isset($_GET['url'])){
 $url = rtrim($_GET['url'], '/');
 $url = filter_var($url, FILTER_SANITIZE_URL);
 $url = explode("/", $url);
 return $urlArray;
```

```php
    $urlArray = ['user', 'edit', 1]
```

lo que nos devuelve el metodo sera un array con las partes de la url, cada una como un elemento de dicho array

luego segun la pocision de cada elemento del array $urlArray obtendremos el controller a instanciar, el metodo del controller instanciado a llamar y los parametros del metodo a usar:

    En las siguientes lineas de codigo indicaremos como obtendremos el controller:

```php
  if(file_exists('../app/controllers/' . ucwords($url[0]) . '.php')){
    $this->currentController = ucwords($url[0]);
    unset($url[0]);
  }

        //Requirimos el controllador
  require_once '../app/controllers/' . $this->currentController . '.php';

        //instanciamos este controllador
  $this->currentController = new $this->currentController;
```

    luego obtendremos el metodo del controllador que se llamara:

```php
      if(isset($url[1])) {

        // Check to see if method exists in controller
        if(method_exists($this->currentController, $url[1])){
          $this->currentMethods = $url[1];
          // unset 1 index
          unset($url[1]);
        }
      }
```

    por ultimo obtendremos los parametros:.

```php
      $this->params = $url ? array_values($url) : [];
```

    finalmente usaremos el metodo de php **call_user_func_array()** para ejecutar el metodo obtenido con sus parametros:

```php
      call_user_func_array([$this->currentController, $this->currentMethods], $this->params);
```

---

2. ## _libreria Controllers_

Tendremos un archivo **Controlles.php** que es una libreria creada en el archivo **libraries**.

En esta libreria encontraremos dos metodos:

1. se encargarar de requerir a un respectivo model y lo instanciara:

```php
   public function model($model){
    require_once '../app/models/'. $model . '.php';

    return new $model();
   }
```

2. se encargarar de requerir a una vista y se pasara la data para la visualizacion de esta:

```php
   public function view($view, $data = []){
    if(file_exists('../app/views/'. $view . '.php')){
      require_once '../app/views/'. $view . '.php';
    } else {
      die('View not found');
    }
   }
```

### NOTA:

          Todo controllador que se cree debera heredar esta clase controllador para tener acceso a estos metodos

- ### _archivo config_

Este archivo contara con todas las variables globales que usara nuestro proyecto.S
