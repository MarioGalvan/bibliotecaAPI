<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;





$app->get('/api/autores/all', function (Request $request, Response $response) {

    $sql =  "SELECT * FROM autores";

    try {

        $cnx = new Conexion();
        $query = $cnx->Conectar();
        $resultado = $query->query($sql);
        if ($resultado->rowCount() > 0) {
            $productos = $resultado->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($productos);
        } else {
            echo json_encode("no existen autores registrados");
        }
    } catch (PDOException $error) {

        $errores =  array(
            "text" => $error->getMessage()
        );

        return json_encode($errores);
    }
});





$app->get('/api/autores/id={id}', function (Request $request, Response $response) {

    $id= $request->getAttribute('id');

    $sql =  "SELECT * FROM autores where id = '$id' ";

    try {

        $cnx = new Conexion();
        $query = $cnx->Conectar();
        $resultado = $query->query($sql);
        if ($resultado->rowCount() > 0) {
            $clientes = $resultado->fetch(PDO::FETCH_ASSOC);
            echo json_encode($clientes);
        } else {
            echo json_encode("autor no esta registrado");
        }
    } catch (PDOException $error) {

        $errores =  array(
            "text" => $error->getMessage()
        );

        return json_encode($errores);
    }
});




$app->post('/api/autores/add', function (Request $request, Response $response) {

    $id = $request->getParam('id');
    $nombre = $request->getParam('nombre');
    $nacionalidad = $request->getParam('nacionalidad');
   

    $verificarexiste = "SELECT * FROM autores where id = :id ";


    $sql =  "INSERT INTO autores (id,nombre,nacionalidad)
     VALUES (:id,:nombre,:nacionalidad) ";

    try {

        $cnx = new Conexion();
        $query = $cnx->Conectar();
        $resultado = $query->prepare($sql);
        $resultado->bindParam(':id', $id);
        $resultado->bindParam(':nombre', $nombre);
        $resultado->bindParam(':nacionalidad', $nacionalidad);
    



        $comprobarexiste=$query->prepare($verificarexiste);
        $comprobarexiste->bindParam(':id',$id);
        $comprobarexiste->execute();

        if($comprobarexiste->fetchColumn() == 0){
          if ($resultado->execute()) {
              echo json_encode("Registrado correctamente");
          } else {
              echo json_encode("no fue registrado");
          }
        }else {
          echo json_encode("00");
        }


    } catch (PDOException $error) {

        $errores =  array(
            "text" => $error->getMessage()
        );

        return json_encode($errores);
    }
});




$app->put('/api/autores/update', function (Request $request, Response $response) {

    $id = $request->getParam('id');
    $nombre = $request->getParam('nombre');
    $nacionalidad = $request->getParam('nacionalidad');
 

    $sql =  "UPDATE autores SET
    nombre= :nombre,
    nacionalidad = :nacionalidad
     WHERE id = :id ";

    try {

        $cnx = new Conexion();
        $query = $cnx->Conectar();
        $resultado = $query->prepare($sql);
        $resultado->bindParam(':nombre', $nombre);
        $resultado->bindParam(':nacionalidad', $nacionalidad);
        $resultado->bindParam(':id', $id);

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



    $sql =  "DELETE FROM autores where id = :id";

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
