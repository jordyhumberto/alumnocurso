<?php
    session_start(); //Inicia una nueva sesión o reanuda la existente
    require 'conexion.php'; //Agregamos el script de Conexión
    if(!isset($_SESSION["id_usuario"])){
        header("Location: index.php");
    }
    $IDMatricula=$_GET['IDMatricula'];
    $IDCarrera=$_GET['IDCarrera'];
    $Nombre=$_GET['Nombre'];
    $id=$_POST['check'];
    $N=count($id);
    for($i=0; $i < $N; $i++){
        $sqlC="SELECT c.Creditos AS creditos FROM Tbl_cursos AS c INNER JOIN Tbl_curso_operativo AS co ON c.IDCursos=co.IDCursos WHERE co.IDCO='$id[$i]'";
        $resultadoC=$mysqli->query($sqlC);
        $rowC=$resultadoC->fetch_array(MYSQLI_ASSOC);
        $creditos=$rowC['creditos'];
        $sqlCA="INSERT INTO Tbl_cursos_alumno VALUES ('$IDMatricula','$id[$i]','$creditos','01')";
        $resultadoCA=$mysqli->query($sqlCA);
        $sqlNA="INSERT INTO Tbl_notas_alumno(IDMatricula,IDCO,Estado) VALUES ('$IDMatricula','$id[$i]','02')";
        $resultadoNA=$mysqli->query($sqlNA);
    }
    header("Location: cursos.php?IDMatricula=$IDMatricula&IDCarrera=$IDCarrera&Nombre=$Nombre");
?>
