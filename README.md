# bibliotecaAPI

se remplaza http://localhost/ por la url del servidor donde quieras hacer el deploy

SERVICIOS

Login
url: http://localhost/BILIOTECAPI/public/ApiAdministracion/api/administracion/login
type: POST
attr: usuario, clave
_________________________
AUTORES 
url: http://localhost/BILIOTECAPI/public/ApiAutores/api/autores/all   GET
urlSearchById: http://localhost/BILIOTECAPI/public/ApiAutores/api/autores/id={id}  GET
urladd: http://localhost/BILIOTECAPI/public/ApiAutores/api/autores/add     POST{objAutor}
urlremove: http://localhost/BILIOTECAPI/public/ApiAutores/api/autores/remove/id=
urlupdate:  http://localhost/BILIOTECAPI/public/ApiAutores/api/autores/update  PUT

LIBROS
url: http://localhost/BILIOTECAPI/public/ApiLibros/api/libros/all  GET
urlSearchById: http://localhost/BILIOTECAPI/public/ApiLibros/api/libros/id= GET
urladd: http://localhost/BILIOTECAPI/public/ApiLibros/api/libros/add
urlremove: http://localhost/BILIOTECAPI/public/ApiLibros/api/libros/remove/id=
urlupdate: http://localhost/BILIOTECAPI/public/ApiLibros/api/libros/update


PRESTAMOS
url: http://localhost/BILIOTECAPI/public/ApiPrestamos/api/prestamos/all  GET
urlSearchById:  http://localhost/BILIOTECAPI/public/ApiPrestamos/api/prestamos/id= GET
urladd: http://localhost/BILIOTECAPI/public/ApiPrestamos/api/prestamos/add
urlremove: http://localhost/BILIOTECAPI/public/ApiPrestamos/api/prestamos/remove/id=
urlupdate:  http://localhost/BILIOTECAPI/public/ApiPrestamos/api/prestamos/update

