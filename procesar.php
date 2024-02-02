<?php 
session_start();
if(isset($_POST["submit"]) && isset($_POST["cliente"]) && isset($_POST["habitacion"]) && isset($_POST["fechaEntrada"]) && isset($_POST["fechaSalida"])) {

  if(!empty($_POST["cliente"]) && !empty($_POST["habitacion"]) && !empty($_POST["fechaEntrada"]) && !empty($_POST["fechaEntrada"])) {

    include("Models/reserva_habitaciones.php");


    $cliente = htmlspecialchars($_POST["cliente"]);
    $habitacion = $_POST["habitacion"];
    $fechaEntrada = $_POST["fechaEntrada"];
    $fechaSalida = $_POST["fechaSalida"];
  
    $validarExistencia = (new Habitacion($habitacion))->validarExistencia($habitacion);
  
  
    if(!$validarExistencia) {
      $_SESSION['mensaje'] = "Habitación inexistente.";
      header("Location: index.php");
    } else {
      $reserva = new Reserva($cliente, $habitacion, $fechaEntrada, $fechaSalida);
  
      if ($reserva->validarDisponibilidad($habitacion, $fechaEntrada, $fechaSalida)) {
  
        $_SESSION['mensaje'] = "Fechas invalidas o no disponibles.";
        header("Location: index.php");
  
      } else {
          if($reserva->crearReserva($cliente, $habitacion, $fechaEntrada, $fechaSalida)) {
            
            $_SESSION['mensaje'] = "Se ha reservado exitosamente.";
            header("Location: index.php");
  
          } else {
            $_SESSION["mensaje"] = "Error al crear la reserva";
          }
      }
  
    }
    
  } else {
    $_SESSION['mensaje'] = "Complete los datos para continuar.";
    header("Location: index.php");
  }

  
} else {
  $_SESSION['mensaje'] = "Complete los datos para continuar.";
  header("Location: index.php");
}
