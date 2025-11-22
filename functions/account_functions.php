<?php
require_once __DIR__ . '/db_connection.php';

function getAllAccounts($role = '')
{
    global $conn;

    if ($role != '') {
        $stmt = $conn->prepare("SELECT * FROM accounts WHERE role = ? ORDER BY id DESC");
        $stmt->bind_param("s", $role);
    } else {
        $stmt = $conn->prepare("SELECT * FROM accounts ORDER BY id DESC");
    }

    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

function getAccountById($id)
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM accounts WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function addAccount($username, $password, $fullname, $email, $role)
{
    global $conn;

    $stmt = $conn->prepare("
        INSERT INTO accounts (username, password, fullname, email, role)
        VALUES (?, ?, ?, ?, ?)
    ");

    $stmt->bind_param("sssss", $username, $password, $fullname, $email, $role);
    return $stmt->execute();
}

function updateAccount($id, $username, $password, $fullname, $email, $role)
{
    global $conn;

    if ($password !== "") {
        $stmt = $conn->prepare("
            UPDATE accounts SET username=?, password=?, fullname=?, email=?, role=? 
            WHERE id=?
        ");
        $stmt->bind_param("sssssi", $username, $password, $fullname, $email, $role, $id);
    } else {
        $stmt = $conn->prepare("
            UPDATE accounts SET username=?, fullname=?, email=?, role=? 
            WHERE id=?
        ");
        $stmt->bind_param("ssssi", $username, $fullname, $email, $role, $id);
    }

    return $stmt->execute();
}

function deleteAccount($id)
{
    global $conn;
    $stmt = $conn->prepare("DELETE FROM accounts WHERE id=?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}
