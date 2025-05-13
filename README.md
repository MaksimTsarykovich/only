# Тестовое задание: Only

## Описание

Написать формы регистрации, авторизации, страницу профиля:

- В форме регистрации пользователь должен указать Имя, телефон, почту, пароль и повтор пароля.
- Почта, логин и телефон должны быть уникальны и если такие в базе уже есть - уведомлять пользователя об этом.
- Пароли в обоих полях должны совпадать, иначе уведомлять пользователя об этом.
- Авторизация возможна по телефону или email (в одном поле) и паролю, необходимо добавить Yandex SmartCaptcha при
  авторизации.
- Сделать страницу, к которой только авторизованные пользователи имеют доступ. Неавторизованные пользователи должны
  перенаправляться на главную страницу. На этой странице пользователи могут менять свою личную информацию (имя, телефон,
  почта, пароль).
  Нам важно знать именно ваши навыки обращения с кодом, по этому переписанные готовые решения не принимаются. Всё должно
  быть выполнено с использованием нативного php, без использования сторонних языков и фреймворков.

## Технологии

- PHP 8.0+
- MySQL
- Docker и Docker Compose
- Yandex SmartCaptcha
- HTML/CSS/JavaScript


## Установка и запуск

### Требования

- Docker и Docker Compose
- Git

### Шаги установки

1. Клонируйте репозиторий:
   ```bash
   git clone https://github.com/MaksimTsarykovich/only.git
   ```
2. Перейдите в директорию проекта:
   ```bash
   cd only/
   ```
3. Запустите контейнеры Docker:
    ```bash
    docker-compose up --build -d
    ```
4. Установите зависимости через Composer:

   Войдите в контейнер PHP
    ```bash
     docker-compose exec -it php bash
    ```
   Обновите автозагрузчик Composer
    ```bash
    composer update
    composer dump-autoload
    ```
   
   В данном тестовом задании через Composer работает только автозагрузка классов.
   
   Никакие библиотеки с готовыми решениями не используются. 

5. Приложение будет доступно по адресу: http://localhost:8080

    PhpMyAdmin: http://localhost:8081
   
### Структура проекта
```
│   .gitignore (Список файлов и директорий, игнорируемых Git)
│   composer.json (Конфигурация Composer, описывает зависимости проекта)
│   composer.lock (Фиксирует точные версии установленных зависимостей)
│   docker-compose.yml (Конфигурация Docker Compose для запуска проекта в контейнерах)
│   README.md (Документация проекта)
│
├───app (Пользовательский код приложения)
│   ├───Controllers (Контроллеры для обработки запросов)
│   │       DashboardController.php
│   │       LoginController.php
│   │       RegisterController.php
│   │
│   ├───Forms (Классы для работы с формами и их валидацией)
│   │   ├───User
│   │   │       Form.php
│   │   │       RegisterForm.php
│   │   │       UpdateForm.php
│   │   │
│   │   └───Validation (Интерфейсы и классы для валидации форм)
│   │           ValidatorForm.php
│   │           ValidatorInterface.php
│   │           ValidatorUpdateForm.php
│   │
│   ├───Models (Модели данных)
│   │       User.php
│   │
│   └───Services (Сервисные классы для работы с данными)
│           UserService.php
│
├───config (Конфигурационные файлы)
│       App.php 
│       Config.php 
│
├───docker (Файлы для настройки Docker-окружения)
│   ├───mysql
│   │       Dockerfile
│   │       init.sql
│   │
│   ├───nginx
│   │       nginx.conf
│   │
│   └───php
│           Dockerfile
│
├───public (Публично доступные файлы)
│       index.php
│
├───resources (Ресурсы приложения)
│   └───views (Виды)
│       ├───components (Повторно используемые компоненты)
│       │       footer.php
│       │       header.php
│       │
│       └───form (Виды форм)
│               login.php
│               register.php
│               update.php
│
├───routes (Маршруты)
│       web.php
│
├───src (Ядро приложения)
│   ├───Authentication (Классы для аутентификации и работы с Yandex SmartCaptcha)
│   │       SessionAuthentication.php
│   │       YandexSmartCaptcha.php
│   │
│   ├───Controller (Базовый класс для контроллеров)
│   │       AbstractController.php
│   │
│   ├───Database (Классы для работы с базой данных)
│   │       Database.php
│   │       EntityService.php
│   
│   ├───Http ( Классы для обработки HTTP-запросов и ответов)
│   │   │   Kernel.php
│   │   │   RedirectResponse.php
│   │   │   Request.php
│   │   │   Response.php
│   │   │
│   │   └───Exceptions (Исключения для HTTP-обработки)
│   │           HttpException.php
│   │           RouteNotFoundException.php
│   │
│   ├───Model (Базовый класс для моделей)
│   │       AbstractModel.php
│   │
│   ├───Routing (Классы для маршрутизации запросов)
│   │       Route.php
│   │       Router.php
│   │
│   └───Session (Управление сессиями)
│           Session.php
```

