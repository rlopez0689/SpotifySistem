<?php  // views/muestraTema.php

$titulo = 'tema encontrado';

ob_start();

if (empty($infoAlbum)):
    print <<< '____MARCA_FINAL'
      <div class="container">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h1>
                <small><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span> Álbum:</small>
                <mark>Álbum no encontrado</mark>
            </h1>
          </div>
          <div class="panel-body">
              <div class="alert alert-danger alert-dismissible fade in" role="alert">
                      <button type="button" class="close" data-dismiss="alert">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                      </button>
                      <h4>¡No se han encontrado resultados!</h4>
              </div>
              <p>
                <a href="albumes">
                  <button type="button" class="btn btn-primary btn-lg">Nueva Búsqueda</button>
                </a>
              </p>
          </div>
        </div>
      </div>
____MARCA_FINAL;
else:
    ?>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>
                    <small><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span> Álbum:</small>
                    <a
                        href="album/<?=$infoAlbum['id']?>"><mark><?= $infoAlbum['name'] ?></mark></a>
                    <a href="favoritos/albumes/nuevo/<?= $infoAlbum['id'] ?>">
                        <?php
                        if($favorito_album){
                            print '<span class="glyphicon glyphicon-star" aria-hidden="true" title="Desmarcar Favorito"></span>';
                        }
                        else{
                            print '<span class="glyphicon glyphicon-star-empty" aria-hidden="true" title="Marcar Favorito"></span>';
                        }
                        ?>
                    </a>
                    <br>
                    <small>Artista: <a
                            href="artista/<?= $artist[0]['id'] ?>"><?= $artist[0]['name'] ?></a>
                    </small>
                </h1>
            </div>
            <div class="panel-body">

                <div class="row">
                    <div class="col-md-4">
                        <p class="text-left">
                            <img src="<?= @$infoAlbum['images'][0]['url'] ?>" class="img-responsive"
                                 alt="<?= 'Imagen ' . $infoAlbum['name'] ?>"><br>
                            <a href='<?= $infoAlbum['external_urls']['spotify'] ?>' target='_blank'
                               title='Escuchar en Spotify'><img src="public/logoSpotify.png"
                                                                class="img-responsive" alt="Spotify"></a>
                        </p>
                    </div>
                    <div class="col-md-8">
                        <?php
                        require 'muestraListadoTemasAlbumes.php';
                        ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
<?php
endif;

$contenido = ob_get_clean();

include 'layout.php';
