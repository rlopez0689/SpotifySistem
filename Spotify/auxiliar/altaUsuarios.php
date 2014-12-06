<?php // auxiliar/altaUsuarios

require __DIR__ . '/../src/config.php';
require __DIR__ . '/../src/model.php';

use \MiW\PracticaPHP\Model\datosLocales;

$num_ok = 0;
$num_ok += datosLocales::inserta_usuario('user1', '*user1*', TRUE);  // Usuario administrador
$num_ok += datosLocales::inserta_usuario('user2', '*user2*', FALSE);

print ($num_ok) ? "Insertado(s) $num_ok usuario(s)" : 'No se ha insertado ningún usuario';
print "\n";