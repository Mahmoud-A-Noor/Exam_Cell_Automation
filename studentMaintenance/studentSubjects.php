<?php


$pdo = new PDO('mysql:host=localhost;port=3306;dbname=exam_cell_automation', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id=$_GET['id'];
$statement = $pdo->prepare('SELECT subject FROM pending_subjects where id=:id');
$statement->bindValue('id',$id);
$statement->execute();
$subjects = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
          integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet"/>
    <title>New Enrollments</title>
</head>
<body>

<p>
    <a href="students.php" type="button" class="btn btn-sm btn-secondary">back</a>
</p>
<br>

<h1>Students</h1>

<table class="table">
    <thead>
    <tr>
        <th scope="col">subject</th>
        <th scope="col"></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($subjects as $subject) { ?>
        <tr>
            <td><?php echo $subject['subject'] ?></td>
            <form action="addmark.php" method="get" style="display: inline-block">
                <input type="hidden" name="id" value="<?php echo $id ?>">
                <input type="hidden" name="subject" value="<?php echo $subject['subject'] ?>">
                <td> <input type="number" name="grade">
                    <button type="submit" class="btn btn-sm btn-success">add grade</button> </td>
            </form>
        </tr>
    <?php } ?>
    </tbody>
</table>

</body>
</html>
