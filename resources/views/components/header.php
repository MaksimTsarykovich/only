<!doctype html>
<html lang="ru" data-bs-theme="auto">
<head>
    <script src="https://getbootstrap.com/docs/5.3/assets/js/color-modes.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.115.4">
    <title>Test Task</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/navbar-fixed/">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"  crossorigin="anonymous">
    <meta name="theme-color" content="#712cf9">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Offcanvas navbar large">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Test</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar2"
                aria-controls="offcanvasNavbar2" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasNavbar2"
             aria-labelledby="offcanvasNavbar2Label">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbar2Label">Offcanvas</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-start flex-grow-1 pe-3">

                    <li class="nav-item">
                        <a class="nav-link" href="/dashboard">Профиль</a>
                    </li>
                </ul>
                <div class="d-flex mt-3 mt-lg-0 gap-2">
                    <form action="/logout" method="post">
                        <button class="btn btn-outline-danger" type="submit">Выход</button>
                    </form>
                    <a class="btn btn-outline-warning" href="/login" type="submit">Вход</a>
                    <a class="btn btn-outline-warning" href="/register" type="submit">Регистриция</a>
                </div>
            </div>
        </div>
    </div>
</nav>
