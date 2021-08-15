<?php

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=exam_cell_automation', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$statement = $pdo->prepare('SELECT * FROM new_enrollment');
$statement->execute();
$enrollments = $statement->fetchAll(PDO::FETCH_ASSOC);
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
    <a href="../adminPanel.php" type="button" class="btn btn-sm btn-secondary">back</a>
</p>
<br>

<h1>New Enrollments</h1>

<table class="table">
    <thead>
    <tr>
        <th scope="col">ID</th>
        <th scope="col">Image</th>
        <th scope="col">Name</th>
        <th scope="col">Email</th>
        <th scope="col">PhoneNumber</th>
        <th scope="col">subject</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($enrollments as $enrollment) { ?>
        <tr>
            <th scope="row"><?php echo $enrollment['id'] ?></th>
            <td>
                <?php if ($enrollment['image']): ?>
                    <img src="<?php echo $enrollment['image'] ?>" class="student-img" alt="">
                <?php endif; ?>
            </td>
            <td><?php echo $enrollment['fname'].' '.$enrollment['midname'].' '.$enrollment['lname'] ?></td>
            <td><?php echo $enrollment['email'] ?></td>
            <td><?php echo $enrollment['phoneNumber'] ?></td>
            <td><?php echo $enrollment['subject'] ?></td>
            <td>
                <a href="recordEnrollment.php?id=<?php echo $enrollment['id'] ?>&
                                            image=<?php echo $enrollment['image'] ?>&
                                            fname=<?php echo $enrollment['fname'] ?>&
                                            midname=<?php echo $enrollment['midname'] ?>&
                                            lname=<?php echo $enrollment['lname'] ?>&
                                            email=<?php echo $enrollment['email'] ?>&
                                            phoneNumber=<?php echo $enrollment['phoneNumber'] ?>&
                                            subject=<?php echo $enrollment['subject'] ?>"        
                 class="btn btn-sm btn-outline-primary">Record Enrollment</a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>

</body>
</html>