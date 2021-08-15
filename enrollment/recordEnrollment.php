<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require_once 'vendor/PHPMailer/PHPMailer/src/Exception.php';
require_once 'vendor/PHPMailer/PHPMailer/src/PHPMailer.php';
require_once 'vendor/PHPMailer/PHPMailer/src/SMTP.php';

require_once 'vendor/setasign/fpdf/fpdf.php';
require_once('../functions.php');

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=exam_cell_automation', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$image=$_GET['image'];
$fname=$_GET['fname'];
$midname=$_GET['midname'];
$lname=$_GET['lname'];
$email=$_GET['email'];
$phoneNumber=$_GET['phoneNumber'];
$subject=$_GET['subject'];
$newEnrollment_id = $_GET['id'] ?? null;

if (!$newEnrollment_id) {
    header('Location: newEnrollments.php');
    exit;
}
    $statement=$pdo->prepare('INSERT INTO student (phoneNumber,email,fname,midname,lname,semester,password,image)
     VALUES (:phoneNumber, :email, :fname, :midname, :lname, :semester, :password, :image)');
     $statement->bindValue(':phoneNumber',$phoneNumber);
     $statement->bindValue(':email',$email);
     $statement->bindValue(':fname',$fname);
     $statement->bindValue(':midname',$midname);
     $statement->bindValue(':lname',$lname);
     $statement->bindValue(':semester',1);
     $password = createPassword(7);
     $statement->bindValue(':password',$password);
     $statement->bindValue(':image',$image);
     $statement->execute();

    $last_id = $pdo->lastInsertId();

    $statement=$pdo->prepare('DELETE FROM new_enrollment where id=:id');
    $statement->bindValue(':id',$newEnrollment_id);
    $statement->execute();


$statement=$pdo->prepare('INSERT INTO pending_subjects (id,subject) VALUES (:id, :subject)');
     $statement->bindValue(':id',$last_id);
     $statement->bindValue(':subject',$subject);
     $statement->execute();

$pdf=new FPDF();
$pdf->SetMargins(20,10,20);
$pdf->AddPage();
$pdf->Image($image,120,15,70,70);
$pdf->setFont('Arial','B',16);
$pdf->cell(20,20,'FirstName : '.$fname,0,1);
$pdf->cell(20,20,'MidName : '.$midname,0,1);
$pdf->cell(20,20,'LastName : '.$lname,0,1);
$pdf->cell(20,20,'Email : '.$email,0,1);
$pdf->cell(20,20,'PhoneNumber : '.$phoneNumber,0,1);
$pdf->cell(20,20,'Registered Subject : '.$subject,0,1);
$pdfmail=$pdf->output('','S');


send_email($pdfmail,$last_id,$password,$email);


header('Location: newEnrollments.php');
