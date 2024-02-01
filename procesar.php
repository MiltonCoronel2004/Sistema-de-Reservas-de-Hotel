<?php 
// Verifica si se ha recibido submit desde el front
if(isset($_POST["submit"])) {


  // Incluye el modelo "Reserva"
  include("Models/Reservas.php");
  
  // Abre una sesion para guardar mensajes posteriormente
  session_start();

  // Guarda en variables lo recibido por metodo post.
  $cliente = htmlspecialchars($_POST["cliente"]);
  $habitacion = $_POST["habitacion"];
  $fechaEntrada = $_POST["fechaEntrada"];
  $fechaSalida = $_POST["fechaSalida"];


  // Verifica si no se a seleccionado nada en "habitacion" y usa la sesion para devolver un mensaje
  if($habitacion == "undefined") {
    $_SESSION['mensaje'] = "Seleccione una habitación para reservar.";
    // Devuelve al inicio con el mensaje.
    header("Location: index.php");
  } else {
    // En caso contrario, que si este definida la habitacion procede a crear un nuevo objeto con la plantilla reserva y con los datos recibidos por post.
    $reserva = new Reserva($cliente, $habitacion, $fechaEntrada, $fechaSalida);


    // Usa el metodo "validarDisponibilidad" de la clase Reserva para verificar que la habitacion este disponible en el periodo ingresado y si la fecha es valida. Si la fecha esta ocupada o es invalida el metodo devuelve true.
    if ($reserva->validarDisponibilidad($habitacion, $fechaEntrada, $fechaSalida)) {

      // Establece el mensaje en la sesión y devuelve al inicio.
      $_SESSION['mensaje'] = "Fechas invalidas o no disponibles.";
      header("Location: index.php");

    } else {
        // En caso contrario, que devuelva false, es decir la habitacion no esta ocupda y la fecha no esta mal ingresada, procede a la creación de la reserva con el metodo crearReserva.
        if($reserva->crearReserva($cliente, $habitacion, $fechaEntrada, $fechaSalida)) {
          
          $_SESSION['mensaje'] = "Se ha reservado exitosamente.";
          header("Location: index.php");

        }
    }

  }
  
  
} else {
  // Si se intentara acceder al archivo por URL como no se recibe submit devuelve al inicio.
  header("Location: index.php");
}
