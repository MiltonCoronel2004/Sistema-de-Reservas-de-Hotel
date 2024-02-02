<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>Reservas</title>
</head>

<body>
    <div class="container mt-5">
       <div class="row">
        <div class="col-6">
          <div class="card flex-column">
              <div class="card-header bg-primary text-white">
                  <h4 class="mb-0">Formulario de Reserva</h4>
              </div>
              <div class="card-body">
                  <form action="procesar.php" method="post">
                      <div class="mb-3">
                          <label for="cliente" class="form-label">Cliente</label>
                          <input type="text" name="cliente" required autocomplete="off" class="form-control">
                      </div>
                      <div class="mb-3">
                        <label for="habitacion" class="form-label">Habitación</label>
                        <select name="habitacion" required class="form-select">
                          <?php
                            include("Models/reserva_habitaciones.php");
                            $habitaciones = new Habitacion("", "", "");
                            $result = $habitaciones->listarHabitaciones();

                            while($row = $result->fetch_assoc()) {
                              echo "<option value='{$row['numero']}'>{$row['numero']} - {$row['tipo']} - {$row['capacidad']}</option>";
                            }
                          ?>
                        </select>
                      </div>
                      <div class="mb-3">
                          <label for="fechaEntrada" class="form-label">Fecha de Entrada</label>
                          <input type="date" name="fechaEntrada" required class="form-control">
                      </div>
                      <div class="mb-3">
                          <label for="fechaSalida" class="form-label">Fecha de Salida</label>
                          <input type="date" name="fechaSalida" required class="form-control">
                      </div>
                      <div class="d-flex justify-content-between align-items-center">
                        <button type="submit" name="submit" class="btn btn-success">Reservar</button>

                        <?php  
                          if(isset($_SESSION["mensaje"])) {
                            ?> 
                            <p id="mensaje"><?php echo $_SESSION["mensaje"] ?></p>
                            <script>
                              const mensaje = document.getElementById('mensaje')
                              setInterval(function() {
                                mensaje.style.display = 'none'
                              }, 4000)
                            </script>
                            <?php
                            unset($_SESSION['mensaje']);
                          }
                        ?> 
                      </div>
                  </form>
              </div>
          </div>
        </div>

        <div class="col-6"> 
          <div class="div">
          <table class="table table-striped table-bordered text-center">
            <thead class="table-dark">
              <th>N°</th>
              <th>Cliente</th>
              <th>Habitación N°</th>
              <th>Entrada</th>
              <th>Salida</th>
            </thead>
            <tbody>
                <?php
                $reserva = new Reserva("", "", "", "");
                $result = $reserva->listarReservas();

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['id']}</td>";
                    echo "<td>{$row['cliente']}</td>";
                    echo "<td>{$row['habitacion']}</td>";

                    $entradaFormatted = date('d/m/Y', strtotime($row['entrada']));
                    $salidaFormatted = date('d/m/Y', strtotime($row['salida']));

                    echo "<td>{$entradaFormatted}</td>";
                    echo "<td>{$salidaFormatted}</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>          
            </table>							
          </div>
        </div>
       </div>
    </div>
</body>
</html>



