
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Pacom (Titre dynamique)</title>

  <!-- Date and timePicker -->
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
  <!--DatePicker-->
  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">


  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/sign-in/">


  <link href="/css/style.css" rel="stylesheet">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">



</head>
<header>
  <nav class="navbar navbar-expand-xl navbar-dark bg-dark">
    <a class="navbar-brand" href="/index">Accueil</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample06" aria-controls="navbarsExample06" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarsExample06">
      <ul class="navbar-nav mr-auto">
      <?php if (isset($_SESSION['roleLoggedUser']) && $_SESSION['roleLoggedUser']=='user' && isset($_COOKIE['sessionToken'])) :  
        // Navbar USER ?>
        <li class="nav-item active">
          <a class="nav-link" href="#">Mes cours</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Mes chevaux</a>
        </li>
        <?php endif ?>
        <?php if (isset($_SESSION['roleLoggedUser']) && $_SESSION['roleLoggedUser']=='admin' && isset($_COOKIE['sessionToken'])) :  
          // Navbar ADMIN?> 

        <li class="nav-item active">
          <a class="nav-link" href="/cours">Cours</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/cheval">Chevaux</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/user">Utilisateurs</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="/user?redirect=prop">Propriétaire</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Admin</a>
        </li>
        <?php endif ?>
        <?php if (isset($_COOKIE['sessionToken']) || isset($_SESSION['roleLoggedUser']) ) : 
          //Afficher seulement si connecté?>
          <li class="nav-item"><a href="/user/deleteToken" class="nav-link">Se déconnecter</a></li>
        <?php endif ?>
      </ul>

    </div>
  </nav>
</header>

<body>