<?php // views/muestraListadoAlbumes.php

$titulo = 'intérpretes encontrados';

ob_start();
?>

    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>
                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                    Temas:
                    <small>Resultado de la búsqueda</small>
                </h1>
                <p class="lead">Resultados de la búsqueda de sus temas preferidos.</p>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <?php
                    if (count($favoritos_arr) > 0):
                        // Hay temas
                        print '<div class="panel panel-default">';
                        print '  <table class="table table-striped table-condensed">';
                        foreach ($favoritos_arr as $tema) {
                            if (count($tema['album']['images']) > 2) {
                                $imagen = $tema['album']['images'][2]['url'];
                            } else {
                                $imagen = '';
                            }
                            $name = $tema['name'];
                            $id = $tema['id'];
                            print <<< ____________________MARCA_FINAL
                    <tr>
                      <td>
                        <a href='tema/$id'>
                          <button class="btn btn-primary" type="button">
                            <img src='$imagen' width='64' height='64' alt='Imagen $name' title='$name'>
                          </button>
                        </a>
                      </td>
                      <td><h2>$name</h2></td>
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
                  <a href="temas">
                    <button type="button" class="btn btn-primary btn-lg">Nueva Búsqueda</button>
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
