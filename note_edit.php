<?php
require_once 'includes/header.php';
require_once 'includes/functions.php'; // Добавлена эта строка

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$user = getCurrentUser();

// Проверка существования заметки и прав доступа
if (!isset($_GET['id'])) {
    header('Location: notes.php');
    exit;
}

$noteId = (int)$_GET['id'];
$note = getNoteById($noteId);

if (!$note || !isNoteOwner($noteId, $user['id'])) {
    $_SESSION['message'] = "Заметка не найдена или у вас нет прав для её редактирования";
    $_SESSION['message_type'] = 'error';
    header('Location: notes.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $isPublic = isset($_POST['is_public']) ? 1 : 0;
    
    $errors = [];
    
    if (empty($title)) {
        $errors[] = "Заголовок не может быть пустым";
    }
    
    if (empty($content)) {
        $errors[] = "Содержание не может быть пустым";
    }
    
    if (empty($errors)) {
        if (updateNote($noteId, $title, $content, $isPublic)) {
            $_SESSION['message'] = "Заметка успешно обновлена!";
            $_SESSION['message_type'] = 'success';
            header('Location: notes.php');
            exit;
        } else {
            $errors[] = "Ошибка при обновлении заметки";
        }
    }
}
?>

<div class="form-container" style="max-width: 800px;">
    <h2 style="text-align: center; margin-bottom: 2rem; color: #333;">Редактирование заметки</h2>
    
    <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
            <?php foreach ($errors as $error): ?>
                <p><?php echo $error; ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <form method="POST" action="">
        <div class="form-group">
            <label for="title">Заголовок:</label>
            <input type="text" id="title" name="title" class="form-control" 
                   value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : htmlspecialchars($note['title']); ?>" 
                   required>
        </div>
        
        <div class="form-group">
            <label for="content">Содержание:</label>
            <textarea id="content" name="content" class="form-control" 
                      rows="10" required><?php echo isset($_POST['content']) ? htmlspecialchars($_POST['content']) : htmlspecialchars($note['content']); ?></textarea>
        </div>
        
        <div class="form-group">
            <label style="display: flex; align-items: center; gap: 0.5rem;">
                <input type="checkbox" name="is_public" value="1" 
                       <?php echo (isset($_POST['is_public']) ? $_POST['is_public'] : $note['is_public']) ? 'checked' : ''; ?>>
                Сделать заметку публичной
            </label>
        </div>
        
        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary">Обновить заметку</button>
            <a href="notes.php" class="btn" style="background: #f8f9fa; color: #333;">Отмена</a>
            <a href="notes.php?delete=<?php echo $noteId; ?>" 
               class="btn btn-danger" 
               onclick="return confirm('Вы уверены, что хотите удалить эту заметку?')">Удалить</a>
        </div>
    </form>
</div>

<?php require_once 'includes/footer.php'; ?>