<?php

/**
 * Author : Janani VijayaKumar
 * Date : 17-01-2022
 * Desc : Create a To do list using CRUD in php
 */

// initialize errors variable and update
$update = false;
$errors = "";
// connect to database
$db = mysqli_connect("localhost:3307", "root", "", "todo");
// insert a quote if submit button is clicked
if (isset($_POST['submit'])) {
    if (empty($_POST['task'])) {
        $errors = "You must fill in the task";
    } else {
        $task = $_POST['task'];
        $sql = "INSERT INTO tasks (task) VALUES ('$task')";
        mysqli_query($db, $sql);
        header('location: index.php');
    }
}
if (isset($_POST['edit'])) {
    if (empty($_POST['task'])) {
        $errors = "You must fill in the task";
    } else {
        $task = $_POST['task'];
        $sql = "SELECT * FROM tasks WHERE id='$id'";
        mysqli_query($db, $sql);
        header('location: index.php');
    }
}
// edit task
if (isset($_GET['edit_task'])) {
    $id = $_GET['edit_task'];
    $update = true;
    $result = mysqli_query($db, "SELECT * FROM tasks WHERE id='$id'");
    $row = mysqli_fetch_assoc($result);
    $task = $row['task'];
}
//update task
if (isset($_POST['update'])) {
    echo "Inside Update Condition: " . $_POST['update'];
    $id = $_POST['id'];
    $task = $_POST['task'];
    $sql = "UPDATE tasks SET task='$task' WHERE id='$id'";
    $result = mysqli_query($db, $sql);
    if ($result) {
        header("location: index.php");
    }
}

// delete task
if (isset($_GET['del_task'])) {
    $id = $_GET['del_task'];
    mysqli_query($db, "DELETE FROM tasks WHERE id=" . $id);
    header('location: index.php');
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>ToDo List Application PHP and MySQL</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <div class="heading">
        <h2 style="font-style: 'Hervetica';">ToDo List Application PHP and MySQL database</h2>
    </div>
    <center>
        <form method="post" action="index.php" class="input_form">
            <?php if (isset($errors)) { ?>
                <p><?php echo $errors; ?></p>
            <?php } ?>
            <input type="hidden" name="id" value="<?php echo $id; ?>">

            <?php
            if ($update == true) :
            ?>
                <input type="text" name="task" class="task_input" value="<?php echo $task; ?>">
                <button type="submit" name="update" id="add_btn" class="add_btn">Update</button>
            <?php else : ?>
                <input type="text" name="task" class="task_input">
                <button type="submit" name="submit" id="add_btn" class="add_btn">Add Task</button>
            <?php endif; ?>

        </form>
    </center>
    <table>
        <thead>
            <tr>
                <th>S.No</th>
                <th>Tasks</th>
                <th style="width: 200px;">Action</th>
            </tr>
        </thead>

        <tbody>
            <center>
                <?php
                // select all tasks if page is visited or refreshed
                $result = mysqli_query($db, "SELECT * FROM tasks");
                $i = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    $id = $row['id'];
                    $task = $row['task'];
                ?>
                    <tr>
                        <td class="serialNumber"> <?php echo $i ?> </td>
                        <td class="task"> <?php echo $task ?> </td>
                        <td class="edit_delete">
                            <a href="index.php?edit_task=<?php echo $id ?>">edit</a>
                            <a href="index.php?del_task=<?php echo $id ?>">x</a>
                        </td>
                    </tr>
            </center>
        <?php $i++;
                } ?>
        </tbody>
    </table>
</body>

</html>