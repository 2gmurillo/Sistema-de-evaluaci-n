## A CERCA DE ESTE PROYECTO
El código fuente para este proyecto fue desarrollado en un sistema operativo GNU/Linux con el framework Laravel en su versión 8.x de PHP
## Instalación
### Herramientas utilizadas:
Adicional a una terminal de línea de comandos, un editor de código y un navegador web, nuestro sistema operativo GNU/Linux debe contar con:

- **[Apache2](https://httpd.apache.org/)**
- **[MySQL](https://www.mysql.com/)**
- **[PHP](https://www.php.net/)**
- **[Laravel](https://laravel.com/docs/8.x)**
- **[Composer](https://getcomposer.org/)**

Nota: algunas dependencias de Laravel requieren de ciertas extensiones de PHP para funcionar. En caso de que requieras alguna, como por ejemplo BCMath PHP Extension, puedes ejecutar la siguiente sentencia en la terminal de línea de comandos para configurarla:
```bash
$ sudo apt-get install php-bcmath
```
### Paso a paso:
Una vez hayas clonado el repositorio en una nueva carpeta, puedes proceder a ejecutar los siguientes pasos:  
(recuerda que la carpeta donde vas a clonar el repositorio debe contar con los permisos respectivos en tu sistema operativo)
- Instalación de dependencias:
```bash
$ composer install
```
- Generación del archivo .env para configuración de las variables de entorno:
```bash
$ cp .env.example .env
```
- Generación de la llave de la aplicación:
```bash
$ php artisan key:generate
```
- Configurar las credenciales para la conexión a la base de datos en las variables de entorno que se encuentran en el archivo .env generado anteriormente.
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_name
DB_USERNAME=db_user
DB_PASSWORD=db_pass
```
- Migraciones y alimentación de la base de datos:
```bash
$ php artisan migrate --seed
```
- Despliegue
```bash
$ php artisan serve
```
- Ahora puedes ver el despliegue en tu localhost y puerto por defecto. En mi caso se despliega en la url: http://127.0.0.1:8000/

## API Documentation
**Listar preguntas con sus respuestas relacionadas**  
Se listan 5 preguntas, cada una con 4 respuestas donde solo una es la correcta

**HTTP Request**
```bash
GET /api/v1/questions
```
```bash
Respuesta de ejemplo satisfactoria (200):
```
```bash
{
    "status": 200,
    "data": [
        {
            "content": "Accusantium laudantium eligendi officia deleniti.",
            "answers": [
                {
                    "id": 101,
                    "content": "Repellat sunt minus sit soluta."
                },
                {
                    "id": 102,
                    "content": "Distinctio et dicta accusantium culpa aliquam facilis est temporibus."
                },
                {
                    "id": 103,
                    "content": "Eum et voluptatem pariatur sed nihil."
                },
                {
                    "id": 104,
                    "content": "Veniam ea quaerat voluptatem et corporis."
                }
            ]
        },
        {
            "content": "Voluptatibus et consequatur cumque est.",
            "answers": [
                {
                    "id": 129,
                    "content": "Repellat sequi rerum vero omnis voluptas ut."
                },
                {
                    "id": 130,
                    "content": "Tempora adipisci molestiae eligendi odit."
                },
                {
                    "id": 131,
                    "content": "Voluptatem non eum at nihil."
                },
                {
                    "id": 132,
                    "content": "Et recusandae quia voluptatum iusto delectus accusantium fugiat."
                }
            ]
        },
        {
            "content": "Et a reprehenderit possimus est.",
            "answers": [
                {
                    "id": 133,
                    "content": "Recusandae laboriosam consectetur omnis labore autem fugiat aliquid impedit."
                },
                {
                    "id": 134,
                    "content": "Quam tempore voluptatem tempore temporibus."
                },
                {
                    "id": 135,
                    "content": "Qui dignissimos praesentium ut ex sequi consectetur et."
                },
                {
                    "id": 136,
                    "content": "Et veritatis magni explicabo ipsam quasi sed et."
                }
            ]
        },
        {
            "content": "Et eos necessitatibus laboriosam non.",
            "answers": [
                {
                    "id": 69,
                    "content": "Repellat quam ut totam non facere exercitationem soluta."
                },
                {
                    "id": 70,
                    "content": "Voluptates incidunt et vitae tenetur."
                },
                {
                    "id": 71,
                    "content": "Vitae ipsa inventore sit laboriosam consequuntur."
                },
                {
                    "id": 72,
                    "content": "Vitae et ea id beatae nihil modi."
                }
            ]
        },
        {
            "content": "Quisquam dolorem consequuntur quisquam ut dolorem a vel.",
            "answers": [
                {
                    "id": 73,
                    "content": "Eveniet qui aut natus quasi impedit vel."
                },
                {
                    "id": 74,
                    "content": "Iure est autem fugit rerum est sit."
                },
                {
                    "id": 75,
                    "content": "Expedita deserunt dolorem voluptatem dolore."
                },
                {
                    "id": 76,
                    "content": "Omnis cum distinctio consequatur fugiat."
                }
            ]
        }
    ]
}
```
---
**Obtener el resultado de las respuestas seleccionadas**  
**HTTP Request**
```bash
POST /api/v1/test-result
```
Parámetros | Estado | Valores aceptados | Descripción
--- | --- | --- | ---
answers | requerido | array numérico | Array con los id's correspondientes a las respuestas seleccionadas en el examen
```bash
Respuesta de ejemplo satisfactoria (200):
```
```bash
{
    "status": 200,
    "data": {
        "answers": {
            "correct": 4,
            "incorrect": 1
        }
    }
}
```
```bash
Respuesta de ejemplo solicitud incorrecta (400):
```
```bash
{
    "status": 400,
    "data": {
        "answers": [
            "The answers field is required."
        ]
    }
}
```
