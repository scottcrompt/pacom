<div class="bg-light">
  <div class="container">
    <div class="py-5 text-center">
      <span class="logo"><img class="d-block mx-auto mb-4" src="/img/logo.jpg" alt="" width="72" height="72"></span>
      <h2>Modifier <?php echo($user->prenom) ?></h2>
    </div>
    <div class="center">
      <div class="row">
        <div class="col-md-0 order-md-0">
          <form action="/user/update/<?= $user->id ?>" method="post" class="needs-validation" novalidate>
            <div class="row">
              <div class="col-md-6 mb-3">
                    <label for="firstName">Prénom</label>
                    <input type="text" class="form-control" name="prenom" id="prenom" placeholder="" value="<?php echo $user->prenom;  ?>" required>
                    <div class="invalid-feedback">
                      Un prénom valide est requis.
                    </div>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="lastName">Nom</label>
                    <input type="text" class="form-control" name="nom" id="nom" placeholder="" value="<?php echo $user->nom; ?>" required>
                    <div class="invalid-feedback">
                      Un nom valide est requis.
                    </div>
                  </div>
                </div>
                <div class="mb-3">
                  <label for="telephone">Numéro de téléphone</label>
                  <input type="text" class="form-control" name="telephone" id="telephone" placeholder="" value="<?php echo $user->telephone; ?>" required >
                  <div class="invalid-feedback">
                    Un numéro de téléphone valide est requis.
                  </div>
                </div>
                <div>
                  <label for="mdp2">Role</label>
                  <select class="form-control" name="role" id="role" required>
                    <?php foreach ($role as $roles) : ?>
                      <option value="<?= $roles->id ?>" <?php if ($roles->nom == $user->role->nom) {
                                                          echo "selected";
                                                        } ?>> <?= $roles->nom; ?></option>
                    <?php endforeach; ?>
                  </select>
                  <div class="invalid-feedback">
                    Veuillez choisir un role
                  </div>
                </div>
                <input type="hidden" name="route" value="/user">
            <hr class="mb-4">
            <button class="btn btn-primary btn-lg btn-block" type="submit">Modifier</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
                  