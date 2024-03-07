<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>
    <div class="bg-dark">
        <div class="container">
            <div class="row">
                <nav class="col navbar navbar-expand-lg navbar-dark">
                    <a class="navbar-brand" href="/mvc-employees/employee/index/1">mvc-employee</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div id="navbarContent" class="collapse navbar-collapse">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="/mvc-employees/employee/index/1">Liste des salariés</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/mvc-employees/employee/newView">Nouveau salarié</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/mvc-employees/departement/index">Liste des services</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/mvc-employees/departement/newView">Nouveau service</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col">
                <div class="jumbotron">
                    <h1>Bienvenue sur mvc-employee !</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <?php if (App\Lib\Session::showFlashes('error')) : ?>
            <div class="alert alert-danger" role="alert">
                <?php foreach (App\Lib\Session::getFlashes('error') as $message) : ?>
                    <p><?= $message ?></p>
                <?php endforeach ?>
            </div>
        <?php endif ?>

        <?php if (App\Lib\Session::showFlashes('success')) : ?>
            <div class="alert alert-success">
                <?php foreach (App\Lib\Session::getFlashes('success') as $message) : ?>
                    <p><?= $message ?></p>
                <?php endforeach ?>
            </div>
        <?php endif ?>
    </div>

    <?= $pageContent; ?>

    <div class="bg-light">
        <div class="container">
            <div class="row">
                <div class="col">
                    <ul class="list-inline text-center">
                        <li class="list-inline-item"><a href="#">À propos</a></li>
                        <li class="list-inline-item">&middot;</li>
                        <li class="list-inline-item"><a href="#">Vie privée</a></li>
                        <li class="list-inline-item">&middot;</li>
                        <li class="list-inline-item"><a href="#">Conditions d'utilisations</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>