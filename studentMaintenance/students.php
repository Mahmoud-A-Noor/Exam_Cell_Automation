<?php

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=exam_cell_automation', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$statement = $pdo->prepare('SELECT id,image,fname,midname,lname,semester FROM student ORDER BY semester');
$statement->execute();
$students = $statement->fetchAll(PDO::FETCH_ASSOC);
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
    <a href="../adminPanel.php" type="button" class="btn btn-sm btn-success">back</a>
</p>
<br>

<h1>Students</h1>

<table class="table">
    <thead>
    <tr>
        <th scope="col">ID</th>
        <th scope="col">Image</th>
        <th scope="col">Name</th>
        <th scope="col">semester</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($students as $student) { ?>
        <tr>
            <th scope="row"><?php echo $student['id'] ?></th>
            <td>
                <?php if ($student['image']): ?>
                    <img src="<?php echo $student['image'] ?>" class="product-img" alt="">
                <?php endif; ?>
            </td>
            <td><?php echo $student['fname'].' '.$student['midname'].' '.$student['lname'] ?></td>
            <td><?php echo $student['semester'] ?></td>
            <td>
                <a href="printMarks.php?id=<?php echo $student['id'] ?>&
                                 name=<?php echo $student['fname'].' '.$student['midname'].' '.$student['lname'] ?>&
                                 semester=<?php echo $student['semester'] ?>"
                   class="btn btn-sm btn-outline-primary">print marks</a>
            </td>
            <td>
                <a href="studentSubjects.php?id=<?php echo $student['id'] ?>" class="btn btn-sm btn-outline-primary">add Marks</a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>

</body>
</html>