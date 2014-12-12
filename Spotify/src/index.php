<?php // index.php

namespace MiW\PracticaPHP;

// Iniciamos la sesión
session_start();

require 'config.php';
require 'controllers.php';


if(filter_input(INPUT_SERVER, 'PATH_INFO')=="")
    $peticion = explode('/', filter_input(INPUT_SERVER, 'PATH_INFO')."/");
else
    $peticion = explode('/', filter_input(INPUT_SERVER, 'PATH_INFO'));

if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'GET') {
    switch ($peticion[1]) {
        case '':
            principalAction();
            break;

        case 'mas_info': # Información general sobre la aplicación
            sinImplementarAction(filter_input(INPUT_SERVER, 'PATH_INFO'));
            break;

        case 'artistas': # /artistas
            buscaArtistasAction();
            break;

        case 'artista': # /artista/{id}/{limite}
            if (!empty($peticion[2])):
                // El segundo parámetro (id) es el Id del artista
                // y el tercero (limite) el número de álbums recuperados
                (isset($peticion[3])) ?
                    mostrarArtistaAction($peticion[2], $peticion[3]) :
                    mostrarArtistaAction($peticion[2]);
            else:
                principalAction();
            endif;
            break;

        case 'albumes': # /artistas
            buscaAlbumesAction();
            break;

        case 'album': # /album/{id}
            if (!empty($peticion[2])):
                // El segundo parámetro (id) es el Id del álbum
                mostrarAlbumAction($peticion[2]);
            else:
                principalAction();
            endif;
            break;

        case 'temas': # /artistas
            buscaTemasAction();
            break;

        case 'tema': # /album/{id}
            if (!empty($peticion[2])):
                // El segundo parámetro (id) es el Id del álbum
                mostrarTemaAction($peticion[2]);
            else:
                principalAction();
            endif;
            break;

        case 'favoritos':
            if (isset($_SESSION['usuario'])):
                switch ($peticion[2]) {
                    case 'artistas': # /favoritos/artistas
                        if(isset($peticion[3]))
                            gestionarFavoritosAction($peticion[2], $peticion[4]);
                        else
                            mostrarFavoritosAction($peticion[2]);
                        break;
                    case 'albumes': # /favoritos/albumes
                        if(isset($peticion[3]))
                            gestionarFavoritosAction($peticion[2], $peticion[4]);
                        else
                            mostrarFavoritosAction($peticion[2]);
                        break;
                    case 'temas': # /favoritos/temas
                        if(isset($peticion[3]))
                            gestionarFavoritosAction($peticion[2], $peticion[4]);
                        else
                            mostrarFavoritosAction($peticion[2]);
                        break;
                    case 'elimina': #/favoritos/elimina/tipo/id
                        if(isset($peticion[3]))
                            eliminaFavoritosAction($peticion[3], $peticion[4]);
                    default :
                        sinImplementarAction(filter_input(INPUT_SERVER, 'PATH_INFO'));
                        break;
                }
            else:
                errorAccesoAction(filter_input(INPUT_SERVER, 'PATH_INFO'));
            endif;
            break;

        case 'logout': # /logout
            logoutAction();
            principalAction();
            break;

        case 'usuario':
            if ($_SESSION['esAdmin']):
                switch ($peticion[2]) {
                    case 'listado': # /usuario/listado
                        listadoUsuariosAction();
                        break;
                    case 'nuevo': # /usuario/nuevo
                        muestraNuevoUsuarioAction();
                        break;
                    case 'eliminar': # /usuario/nuevo
                        eliminarUsuarioAction($peticion[3]);
                        break;
                    default :
                        sinImplementarAction(filter_input(INPUT_SERVER, 'PATH_INFO'));
                        break;
                }
            else:
                errorAccesoAction(filter_input(INPUT_SERVER, 'PATH_INFO'));
            endif;
            break;

        default :
            sinImplementarAction(filter_input(INPUT_SERVER, 'PATH_INFO'));
            break;
    }

} elseif (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST') { // procesar formulario
    switch ($peticion[1]) {
        case 'buscaArtista': # /buscaArtista artista={string}
            if (filter_has_var(INPUT_POST, 'artista')):
                buscaArtistaAction(filter_input(INPUT_POST, 'artista'));
            else:
                principalAction();
            endif;
            break;

        case 'buscaAlbum': # /buscaArtista artista={string}
            if (filter_has_var(INPUT_POST, 'album')):
                buscaAlbumAction(filter_input(INPUT_POST, 'album'));
            else:
                principalAction();
            endif;
            break;

        case 'buscaTema': # /buscaArtista artista={string}
            if (filter_has_var(INPUT_POST, 'tema')):
                buscaTemaAction(filter_input(INPUT_POST, 'tema'));
            else:
                principalAction();
            endif;
            break;

        case 'login': # /login usuario={string} pclave={string}
            if (filter_has_var(INPUT_POST, 'usuario') && filter_has_var(INPUT_POST, 'pclave')):
                if (loginAction(filter_input(INPUT_POST, 'usuario'), filter_input(INPUT_POST, 'pclave'))):
                    principalAction();
                else:
                    // Página de error -> pedir login/passwd
                    errorAccesoAction(filter_input(INPUT_SERVER, 'PATH_INFO'));
                endif;
            else:
                principalAction();
            endif;
            break;

        case 'usuario':
            if ($_SESSION['esAdmin']):
                switch ($peticion[2]) {
                    case 'nuevo': # /usuario/nuevo usuario={array}
                        insertarNuevoUsuarioAction($_POST['usuario']);
                        break;
                    default :
                        sinImplementarAction(filter_input(INPUT_SERVER, 'PATH_INFO'));
                        break;
                }
            else:
                errorAccesoAction(filter_input(INPUT_SERVER, 'PATH_INFO'));
            endif;
            break;

        default :
            sinImplementarAction(filter_input(INPUT_SERVER, 'PATH_INFO'));
            break;
    }
} else {
    // Petición incorrecta
    sinImplementarAction(filter_input(INPUT_SERVER, 'PATH_INFO'));
}
