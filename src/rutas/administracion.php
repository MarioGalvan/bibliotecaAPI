<?php


use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;


$app->post('/api/administracion/login', function (Request $request, Response $response) {

  $usuario  = $request->getParam('usuario');
  $clave = $request->getParam('clave');

  $verificarexiste = "SELECT COUNT(*) as cuantos from 
  administracion where usuario  = :usuario AND clave  = :clave ";




  try {

      $cnx = new Conexion();
      $query = $cnx->Conectar();
      $resultado = $query->prepare($verificarexiste);
      $resultado->bindParam(':usuario', $usuario);
      $resultado->bindParam(':clave', $clave);

      $resultado->execute();

      if($resultado->fetchColumn()>0){

        echo json_encode("01");

      }else {
        echo json_encode("02");
      }




  } catch (PDOException $error) {

      $errores =  array(
          "text" => $error->getMessage()
      );

      return json_encode($errores);
  }
});
