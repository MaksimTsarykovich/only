<?php include VIEWS_PATH . '/components/header.php'; ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6 col-xl-5">
            <div class="card mt-5 mb-5">
                <div class="card-body p-4">
                    <h2 class="card-title text-center mb-4">Регистрация</h2>

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


                    <form action="/register" method="post">

                        <div class="mb-3">
                            <label for="name" class="form-label">Имя</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Телефон</label>
                            <input type="tel" class="form-control" id="phone" name="phone"
                                   placeholder="+7 (___) ___-__-__" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Электронная почта</label>
                            <input type="email" class="form-control" id="email" name="email" >
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Пароль</label>
                            <input type="password" class="form-control" id="password" name="password">
                            <div class="form-text">
                                Пароль должен содержать не менее 8 символов
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="passwordConfirm" class="form-label">Повторите пароль</label>
                            <input type="password" class="form-control" id="passwordConfirm"
                                   name="passwordConfirm" required>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
                        </div>

                        <div class="mt-3 text-center">
                            <p>Уже есть аккаунт? <a href="/login">Войти</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include VIEWS_PATH . '/components/footer.php'; ?>