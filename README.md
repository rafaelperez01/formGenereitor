Saltos de linea, es con dos espacios en blanco y luego el salto de linea (enter)

Encabezados es con almuadilla '#'

    # Encabezado uno, aquivalente a h1
    ## Encabezado dos, y así sucesivamente

Citas es con mayor que >

> Esto es una cita de texto que se hace con el signo mayor que '>'

Listas desordenadas es con guion '-' (algunas apps tambien aceptan '*' y '+' para crear listas)

- Elemento 1
- Item 2
- tres

Lista ordenada es con el numero y un punto seguido de espacio '1. '

1. Elemento 1
2. Item 2
3. tres

Linea horizontal es con tres guiones bajos seguidos '___'

___

Cusivas es rodeando el elemento o texto con un asterisco '* elemento *'

*Esto será un parrafo que se mostrará en cursiva*

Negrita es rodeando el elemento o texto con dos asterisco '** elemento **'

**Esto será un parrafo que se mostrará en negruita**

Negrita y cursiva a la vez, es con tres asteriscos '*** elemento ***'

***Esto será un parrafo que se mostrará en negruita y en cursiva***

Enlaces es rodeando con corchetes '[]' el enlace seguido de la URL tambien rodeada con parentesis '()', tambien le puedes añadir un titulo al enlace encerrando el titulo entre comillas dobles y dentro de los parentesis de la URL

[clic aqui para ir a google](https://google.com "Ir a Google")

    NOTA: si la url es el propio enlace, simplente se encierra entre menor que y mayor que
    
<https://google.com>


Imagenes, es como incluir un enlace pero con el simbolo de exclamacion delante de los corchetes
    
![Pie de la imagen](https://upload.wikimedia.org/wikipedia/commons/thumb/4/48/Markdown-mark.svg/1200px-Markdown-mark.svg.png "Imagen de Mark Down")

Insertar código, es con cuatro espacios en blanco si sólo es una sentencia "    "
    
    print('hola mundo');

Si es un bloque de código, se encierra con tres bigudilla '~~~' o tres acentos agudos '```',
tambien puedes especificar el lenguaje del codigo indicandolo despues de las tres primeras bigudillas o acentos
        
~~~php
for($i = 1; $i <= 5; $i++){
    print("esta es la vuelta #" + $i + "\n");
}
~~~

Si es código en linea, es decir, en la mista linea de texto, se rodea entre acentos graves '`codigo`'
    para imprimir se usa la funcion `print` seguido del texto a imprimir
    
Para escapar algun caracter especia es con barra invertida '\'
    
    Texto que \*escapa\* los asteriscos