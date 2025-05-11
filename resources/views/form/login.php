<?php include VIEWS_PATH . '/components/header.php'; ?>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6 col-xl-5">
            <div class="card mt-5 mb-5">
                <div class="card-body p-4">
                    <h2 class="card-title text-center mb-4">Вход</h2>

                    <?php if (!empty($_SESSION['flash']['error'])): ?>

                        <div class="alert alert-danger">
                            <ul class="m-0">
                                <?php foreach ($_SESSION['flash']['error'] as $error): ?>
                                    <li><?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                    <?php endif; ?>
                    <?php if (!empty($_SESSION['flash']['success'])): ?>

                        <div class="alert alert-success">
                            <ul class="m-0">
                                <?php foreach ($_SESSION['flash']['success'] as $success): ?>
                                    <li><?= $success ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                    <?php endif; ?>


                    <form action="/login" method="post">

                        <div class="mb-3">
                            <label for="name" class="form-label">Имя</label>
                            <input type="text" class="form-control" id="login" name="login" value="johndoe@example.com"
                                   required>
                            <div class="form-text">
                                Пожалуйста, введите вашу почту или телефон
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Пароль</label>
                            <input type="password" class="form-control" id="password" name="password"
                                   value="johndoe12345">
                            <div class="form-text">
                                Пожалуйста, введите ваш пароль
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Войти</button>
                        </div>

                        <div class="mb-3">
                            <div id="captcha-container" class="smart-captcha" data-sitekey="ysc1_aLnsFqR0IVvstUVt9tcakLLHZWcPjXFJgS78yK8Kc699e978"></div>
                            <input type="hidden" name="smart-token" id="smart-token-input">
                        </div>


                        <div class="mt-3 text-center">
                            <p>Нет аккаунта? <a href="/register">Зарегистрироваться</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<!-- Скрипт для инициализации SmartCaptcha -->
<script src="https://smartcaptcha.yandexcloud.net/captcha.js" defer></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Ждем загрузки скрипта капчи
        setTimeout(function() {
            if (typeof window.smartCaptcha !== 'undefined') {
                // Инициализируем капчу
                window.smartCaptcha.render('captcha-container', {
                    sitekey: '<?= Config\Captcha::YANDEX_SITE_KEY ?>',
                    callback: function(token) {
                        // Сохраняем токен в скрытое поле формы
                        document.getElementById('smart-token-input').value = token;
                        console.log('Капча решена, токен получен:', token);
                    },
                    invisible: false,
                    language: 'ru'
                });
            } else {
                console.error('SmartCaptcha не загружена');
            }
        }, 500);
    });
</script>



</body>
</html>