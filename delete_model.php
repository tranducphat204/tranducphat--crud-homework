<?php require_once('database/database.php') ?>

<?php
if (isset($_GET['id']))
    deleteStudent($_GET['id']);
header('Location: index.php');