<?php
require_once 'includes/header.php';
require_once 'includes/functions.php'; // Добавлена эта строка
?>

    <section class="welcome-section">
        <h1>Добро пожаловать в систему заметок</h1>
        <p>Создавайте, редактируйте и управляйте вашими заметками</p>
        
        <?php if (!isLoggedIn()): ?>
            <div style="margin-top: 2rem;">
                <a href="register.php" class="btn btn-primary" style="margin-right: 1rem;">Начать сейчас</a>
                <a href="login.php" class="btn" style="background: white; color: #667eea;">Войти в систему</a>
            </div>
        <?php else: ?>
            <div style="margin-top: 2rem;">
                <a href="dashboard.php" class="btn btn-primary" style="margin-right: 1rem;">Личный кабинет</a>
                <a href="note_create.php" class="btn" style="background: white; color: #667eea;">Создать заметку</a>
            </div>
        <?php endif; ?>
    </section>

    <!-- Публичные заметки -->
    <section style="background: white; padding: 2rem; border-radius: 12px; margin-top: 2rem;">
        <h2 style="text-align: center; margin-bottom: 2rem; color: #333;">Публичные заметки</h2>
        <?php
        $publicNotes = getPublicNotes();
        if ($publicNotes): ?>
            <div class="notes-grid">
                <?php foreach ($publicNotes as $note): ?>
                    <div class="note-card">
                        <div class="note-header">
                            <h3 class="note-title"><?php echo htmlspecialchars($note['title']); ?></h3>
                            <span class="note-public">Публичная</span>
                        </div>
                        <div class="note-meta">
                            Автор: <?php echo htmlspecialchars($note['username']); ?> | 
                            <?php echo date('d.m.Y H:i', strtotime($note['updated_at'])); ?>
                        </div>
                        <div class="note-content">
                            <?php echo nl2br(htmlspecialchars(substr($note['content'], 0, 150) . '...')); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p style="text-align: center; color: #666;">Публичные заметки отсутствуют</p>
        <?php endif; ?>
    </section>

<?php require_once 'includes/footer.php'; ?>