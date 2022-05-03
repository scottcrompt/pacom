<div class="bg-light">
  <div class="container">
    <div class="py-5 text-center">
      <span class="logo"><img class="d-block mx-auto mb-4" src="/img/logo.jpg" alt="" width="72" height="72"></span>
      <h2>Formulaire d'inscription</h2>
    </div>
    <div class="center">
      <div class="row">
        <div class="col-md-0 order-md-0">
          <form action="/user/register" method="post" class="needs-validation" novalidate>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="firstName">Prénom</label>
                <input type="text" class="form-control" name="prenom" id="prenom" placeholder="" value="" required>
                <div class="invalid-feedback">
                  Un prénom valide est requis.
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="lastName">Nom</label>
                <input type="text" class="form-control" name="nom" id="nom" placeholder="" value="" required>
                <div class="invalid-feedback">
                  Un nom valide est requis.
                </div>
              </div>
            </div>
            <div class="mb-3">
              <label for="email">Email</label>
              <input type="email" class="form-control" name="email" id="email" placeholder="exemple@exemple.com" required>
              <div class="invalid-feedback">
                Un email valide est requis.
              </div>
            </div>
            <div class="mb-3">
              <label for="mdp">Mot de passe</label>
              <input type="password" class="form-control" name="mdp" id="mdp" placeholder="" required>
              <div class="invalid-feedback">
                Un mot de passe valide est requis.
              </div>
            </div>

            <hr class="mb-4">
            <button class="btn btn-primary btn-lg btn-block" type="submit">S'inscrire</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>