<?php // controllers.php

namespace MiW\PracticaPHP;

require 'model.php';

use \MiW\PracticaPHP\Model\datosExternos;
use \MiW\PracticaPHP\Model\datosLocales;

/**
 * Muestra la página principal (búsquedas)
 * @param type $param
 */
function principalAction()
{
    require 'views/principal.php';
}

/**
 * Muestra el formulario para buscar un artista
 */
function buscaArtistasAction()
{
    require 'views/buscaArtista.php';
}

/**
 * Procesa el formulario para buscar un artista concreto
 * Busca un artista en Spotify y muestra los resultados
 * @param string $artista
 */
function buscaArtistaAction($artista)
{
    $artistas = datosExternos::buscarArtista($artista);

    require 'views/muestraListadoArtistas.php';
}

/**
 * Muestra el formulario para buscar un artista
 */
function buscaAlbumesAction()
{
    require 'views/buscaAlbum.php';
}

/**
 * Procesa el formulario para buscar un artista concreto
 * Busca un artista en Spotify y muestra los resultados
 * @param string $artista
 */
function buscaAlbumAction($album)
{
    $albumes = datosExternos::buscarAlbum($album);
    require 'views/muestraListadoAlbumes.php';
}

/**
 * Muestra el formulario para buscar un tema
 */
function buscaTemasAction()
{
    require 'views/buscaTema.php';
}

/**
 * Procesa el formulario para buscar un tema concreto
 * Busca un tema en Spotify y muestra los resultados
 * @param string $tema
 */
function buscaTemaAction($tema)
{
    $temas = datosExternos::buscarTema($tema);
    require 'views/muestraListadoTemas.php';
}

/**
 * Muestra la información de un artista identificado por $artistaId
 * @param string $artistaId Identificador del artista en Spotify
 */
function mostrarArtistaAction($artistaId, $limite = 5)
{
    $id_user = datosLocales::recupera_usuario($_SESSION['usuario'])['id'];
    $infoArtista = datosExternos::obtenerArtista($artistaId);
    $albumes = datosExternos::getArtistaAlbumes($artistaId, $limite);
    $favoritos = datosLocales::verificaFavortio($id_user,$artistaId);
    require 'views/muestraArtista.php';
}


/**
 * Muestra la información de un álbum
 * A los tracks se le agrega un nuevo campo 'favorito', el cual es 0 si NO se encuentra en favoritos
 * 1 si se encuentra.
 * @param string $albumId Identificador del álbum en Spotify
 */
function mostrarAlbumAction($albumId)
{
    $id_user = datosLocales::recupera_usuario($_SESSION['usuario'])['id'];
    $infoAlbum = datosExternos::obtenerAlbum($albumId);
    $temas = $infoAlbum['tracks']['items'];

    for($i=0;$i<count($temas);$i++){//Temas favorito
        $temas[$i]['favorito'] = 0;
        if(datosLocales::verificaFavortio($id_user,$temas[$i]['id']))
            $temas[$i]['favorito'] = 1;
    }

    $favoritos = datosLocales::verificaFavortio($id_user,$albumId);//Album favorito

    require 'views/muestraAlbum.php';
}

/**
 * Muestra la información de un tema
 * Al tema se le agrega el campo 'favorito', 0 si NO se encuentra en favoritos, 1 si se encuentra.
 * @param string $albumId Identificador del álbum en Spotify
 */
function mostrarTemaAction($temaId)
{
    $id_user = datosLocales::recupera_usuario($_SESSION['usuario'])['id'];
    $tema = datosExternos::obtenerTema($temaId);

    $tema['favorito'] = 0;
    if(datosLocales::verificaFavortio($id_user,$tema['id']))
        $tema['favorito'] = 1;

    $infoAlbum = $tema['album'];
    $artist = $tema['artists'];
    $favorito_album = datosLocales::verificaFavortio($id_user,$tema['album']['id']);

    $temas= [$tema];


    require 'views/muestraTema.php';
}

/**
 * Muestra los artistas elegidos como favortios
 * @param string $tipo : 'artistas', 'albumes', 'temas'.
 */
function mostrarFavoritosAction($tipo)
{
    $favoritos_arr = [];

    $id_user = datosLocales::recupera_usuario($_SESSION['usuario'])['id'];
    $favoritos_obtener = datosLocales::obtenerFavoritos($id_user, $tipo);

    if ($tipo == 'artistas'){
        foreach ($favoritos_obtener as $favoritos) {
            array_push($favoritos_arr, datosExternos::obtenerArtista($favoritos['id_recurso']));
        }
        require 'views/muestraFavoritosArtistas.php';
    }
    elseif ($tipo == 'albumes'){
        foreach ($favoritos_obtener as $favoritos) {
            array_push($favoritos_arr, datosExternos::obtenerAlbum($favoritos['id_recurso']));
        }
        require 'views/muestraFavoritosAlbumes.php';
    }
    elseif ($tipo == 'temas'){
        foreach ($favoritos_obtener as $favoritos) {
            array_push($favoritos_arr, datosExternos::obtenerTema($favoritos['id_recurso']));
        }
        require 'views/muestraFavoritosTemas.php';
    }
}

function gestionarFavoritosAction($tipo, $id_recurso){
    $id_user = datosLocales::recupera_usuario($_SESSION['usuario'])['id'];
    datosLocales::gestionaFavoritos($id_user, $id_recurso, $tipo);

    if ($tipo == 'artistas')
        header("Location: ".URL_BASE."artista/".$id_recurso);
    elseif ($tipo == 'albumes')
        header("Location: ".URL_BASE."album/".$id_recurso);
    elseif ($tipo == 'temas')
        header("Location: ".URL_BASE."tema/".$id_recurso);
}

function eliminaFavoritosAction($tipo, $id_recurso){
    $id_user = datosLocales::recupera_usuario($_SESSION['usuario'])['id'];
    datosLocales::gestionaFavoritos($id_user, $id_recurso, $tipo);
    echo $tipo;
    if ($tipo == 'artistas')
        header("Location: ".URL_BASE."favoritos/artistas");
    elseif ($tipo == 'albumes')
        header("Location: ".URL_BASE."favoritos/albumes");
    elseif ($tipo == 'temas')
        header("Location: ".URL_BASE."favoritos/temas");
}


/**
 * Comprueba si el usuario y la contraseña son correctos
 * @param string $usuario Usuario del sistema
 * @param string $pclave Palabra clave del usuario
 * @return boolean Resultado de la comprobación
 */
function loginAction($usuario, $pclave)
{
    $datos = datosLocales::recupera_usuario($usuario);
    if (!empty($datos) and password_verify($pclave, $datos['password'])) {
        // var_dump($datos);
        $_SESSION['usuario'] = $usuario;
        $_SESSION['esAdmin'] = ($datos['esAdmin'] === '1');
        $resultado = TRUE;
        // var_dump($_SESSION);
    } else
        $resultado = FALSE;

    return $resultado;
}

/**
 * Termina la sesión actual
 */
function logoutAction()
{
    $_SESSION = array();
    session_destroy();

    return TRUE;
}

/**
 * Genera un listado de los usuarios del sistema
 */
function listadoUsuariosAction()
{
    $usuarios = datosLocales::recupera_todos_usuarios();
    $usuario_log = datosLocales::recupera_usuario($_SESSION['usuario'])['id'];
    require 'views/muestraListadoUsuarios.php';
}

/**
 * Muestra un formulario para dar de alta un nuevo usuario
 */
function muestraNuevoUsuarioAction()
{
    require 'views/muestraNuevoUsuario.php';
}

/**
 * Inserta un nuevo usuario y muestra el listado de usuarios
 * @param type $usuario
 */
function insertarNuevoUsuarioAction($usuario)
{
    @datosLocales::inserta_usuario($usuario['username'], $usuario['password'], $usuario['esAdmin'], $usuario['email']);
    listadoUsuariosAction();
}

/**
 * elimina un usuario y muestra el listado de usuarios
 * @param type $usuario
 */
function eliminarUsuarioAction($usuario){
    @datosLocales::borrar_usuario($usuario);
    listadoUsuariosAction();
}

/**
 * Error de acceso (permisos insuficientes)
 * @param string $path
 */
function errorAccesoAction($path)
{
    require 'views/errorAcceso.php';
}

/**
 * Ruta sin implementar
 * @param string $path
 */
function sinImplementarAction($path)
{
    require 'views/noImplementado.php';
}