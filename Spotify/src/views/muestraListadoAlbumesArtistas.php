<div class="panel panel-default">
  <div class="table-responsive">
    <table class="table table-striped table-condensed">
      <?php
        foreach ($albumes as $album) {
            // var_dump($albun);
            if (count($album['images']) > 2) {
                $imagen = $album['images'][2]['url'];
            } else {
                $imagen = '';
            }
            $name = $album['name'];
            $id = $album['id'];
            print <<< ____________MARCA_FINAL
              <tr>
                <td>
                  <a href='album/$id'>
                    <img src='$imagen' width='64' height='64' alt='Imagen $name' title='$name'>
                  </a>
                </td>
                <td>$name</td>
              </tr>
____________MARCA_FINAL;
        }
      ?>
    </table>
  </div>
</div>
