<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    header('HTTP/1.0 403 Forbidden', TRUE, 403);
    echo '<h2 style="color: red">Access Denied!!</h2>';
    echo 'Redirecting...';
    die(header("refresh:2; URL=../index.php"));
}

require_once '../inc/connect.php';

$sn = $_POST['lv_sn'];
$tbleave = "staff_leave";
$tbname = "leave_record";
$lv_types = ['EL', 'CL', 'SL'];

$stmt = $conn->query("SELECT UID, Type, Days FROM $tbname WHERE SN='$sn'");
$data = $stmt->fetch(PDO::FETCH_ASSOC);

// return back days
if (in_array($data['Type'], $lv_types)) {
    $sql = "UPDATE $tbleave SET {$data['Type']}={$data['Type']}+:days WHERE UID=:uid";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':days' => $data['Days'],
        ':uid' => $data['UID']
    ]);
}

// delete leave
$conn->exec("DELETE FROM $tbname WHERE SN=$sn");

die(header("Location: ./record.php"));