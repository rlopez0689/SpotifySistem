<?php // views/muestraListadoUsuarios.php

$titulo = 'listado de usuarios';

ob_start();
?>

    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>
                    <span class="glyphicon glyphicon-wrench" aria-hidden="true"></span>
                    Usuarios:
                    <small>usuarios registrados en el sistema</small>
                </h1>
                <p class="lead">Gestión de los usuarios del sistema.</p>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <?php
                    if (count($usuarios) > 0):
                        // Hay usuarios
                        print '<div class="panel panel-default">';
                        print '  <table class="table table-striped table-condensed">';
                        print '  <tr><th>Usuario</th><th>¿admin?</th><th>E-mail</th><th>Fecha<br>creación</th><th></th></tr>';
                        foreach ($usuarios as $usuario) {
                            // var_dump($usuario);
                            $name = $usuario['username'];
                            if ($usuario['esAdmin'] == 1):
                                $esAdmin = '<span class="glyphicon glyphicon-ok verde" aria-hidden="true"></span>';
                            else:
                                $esAdmin = '<span class="glyphicon glyphicon-ban-circle rojo" aria-hidden="true"></span>';
                            endif;

                            print <<< ____________________MARCA_FINAL
                    <tr>
                      <td>
                        <a href='usuario/mostrar/$name'>
                          <h4>$name</h4>
                        </a>
                      </td>
                      <td>$esAdmin</td> 
                      <td>$usuario[email]</td>
                      <td>$usuario[create_time]</td>
                      <td>
                        <a href='usuario/eliminar/$name' title='Eliminar usuario'>
                          <span class="glyphicon glyphicon-trash" aria-hidden="true"> </span>
                        </a>
                      </td>
                    </tr>
____________________MARCA_FINAL;
                        }
                        print '  </table>';
                        print '</div>';
                    else:
                        print <<< '________________MARCA_FINAL'
                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                  <button type="button" class="close" data-dismiss="alert">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                  </button>
                  <h4>¡No se han encontrado resultados!</h4>
                </div>
                <p>
                  <a href="">
                    <button type="button" class="btn btn-primary btn-lg">Inicio</button>
                  </a>
                </p>
________________MARCA_FINAL;
                    endif;
                    ?>
                </div>
            </div>
        </div>

    </div>

<?php

$contenido = ob_get_clean();

include 'layout.php';
