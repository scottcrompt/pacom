<div class="bg-light">
  <div class="container">
    <div class="py-5 text-center">
      <span class="logo"><img class="d-block mx-auto mb-4" src="/img/logo.jpg" alt="" width="72" height="72"></span>
      <h2>Modifier <?php echo($cheval->nom) ?></h2>
    </div>
    <div class="center">
      <div class="row">
        <div class="col-md-0 order-md-0">
          <form action="/cheval/update/<?= $cheval->id ?>" method="post" class="needs-validation" novalidate>
            <div class="row">
              <div class="mb-3">
                <label for="lastName">Nom</label>
                <input type="text" class="form-control" name="nom" id="nom" value=<?php echo $cheval->nom;  ?> required>
                <div class="invalid-feedback">
                  Un nom valide est requis.
                </div>
              </div>
            </div>
            <div class="mb-3">
              <label for="text">Propriétaire</label>
              <?php if (isset($user)) : ?>
                <select class="form-control" name="user" id="user" required>
                    <?php foreach ($user as $users) : ?>
                        <option value="<?= $users->id ?>" <?php  if($users->nom == $cheval->user->nom){echo "selected";} ?>> <?= $users->prenom." ".$users->nom; ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">
                     Veuillez choisir un utilisateur
                </div>
            <?php else : $messageErreur = "Pas d'utilisateurs disponibles";?>
            <?php endif ?>
            <input type="hidden" name="route" value="/cheval">
            </div>
            <hr class="mb-4">
            <button class="btn btn-primary btn-lg btn-block" type="submit">Modifier</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>