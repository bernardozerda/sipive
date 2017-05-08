<?php

    $txtPrefijoRuta = "../../";

    include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );	
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']  . "ReportesProyectos.class.php" );

    $sql = "
        SELECT T_COR_USUARIO.seqUsuario as idUsuario,
               T_COR_USUARIO.txtNombre as Nomnre,
               T_COR_USUARIO.txtApellido as Apellido,
               T_COR_USUARIO.txtCorreo as Correo,
               T_COR_USUARIO.bolCrear as Crear,
               T_COR_USUARIO.bolEditar as Editar,
               T_COR_USUARIO.bolBorrar as Borrar,
               T_COR_USUARIO.bolCambiar as Abrirformulario,
               T_COR_GRUPO.txtGrupo as Grupo,
               T_COR_MENU.txtMenuEs as Menu
          FROM (((((T_COR_PROYECTO_GRUPO T_COR_PROYECTO_GRUPO
                    INNER JOIN T_COR_GRUPO T_COR_GRUPO
                       ON (T_COR_PROYECTO_GRUPO.seqGrupo = T_COR_GRUPO.seqGrupo))
                   INNER JOIN T_COR_PERFIL T_COR_PERFIL
                      ON (T_COR_PERFIL.seqProyectoGrupo =
                             T_COR_PROYECTO_GRUPO.seqProyectoGrupo))
                  INNER JOIN T_COR_USUARIO T_COR_USUARIO
                     ON (T_COR_PERFIL.seqUsuario = T_COR_USUARIO.seqUsuario))
                 INNER JOIN T_COR_PROYECTO T_COR_PROYECTO
                    ON (T_COR_PROYECTO_GRUPO.seqProyecto = T_COR_PROYECTO.seqProyecto))
                INNER JOIN T_COR_PERMISO T_COR_PERMISO
                   ON (T_COR_PERMISO.seqProyectoGrupo =
                          T_COR_PROYECTO_GRUPO.seqProyectoGrupo))
               INNER JOIN T_COR_MENU T_COR_MENU
                  ON (T_COR_PERMISO.seqMenu = T_COR_MENU.seqMenu)
         WHERE (T_COR_USUARIO.bolActivo = 1) AND (T_COR_PROYECTO.seqProyecto = 3)
    ";
    $objRes = $aptBd->execute( $sql );
    
    $nombreArchivo = "ReportePermisosSDVE";
    $txtNombreArchivo = $nombreArchivo . date( "Ymd_His" ) . ".xls";

    $claReportes = new Reportes;
    $claReportes->obtenerReportesGeneral( $objRes, $txtNombreArchivo );


?>
