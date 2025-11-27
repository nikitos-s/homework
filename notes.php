<?php
require_once 'includes/header.php';
require_once 'includes/functions.php'; // Добавлена эта строка

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$user = getCurrentUser();
$notes = getUserNotes($user['id']);

// Обработка удаления заметки
if (isset($_GET['delete'])) {
    $noteId = (int)$_GET['delete'];
    
    if (isNoteOwner($noteId, $user['id'])) {
        if (deleteNote($noteId)) {
            $_SESSION['message'] = "Заметка успешно удалена";
            $_SESSION['message_type'] = 'success';
            header('Location: notes.php');
            exit;
        } else {
            $_SESSION['message'] = "Ошибка при удалении заметки";
            $_SESSION['message_type'] = 'error';
        }
    } else {
        $_SESSION['message'] = "У вас нет прав для удаления этой заметки";
        $_SESSION['message_type'] = 'error';
    }
}
?>

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1 style="color: white;">Мои заметки</h1>
        <a href="note_create.php" class="btn btn-primary">Создать заметку</a>
    </div>

    <?php if ($notes): ?>
        <div class="notes-grid">
            <?php foreach ($notes as $note): ?>
                <div class="note-card">
                    <div class="note-header">
                        <h3 class="note-title"><?php echo htmlspecialchars($note['title']); ?></h3>
                        <?php if ($note['is_public']): ?>
                            <span class="note-public">Публичная</span>
                        <?php endif; ?>
                    </div>
                    <div class="note-meta">
                        Создано: <?php echo date('d.m.Y H:i', strtotime($note['created_at'])); ?><br>
                        Обновлено: <?php echo date('d.m.Y H:i', strtotime($note['updated_at'])); ?>
                    </div>
                    <div class="note-content">
                        <?php echo nl2br(htmlspecialchars($note['content'])); ?>
                    </div>
                    <div class="note-actions">
                        <a href="note_edit.php?id=<?php echo $note['id']; ?>" class="btn btn-edit">Редактировать</a>
                        <a href="notes.php?delete=<?php echo $note['id']; ?>" 
                           class="btn btn-danger" 
                           onclick="return confirm('Вы уверены, что хотите удалить эту заметку?')">Удалить</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div style="background: white; padding: 3rem; border-radius: 12px; text-align: center;">
            <h2 style="color: #666; margin-bottom: 1rem;">Заметок пока нет</h2>
            <p style="color: #888; margin-bottom: 2rem;">Создайте свою первую заметку!</p>
            <a href="note_create.php" class="btn btn-primary">Создать заметку</a>
        </div>
    <?php endif; ?>

<?php require_once 'includes/footer.php'; ?>