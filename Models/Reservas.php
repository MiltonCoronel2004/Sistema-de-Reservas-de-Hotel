<?php 
  include("Connection.php");
  class Reserva {
    // Se establecen los atributos de la Reserva
    public $cliente;
    public $habitacion;
    public $fechaEntrada;
    public $fechaSalida;
    private $connection;
     // Se ejecuta un constructor para declarar las variables de la clase y se un nuevo objeto para crear una conexion a la db.
    public function __construct($cliente, $habitacion, $fechaEntrada, $fechaSalida) {
      $this->cliente = $cliente;
      $this->habitacion = $habitacion;
      $this->fechaEntrada = $fechaEntrada;
      $this->fechaEntrada = $fechaSalida;
      $this->connection = new Connection("localhost", "root", "", "hotel");
    }

    //Función para comprobar si la habitacion esta disponible en las fechas de la base de datos.
    public function validarDisponibilidad($habitacion, $fechaEntrada, $fechaSalida) {
      // Consulta a realizar en la base de datos
      $query = "SELECT * FROM reservas WHERE habitacion = '$habitacion' AND (entrada <= '$fechaSalida' AND salida >= '$fechaEntrada')";
      // Se usa el metodo query de la clase connection para ejecutar la consulta
      $resultado = $this->connection->query($query);

      // Si la cantidad de registros que coinciden con la consulta es mayor a 0 (o sea, existe) o si la fecha de entrada es mayor a la salida retorna true y si no se cumple nada retorna false.
      if ($resultado->num_rows > 0 || $fechaEntrada > $fechaSalida) {
          return true;
      } else {
          return false;
      }
    }
  


    // Metodo para crear la reserva, si pasa la funcion anterior, se ejecuta creaerReserva para insertar los datos en la db.
    public function crearReserva($cliente, $habitacion, $fechaEntrada, $fechaSalida) {
      $query = "INSERT INTO reservas (cliente, habitacion, entrada, salida) VALUES ('$cliente', '$habitacion', '$fechaEntrada', '$fechaSalida')";

      $resultado = $this->connection->query($query);

      if($resultado) {
        return true;
      }
    }

    // Metodo para listar las reservas en el front, ordenado por el check-in mas reciente.
    public function listarReservas() {
      $query = "SELECT * FROM reservas ORDER BY entrada";
      $resultado = $this->connection->query($query);
      
      return $resultado;
    }
 
  }