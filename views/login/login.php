<?php  if(isset($messageErreur)){?>
  <div class="container-fluid">
    <div class="row">
            <div class="alert alert-danger alert-dismissible text-center" role="alert">
            <?php echo ($messageErreur);?>
            </div>
  </div>
</div>
<?php } ?>
<div class="text-center" class="loginPage">
  <form class="form-signin needs-validation" action="/user/login" method="post" novalidate>
    <img class="mb-4" src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
    <h1 class="h3 mb-3 font-weight-normal">Se connecter</h1>
    <label for="inputEmail" class="sr-only"></label>
    <input type="email" id="inputEmail" class="form-control" name="email" placeholder="Adresse email" autofocus required>

    <label for="inputPassword" class="sr-only"></label>
    <input type="password" id="inputPassword" name="mdp" class="form-control" placeholder="Mot de passe" required>
    <div class="checkbox mb-3">
      <label>
        <input type="checkbox" value="remember-me"> Rester connecter
      </label>
    </div>
    <button class="btn btn-lg btn-primary btn-block" class="btn-login" type="submit">Se connecter</button>

  </form>
</div>