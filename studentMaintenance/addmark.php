<?php

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=exam_cell_automation', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id=$_GET['id'];
$subject=$_GET['subject'];
$mark=$_GET['grade'];

$statement=$pdo->prepare('SELECT * FROM subject_mark where id=:id and subject = :subject');
$statement->bindValue('id',$id);
$statement->bindValue('subject',$subject);
$statement->execute();
$exist = $statement->fetchAll(PDO::FETCH_ASSOC);

if($statement->rowCount()>0)
{
    $statement=$pdo->prepare('UPDATE subject_mark SET mark=:mark where id=:id and subject = :sublect');
    $statement->bindValue('id',$id);
    $statement->bindValue('subject',$subject);
    $statement->bindValue('mark',$mark);
    $statement->execute();
}else
{
    $statement=$pdo->prepare('insert into subject_mark (id, subject, mark) VALUES (:id,:subject,:mark)');
    $statement->bindValue('id',$id);
    $statement->bindValue('subject',$subject);
    $statement->bindValue('mark',$mark);
    $statement->execute();
}

if($mark>=60)
{
    $statement=$pdo->prepare('DELETE FROM pending_subjects WHERE id=:id and subject=:subject');
    $statement->bindValue('id',$id);
    $statement->bindValue('subject',$subject);
    $statement->execute();

    $statement=$pdo->prepare('SELECT * FROM subject_mark WHERE id=:id and mark>=60');
    $statement->bindValue('id',$id);
    $statement->execute();
    $exist = $statement->fetchAll(PDO::FETCH_ASSOC);

    $passed_subjects=$statement->rowCount();
    $semester=1;

    if($passed_subjects>7 & $passed_subjects<=14)
        $semester=2;
    else if($passed_subjects>14 & $passed_subjects<=21)
        $semester=3;
    else if($passed_subjects>21 & $passed_subjects<=28)
        $semester=4;
    else if($passed_subjects>28 & $passed_subjects<=35)
        $semester=5;
    else if($passed_subjects>35 & $passed_subjects<=42)
        $semester=6;


    $statement=$pdo->prepare('UPDATE student SET semester=:semester WHERE id=:id');
    $statement->bindValue('id',$id);
    $statement->bindValue('semester',$semester);
    $statement->execute();

}

header('location : studentSubject.php');