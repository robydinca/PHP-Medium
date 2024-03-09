# API REST - Descripción de Operaciones

A continuación se describen las operaciones disponibles en la API REST junto con sus verbos HTTP y URLs típicas:

## Operaciones

| Operación | Significado                           | Verbo  | URL Típica                                                |
|-----------|---------------------------------------|--------|-----------------------------------------------------------|
| index     | Mostrar todos los modelos             | GET    | http://localhost:8080/php/apirestapelo/REST/index.php?api/modelo/ |
| show      | Mostrar un modelo específico          | GET    | http://localhost:8080/php/serviciosWeb/REST/index.php?api/modelo/{id} |
| store     | Crear un nuevo modelo desde formulario| POST   | http://localhost:8080/php/serviciosWeb/REST/store.php|
| destroy   | Eliminar un modelo específico         | DELETE | http://localhost:8080/php/serviciosWeb/REST/index.php?api/destroy/{id}|

http://localhost:8080/php/apirestapelo/REST/index.php?api/login POST auth
