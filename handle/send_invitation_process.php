<?php
session_start();
require_once __DIR__ . '/../../functions/auth.php';
require_once __DIR__ . '/../../functions/invitation_functions.php';
checkLogin('../../index.php');

$current = getCurrentUser();
$lecturer_id = $current['account_id'];

$topic_id = intval($_POST['topic_id'] ?? 0);
$student_id = intval($_POST['student_id'] ?? 0);

if ($topic_id <= 0 || $student_id <= 0) {
    header("Location: ../../views/lecturer/lec_topic.php?invited=0");
    exit;
}

$ok = sendInvitation($topic_id, $student_id, $lecturer_id);
header("Location: ../../views/lecturer/lec_topic.php?invited=" . ($ok?1:0));
exit;
