<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Pacom (Titre dynamique)</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/sign-in/">


  <link href="/css/style.css" rel="stylesheet">

</head>
<header>
  <nav class="navbar navbar-expand-xl navbar-dark bg-dark">
    <a class="navbar-brand" href="/index">Accueil</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample06" aria-controls="navbarsExample06" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExample06">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="#">Mes cours</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Mes chevaux</a>
        </li>

        <?php if (isset($_COOKIE['sessionToken'])) : ?>
          <li class="nav-item"><a href="/user/deleteToken" class="nav-link">Se déconnecter</a></li>
        <?php endif ?>
      </ul>

    </div>
  </nav>
</header>

<body>