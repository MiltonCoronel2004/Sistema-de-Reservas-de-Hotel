<?php 
  include("Connection.php");
  class Reserva {
    public $cliente;
    public $habitacion;
    public $fechaEntrada;
    public $fechaSalida;
    private $connection;
    
    public function __construct($cliente, $habitacion, $fechaEntrada, $fechaSalida) {
      $this->cliente = $cliente;
      $this->habitacion = $habitacion;
      $this->fechaEntrada = $fechaEntrada;
      $this->fechaEntrada = $fechaSalida;
      $this->connection = new Connection("localhost", "root", "", "hotel");
    }

    public function validarDisponibilidad($habitacion, $fechaEntrada, $fechaSalida) {
      $query = "SELECT * FROM reservas WHERE habitacion = '$habitacion' AND (entrada <= '$fechaSalida' AND salida >= '$fechaEntrada')";



      $resultado = $this->connection->query($query);


      if ($resultado->num_rows > 0 || $fechaEntrada > $fechaSalida) {
          return true;
      } else {
          return false;
      }
    }
  



    public function crearReserva($cliente, $habitacion, $fechaEntrada, $fechaSalida) {
      $query = "INSERT INTO reservas (cliente, habitacion, entrada, salida) VALUES ('$cliente', '$habitacion', '$fechaEntrada', '$fechaSalida')";

      $resultado = $this->connection->query($query);

      if($resultado) {
        return true;
      }
    }

    public function listarReservas() {
      $query = "SELECT * FROM reservas ORDER BY entrada";
      $resultado = $this->connection->query($query);
      
      return $resultado;
    }
 
  }