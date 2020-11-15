<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;





$app->get('/api/libros/all', function (Request $request, Response $response) {

    $sql =  "SELECT * FROM libros";

    try {

        $cnx = new Conexion();
        $query = $cnx->Conectar();
        $resultado = $query->query($sql);
        if ($resultado->rowCount() > 0) {
            $productos = $resultado->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($productos);
        } else {
            echo json_encode("no existen libros registrados");
        }
    } catch (PDOException $error) {

        $errores =  array(
            "text" => $error->getMessage()
        );

        return json_encode($errores);
    }
});





$app->get('/api/libros/id={id}', function (Request $request, Response $response) {

    $id= $request->getAttribute('id');

    $sql =  "SELECT * FROM libros where id_libro = '$id' ";

    try {

        $cnx = new Conexion();
        $query = $cnx->Conectar();
        $resultado = $query->query($sql);
        if ($resultado->rowCount() > 0) {
            $clientes = $resultado->fetch(PDO::FETCH_ASSOC);
            echo json_encode($clientes);
        } else {
            echo json_encode("libro no esta registrado");
        }
    } catch (PDOException $error) {

        $errores =  array(
            "text" => $error->getMessage()
        );

        return json_encode($errores);
    }
});




$app->post('/api/libros/add', function (Request $request, Response $response) {

    $id_libro = $request->getParam('id_libro');
    $id_autor = $request->getParam('id_autor');
    $titulo = $request->getParam('titulo');
    $editorial = $request->getParam('editorial');
   

    $sqlLibro = "SELECT * FROM libros where id_libro = :id_libro";
    $sqlAutor  = "SELECT * FROM autores where id = :id_autor";


    $sql =  "INSERT INTO libros (id_libro,id_autor,titulo,editorial)
     VALUES (:id_libro,:id_autor,:titulo, :editorial) ";

    try {

        $cnx = new Conexion();
        $query = $cnx->Conectar();
        $resultado = $query->prepare($sql);
        $resultado->bindParam(':id_libro', $id_libro);
        $resultado->bindParam(':id_autor', $id_autor);
        $resultado->bindParam(':titulo', $titulo);
        $resultado->bindParam(':editorial', $editorial);
    


        //xiste autor
        $verificarexisteAutor=$query->prepare($sqlAutor);
        $verificarexisteAutor->bindParam(':id_autor',$id_autor);
        $verificarexisteAutor->execute();

        //Existe libro
        $verificarexisteLibro=$query->prepare($sqlLibro);
        $verificarexisteLibro->bindParam(':id_libro',$id_libro);
        $verificarexisteLibro->execute();



        if($verificarexisteAutor->fetchColumn() >0 ){

            if($verificarexisteLibro->fetchColumn() ==0){
                if ($resultado->execute()) {
                    echo json_encode("Registrado correctamente");
                } else {
                    echo json_encode("no se registro");
                }

            }else{
                echo json_encode("este id de libro ya existe");
            }
        }else{
            echo json_encode("este autor no existe");
        }

    


    } catch (PDOException $error) {

        $errores =  array(
            "text" => $error->getMessage()
        );

        return json_encode($errores);
    }
});




$app->put('/api/autores/update', function (Request $request, Response $response) {

    $id_libro = $request->getParam('id_libro');
    $id_autor = $request->getParam('id_autor');
    $titulo = $request->getParam('titulo');
    $editorial = $request->getParam('editorial');

    $sql =  "UPDATE libros SET
    titulo= :titulo,
    editorial = :editorial
     WHERE id_libro = :id_libro ";

    try {

        $cnx = new Conexion();
        $query = $cnx->Conectar();
        $resultado = $query->prepare($sql);
        $resultado->bindParam(':titulo', $nombre);
        $resultado->bindParam(':editorial', $nacionalidad);

        if ($resultado->execute()) {
            echo json_encode("actualizado correctamente");
        } else {
            echo json_encode("no fue actualizado");
        }
    } catch (PDOException $error) {

        $errores =  array(
            "text" => $error->getMessage()
        );

        return json_encode($errores);
    }
});






$app->delete('/api/autores/remove/id={id}', function (Request $request, Response $response) {

    $id = $request->getAttribute('id');



    $sql =  "DELETE FROM libros where id_libro = :id";

    try {

        $cnx = new Conexion();
        $query = $cnx->Conectar();
        $resultado = $query->prepare($sql);
        $resultado->bindParam(':id', $id);

        if ($resultado->execute()) {
            echo json_encode("eliminado correctamente");
        } else {
            echo json_encode("no fue eliminado");
        }
    } catch (PDOException $error) {

        $errores =  array(
            "text" => $error->getMessage()
        );

        return json_encode($errores);
    }
});


?>
