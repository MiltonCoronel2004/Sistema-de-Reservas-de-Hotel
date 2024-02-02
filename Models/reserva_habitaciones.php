<?php 
  include("Connection.php");
  class Habitacion {
    public $habitacion;
    // public $tipo;
    // public $capacidad;
    private $connection;

    public function __construct($habitacion) {
      $this->habitacion = $habitacion;
      $this->connection = new Connection("localhost", "root", "", "hotel");
    }
    
    public function listarHabitaciones() {
      $query = "SELECT * FROM habitaciones";
      $result = $this->connection->query($query);
      return $result;
    }

    public function validarExistencia($habitacion) {
      $query = "SELECT numero FROM habitaciones WHERE numero = '$habitacion'";
      $result = $this->connection->query($query);
      return ($result->num_rows > 0);
    }
    
  }


  
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
      $this->fechaSalida = $fechaSalida;
      $this->connection = new Connection("localhost", "root", "", "hotel");
    }


    public function validarDisponibilidad($habitacion, $fechaEntrada, $fechaSalida) {

      $query = "SELECT * FROM reservas WHERE habitacion = '$habitacion' AND (entrada <= '$fechaSalida' AND salida >= '$fechaEntrada')";

      $resultado = $this->connection->query($query);

      if ($resultado->num_rows == 0 || $fechaEntrada > $fechaSalida) {
          return false;
      } else {
          return true;
      }
    }
  

    public function crearReserva($cliente, $habitacion, $fechaEntrada, $fechaSalida) {
      $query = "INSERT INTO reservas (cliente, habitacion, entrada, salida) VALUES (?,?,?,?)";

      $resultado = $this->connection->queryPrepare($query, $cliente, $habitacion, $fechaEntrada, $fechaSalida);

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