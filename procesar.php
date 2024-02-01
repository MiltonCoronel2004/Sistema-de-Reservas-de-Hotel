<?php 
if(isset($_POST["submit"])) {



  include("Models/Reservas.php");

  session_start();

  $cliente = htmlspecialchars($_POST["cliente"]);
  $habitacion = $_POST["habitacion"];
  $fechaEntrada = $_POST["fechaEntrada"];
  $fechaSalida = $_POST["fechaSalida"];

  if($habitacion == "undefined") {
    $_SESSION['mensaje'] = "Seleccione una habitación para reservar.";
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

        }
    }

  }
  
  
} else {
  header("Location: index.php");
}
