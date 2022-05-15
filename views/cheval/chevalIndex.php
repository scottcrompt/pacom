<!-- Diplay message d'erreur-->

<?php if (isset($_GET['messageErreur'])) : ?>
    <div class="container-fluid">
        <div class="row">
            <div class="alert alert-danger alert-dismissible text-center" role="alert">
                <?php echo ($_GET['messageErreur']); ?>
            </div>
        </div>
    </div>
<?php endif ?>

<!-- Diplay message confirmation-->

<?php if (isset($_GET['message'])) : ?>
    <div>
        <div>
            <div class="alert alert-success alert-dismissible text-center" role="alert">
                <?php echo ($_GET['message']); ?>
            </div>
        </div>
    <?php endif ?>


    <div class='h1'>
        <h1>Chevaux</h1>
    </div>

    <!-- Formulaire d'ajout de cheval -------------------------------->

    <div class=alert>
        <u>
            <h2>Ajouter un cheval </h2>
        </u>

      <div class="text-center">
        <form action="/cheval/register" method="post" class="needs-validation" novalidate>
            <input class="form-control" type="text" name="nom" placeholder="Nom du cheval" required>
            <div class="invalid-feedback">
                  Veuillez choisir un nom
            </div>
            <?php if (isset($user)) : ?>
                <select class="form-control" name="user" id="user" required>
                    <option value="">Sélectionnez un utilisateur</option>
                    <?php foreach ($user as $users) : ?>
                        <option value="<?= $users->id ?>"> <?= $users->prenom." ".$users->nom; ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">
                     Veuillez choisir un utilisateur
                </div>
            <?php else : $messageErreur = "Pas d'utilisateurs disponibles";?>
            <?php endif ?>
            <input type="hidden" name="route" value="/cheval">
            <button class="btn btn-lg btn-primary btn-block" class="btn-login" type="submit">Ajouter</button>
        </form>
      </div>
    </div>

    <!-- Tableau display chevaux -------------------------------->

    <?php if (!empty($cheval)) : ?>
        <section id="cheval-list">
            <?php $counter = 1 ?>
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Propriétaire</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cheval as $chevaux) : ?>
                        <tr>
                            <th scope="row"><?= $counter ?></th>
                            <td><?= $chevaux->__get('nom'); ?></td>
                            <td><?= $chevaux->user->prenom." ".$chevaux->user->nom; ?></td>
                            <td>
                                <form action="/cheval/delete" method="post">
                                    <input type="hidden" name="id" value="<?= $chevaux->id; ?>">
                                    <input type="hidden" name="route" value="/cheval">
                                    <input type="submit" class="btn btn-secondary" value="Supprimer" name="deleteCheval" onclick="//return confirm('Êtes-vous sûr de vouloir supprimer ?');">
                                </form>
                            </td>
                            <td>
                                <form action="/cheval/edit/<?= $chevaux->id; ?>" method="post">
                                    <input type="submit" class="btn btn-secondary" value="Modifier" name="editCheval">
                                </form>
                            </td>
                        </tr>
                        <?php $counter += 1 ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    <?php else :
        echo "Oops, vous n'avez pas encore de chevaux, rajoutez en un pour commencer" // CHANGE -------------------------------------------------------------------
    ?>
    <?php endif; ?>