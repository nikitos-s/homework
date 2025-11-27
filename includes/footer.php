<?php
// Этот файл должен быть включен в конец каждой страницы
?>
    </div> <!-- закрытие container -->
    
    <footer style="background: rgba(255, 255, 255, 0.9); padding: 2rem; text-align: center; margin-top: 4rem;">
        <div class="container">
            <p style="color: #666; margin-bottom: 0.5rem;">Система заметок &copy; <?php echo date('Y'); ?></p>
            <p style="color: #888; font-size: 0.9rem;">Простая и удобная система для управления вашими заметками</p>
        </div>
    </footer>
    
    <script>
    // Простой JavaScript для улучшения UX
    document.addEventListener('DOMContentLoaded', function() {
        // Автоматическое скрытие alert через 5 секунд
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.opacity = '0';
                alert.style.transition = 'opacity 0.5s ease';
                setTimeout(() => alert.remove(), 500);
            }, 5000);
        });
        
        // Подтверждение удаления
        const deleteButtons = document.querySelectorAll('a[href*="delete"]');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                if (!confirm('Вы уверены, что хотите удалить эту заметку?')) {
                    e.preventDefault();
                }
            });
        });
    });
    </script>
</body>
</html>