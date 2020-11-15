<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;





$app->get('/api/prestamos/all', function (Request $request, Response $response) {

    $sql =  "SELECT * FROM prestamos";

    try {

        $cnx = new Conexion();
        $query = $cnx->Conectar();
        $resultado = $query->query($sql);
        if ($resultado->rowCount() > 0) {
            $productos = $resultado->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($productos);
        } else {
            echo json_encode("no existen prestamos registrados");
        }
    } catch (PDOException $error) {

        $errores =  array(
            "text" => $error->getMessage()
        );

        return json_encode($errores);
    }
});





$app->get('/api/prestamos/id={id}', function (Request $request, Response $response) {

    $id= $request->getAttribute('id');

    $sql =  "SELECT * FROM prestamos where id = '$id' ";

    try {

        $cnx = new Conexion();
        $query = $cnx->Conectar();
        $resultado = $query->query($sql);
        if ($resultado->rowCount() > 0) {
            $clientes = $resultado->fetch(PDO::FETCH_ASSOC);
            echo json_encode($clientes);
        } else {
            echo json_encode("prestamo no esta registrado");
        }
    } catch (PDOException $error) {

        $errores =  array(
            "text" => $error->getMessage()
        );

        return json_encode($errores);
    }
});




$app->post('/api/prestamos/add', function (Request $request, Response $response) {

    $id = $request->getParam('id');
    $id_libro = $request->getParam('id_libro');
    $fecha_entrega = $request->getParam('fecha_entrega');
    $fecha_prestamo = $request->getParam('fecha_prestamo');
    $estado = $request->getParam('estado');
   
    
    $sqlPrestamo = "SELECT * FROM prestamos where id = :id";
    $sqlLibro  = "SELECT * FROM libros where id_libro = :id_libro";


    $sql =  "INSERT INTO `prestamos`(`id`, `id_libro`, `fecha_prestamo`, `fecha_entrega`, `estado`)
     VALUES (:id,:id_libro,:fecha_prestamo, :fecha_entrega, :estado) ";

    try {

        $cnx = new Conexion();
        $query = $cnx->Conectar();
        $resultado = $query->prepare($sql);
        $resultado->bindParam(':id', $id);
        $resultado->bindParam(':id_libro', $id_libro);
        $resultado->bindParam(':fecha_prestamo', $fecha_prestamo);
        $resultado->bindParam(':fecha_entrega', $fecha_entrega);
        $resultado->bindParam(':estado', $estado);


        //xiste prestamo
        $verificarexistePrestamo=$query->prepare($sqlPrestamo);
        $verificarexistePrestamo->bindParam(':id',$id);
        $verificarexistePrestamo->execute();

        //Existe libro
        $verificarexisteLibro=$query->prepare($sqlLibro);
        $verificarexisteLibro->bindParam(':id_libro',$id_libro);
        $verificarexisteLibro->execute();



        if($verificarexisteLibro->fetchColumn() >0 ){

            if($verificarexistePrestamo->fetchColumn() ==0){
                if ($resultado->execute()) {
                    echo json_encode("Registrado correctamente");
                } else {
                    echo json_encode("no se registro");
                }

            }else{
                echo json_encode("este id de prestamo ya existe");
            }
        }else{
            echo json_encode("este libro no existe");
        }

    


    } catch (PDOException $error) {

        $errores =  array(
            "text" => $error->getMessage()
        );

        return json_encode($errores);
    }
});




$app->put('/api/prestamos/update', function (Request $request, Response $response) {

    $id = $request->getParam('id');
    $fecha_prestamo = $request->getParam('fecha_prestamo');
    $fecha_entrega = $request->getParam('fecha_entrega');
    $estado = $request->getParam('estado');
 

    $sql =  "UPDATE prestamos SET
    fecha_prestamo= :fecha_prestamo,
    fecha_entrega = :fecha_entrega,
    estado  = :estado
     WHERE id = :id ";

    try {

        $cnx = new Conexion();
        $query = $cnx->Conectar();
        $resultado = $query->prepare($sql);
        $resultado->bindParam(':fecha_prestamos', $fecha_prestamo);
        $resultado->bindParam(':fecha_entrega', $fecha_entrega);
        $resultado->bindParam(':estado', $estado);
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






$app->delete('/api/prestamos/remove/id={id}', function (Request $request, Response $response) {

    $id = $request->getAttribute('id');



    $sql =  "DELETE FROM prestamos where id = :id";

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
