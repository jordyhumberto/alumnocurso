<?php
session_start(); //Inicia una nueva sesión o reanuda la existente
require 'conexion.php'; //Agregamos el script de Conexión
if(!isset($_SESSION["id_usuario"])){
    header("Location: index.php");
}
$IDMatricula=$_GET['IDMatricula'];
$IDCarrera=$_GET['IDCarrera'];
$Nombre=$_GET['Nombre'];
$sqlM="SELECT co.IDCO AS ca,co.IDCursos AS idc,c.Descripcion AS curso,s.Descripcion AS semestre,concat(d.Nombres,' ',d.Apellidos) AS docente,c.IDCiclo AS ciclo,c.Creditos AS creditos FROM (((Tbl_curso_operativo AS co INNER JOIN Tbl_cursos AS c on co.IDCursos=c.IDCursos)INNER JOIN Tbl_semestre AS s ON co.IDSemestre=s.IDSemestre)INNER JOIN Tbl_docente AS d ON co.IDDocente=d.IDDocente) WHERE (co.IDSemestre=79 OR co.IDSemestre=80) AND c.IDCursos LIKE '$IDCarrera%'";
$resultadoM=$mysqli->query($sqlM) or trigger_error($mysqli->error);
$sqlC="SELECT co.IDCO AS op,c.Descripcion AS curso,s.Descripcion AS semestre FROM ((((Tbl_cursos_alumno AS ca INNER JOIN Tbl_curso_operativo AS co ON ca.IDCO=co.IDCO)INNER JOIN Tbl_cursos AS c ON c.IDCursos=co.IDCursos)INNER JOIN Tbl_docente AS d ON co.IDDocente=d.IDDocente)INNER JOIN Tbl_semestre AS s ON co.IDSemestre=s.IDSemestre) WHERE ca.IDMatricula='$IDMatricula'";
$resultadoC=$mysqli->query($sqlC) or trigger_error($mysqli->error);
?>
<html lang="en">
<head>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="keywords" content="universidad, peruana, investigación, investigacion, negocios, upein, UPEIN">
  	<meta name="description" content="UPEIN! - Universidad Peruana de Invesitgacion y Negocios da la bienvenida a sus nuevos estudiantes">
	<title>Upein</title>
    <link href="img/favicon.ico" rel="shortcut icon" type="image/x-icon">
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap-theme.css" rel="stylesheet">
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>	
	<link href="css/jquery.dataTables.min.css" rel="stylesheet">	
	<script src="js/jquery.dataTables.min.js"></script>
	<link rel="stylesheet" href="css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Alfa+Slab+One|Ultra" rel="stylesheet">
	<script>
		$(document).ready(function(){
			$('#mitabla').DataTable({
				"order": [[1, "asc"]],
				"language":{
					"lengthMenu": "Mostrar _MENU_ registros por pagina",
					"info": "Mostrando pagina _PAGE_ de _PAGES_",
					"infoEmpty": "No hay registros disponibles",
					"infoFiltered": "(filtrada de _MAX_ registros)",
					"loadingRecords": "Cargando...",
					"processing":     "Procesando...",
					"search": "Buscar:",
					"zeroRecords":    "No se encontraron registros coincidentes",
					"paginate": {
						"next":       "Siguiente",
						"previous":   "Anterior"
					},					
				}
			});	
		});	
        $(document).ready(function(){
			$('#mitabla1').DataTable({
				"order": [[1, "asc"]],
				"language":{
					"lengthMenu": "Mostrar _MENU_ registros por pagina",
					"info": "Mostrando pagina _PAGE_ de _PAGES_",
					"infoEmpty": "No hay registros disponibles",
					"infoFiltered": "(filtrada de _MAX_ registros)",
					"loadingRecords": "Cargando...",
					"processing":     "Procesando...",
					"search": "Buscar:",
					"zeroRecords":    "No se encontraron registros coincidentes",
					"paginate": {
						"next":       "Siguiente",
						"previous":   "Anterior"
					},					
				}
			});	
		});	
	</script>
</head>
</head>
<body>
<div class="cuerpo">
    <h1 class="titulo"><?php echo $Nombre;?></h1><br>
    <div class="row table-responsive">
        <table class="display" id="mitabla1">
            <thead>
                <tr>
                    <th>CurOpe</th>
                    <th>Curso</th>
                    <th>Semestre</th>
                    <th>Borrar</th>
                </tr>    
            </thead>
            <tbody>
            <?php while ($rowC=$resultadoC->fetch_array(MYSQLI_ASSOC)) {?>
                <tr>
                    <td><?php echo $rowC['op']?></td>
                    <td><?php echo $rowC['curso']?></td>
                    <td><?php echo $rowC['semestre']?></td>
                    <td><a href="borrar.php?IDMatricula=<?php echo $IDMatricula;?>&IDCarrera=<?php echo $IDCarrera;?>&Nombre=<?php echo $Nombre;?>&IDCO=<?php echo $rowC['op']; ?>"><span class="glyphicon glyphicon-trash"></span></a></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <br>
    </div>
    <form action="guardar.php?IDMatricula=<?php echo $IDMatricula;?>&IDCarrera=<?php echo $IDCarrera;?>&Nombre=<?php echo $Nombre;?>" method="post">
        <div style="display:flex;justify-content: flex-end;">
            <a href="alumnos.php" class="btn btn-primary">Regresar</a>&nbsp
            <input type="submit" class="btn btn-primary">
        </div>
        <br>
        <div class="row table-responsive">
            <table class="display" id="mitabla">
                <thead>
                    <tr>
                        <th>CurOpe</th>
                        <th>IDCursos</th>
                        <th>Curso</th>
                        <th>Semestre</th>
                        <th>Docente</th>
                        <th>Ciclo</th>
                        <th>Inscribir</th>
                    </tr>    
                </thead>
                <tbody>
                <?php while ($rowM=$resultadoM->fetch_array(MYSQLI_ASSOC)) {?>
                    <tr>
                        <td><?php echo $rowM['ca']?></td>
                        <td><?php echo $rowM['idc']?></td>
                        <td><?php echo $rowM['curso']?></td>
                        <td><?php echo $rowM['semestre']?></td>
                        <td><?php echo $rowM['docente']?></td>
                        <td><?php echo $rowM['ciclo']?></td> 
                        <td><input type="checkbox" name="check[]" value="<?php echo $rowM['ca'];?>"></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </form>
</div>
</body>
</html>