<?php
session_start();
require '../functions/topic_functions.php';

$lecturer_id = $_SESSION['id'];

$topic_name = trim($_POST['topic_name']);
$description = trim($_POST['description']);

if (createTopic($lecturer_id, $topic_name, $description)) {
    header("Location: ../views/lecturer/lec_topic.php?success=1");
} else {
    header("Location: ../views/lecturer/lec_topic_create.php?error=1");
}
exit;
