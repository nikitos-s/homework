<?php
require_once 'includes/header.php';
require_once 'includes/functions.php'; // Добавлена эта строка

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$user = getCurrentUser();
$stats = getUserStats($user['id']);
$recentNotes = array_slice(getUserNotes($user['id']), 0, 3);
?>

    <h1 style="text-align: center; color: white; margin-bottom: 2rem;">Личный кабинет</h1>
    
    <!-- Статистика -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number"><?php echo $stats['total_notes'] ?? 0; ?></div>
            <div class="stat-label">Всего заметок</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?php echo $stats['public_notes'] ?? 0; ?></div>
            <div class="stat-label">Публичных заметок</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?php echo htmlspecialchars($user['username']); ?></div>
            <div class="stat-label">Имя пользователя</div>
        </div>
    </div>

    <!-- Быстрые действия -->
    <div style="text-align: center; margin: 2rem 0;">
        <a href="note_create.php" class="btn btn-primary" style="margin-right: 1rem;">Создать заметку</a>
        <a href="notes.php" class="btn" style="background: white; color: #667eea;">Все мои заметки</a>
    </div>

    <!-- Последние заметки -->
    <section style="background: white; padding: 2rem; border-radius: 12px; margin-top: 2rem;">
        <h2 style="margin-bottom: 1.5rem; color: #333;">Последние заметки</h2>
        
        <?php if ($recentNotes): ?>
            <div class="notes-grid">
                <?php foreach ($recentNotes as $note): ?>
                    <div class="note-card">
                        <div class="note-header">
                            <h3 class="note-title"><?php echo htmlspecialchars($note['title']); ?></h3>
                            <?php if ($note['is_public']): ?>
                                <span class="note-public">Публичная</span>
                            <?php endif; ?>
                        </div>
                        <div class="note-meta">
                            <?php echo date('d.m.Y H:i', strtotime($note['updated_at'])); ?>
                        </div>
                        <div class="note-content">
                            <?php echo nl2br(htmlspecialchars(substr($note['content'], 0, 100) . '...')); ?>
                        </div>
                        <div class="note-actions">
                            <a href="note_edit.php?id=<?php echo $note['id']; ?>" class="btn btn-edit">Редактировать</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p style="text-align: center; color: #666;">У вас пока нет заметок</p>
            <div style="text-align: center; margin-top: 1rem;">
                <a href="note_create.php" class="btn btn-primary">Создать первую заметку</a>
            </div>
        <?php endif; ?>
    </section>

<?php require_once 'includes/footer.php'; ?>