<?php

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=exam_cell_automation', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id=$_GET['id'];
$name=$_GET['name'];
$semester=$_GET['semester'];

$statement = $pdo->prepare('SELECT sm.subject as subject,sm.mark as mark FROM subject_mark as sm 
                                join subject_semester as ss on sm.subject = ss.subject 
                                WHERE sm.id=:id and ss.subject_semester=:semester ');
$statement->bindValue('id',$id);
$statement->bindValue('semester',$semester);
$statement->execute();
$subjects = $statement->fetchAll(PDO::FETCH_ASSOC);

require_once '../vendor/setasign/fpdf/fpdf.php';


$pdf=new FPDF();
$pdf->SetMargins(20,10,20);
$pdf->AddPage();
$pdf->setFont('Arial','B',20);
$pdf->cell(30,30,$name,1,1);
$pdf->setFont('Arial','B',16);

foreach ($subjects as $info)
{
    $pdf->cell(20,20,$info['subject'].' : '.$info['mark'],0,1);
}
$pdf->output($id.'.pdf','D',true);




header('location : students.php');
