<?php
require_once 'config/database.php';

// Создание заметки
function createNote($userId, $title, $content, $isPublic = false) {
    $pdo = getDB();
    $stmt = $pdo->prepare("INSERT INTO notes (user_id, title, content, is_public) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$userId, $title, $content, $isPublic]);
}

// Получение всех заметок пользователя
function getUserNotes($userId) {
    $pdo = getDB();
    $stmt = $pdo->prepare("SELECT * FROM notes WHERE user_id = ? ORDER BY updated_at DESC");
    $stmt->execute([$userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Получение публичных заметок
function getPublicNotes() {
    $pdo = getDB();
    $stmt = $pdo->prepare("SELECT n.*, u.username FROM notes n 
                          JOIN users u ON n.user_id = u.id 
                          WHERE n.is_public = TRUE 
                          ORDER BY n.updated_at DESC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Получение заметки по ID
function getNoteById($noteId) {
    $pdo = getDB();
    $stmt = $pdo->prepare("SELECT * FROM notes WHERE id = ?");
    $stmt->execute([$noteId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Проверка принадлежности заметки пользователю
function isNoteOwner($noteId, $userId) {
    $pdo = getDB();
    $stmt = $pdo->prepare("SELECT id FROM notes WHERE id = ? AND user_id = ?");
    $stmt->execute([$noteId, $userId]);
    return (bool)$stmt->fetch();
}

// Обновление заметки
function updateNote($noteId, $title, $content, $isPublic) {
    $pdo = getDB();
    $stmt = $pdo->prepare("UPDATE notes SET title = ?, content = ?, is_public = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
    return $stmt->execute([$title, $content, $isPublic, $noteId]);
}

// Удаление заметки
function deleteNote($noteId) {
    $pdo = getDB();
    $stmt = $pdo->prepare("DELETE FROM notes WHERE id = ?");
    return $stmt->execute([$noteId]);
}

// Получение статистики пользователя
function getUserStats($userId) {
    $pdo = getDB();
    $stmt = $pdo->prepare("SELECT 
        COUNT(*) as total_notes,
        SUM(is_public) as public_notes
        FROM notes WHERE user_id = ?");
    $stmt->execute([$userId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
?>