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
        <h1>Utilisateurs</h1>
    </div>

    <a href="/user/create"><button class="btn btn-lg btn-primary btn-block"> Ajouter utilisateur</button></a>
    <!-- Tableau display user -------------------------------->

    <?php if (!empty($user)) : ?>
        <section id="cheval-list">
            <?php $counter = 1 ?>
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Prenom</th>
                        <th scope="col">Email</th>
                        <th scope="col">Téléphone</th>
                        <th scope="col">Role</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($user as $users) : ?>
                        <tr>
                            <th scope="row"><?= $counter ?></th>
                            <td><?= $users->__get('prenom'); ?></td>
                            <td><?= $users->__get('nom'); ?></td>
                            <td><?= $users->__get('email'); ?></td>
                            <td><?= $users->__get('telephone'); ?></td>
                            <td><?= $users->role->nom; ?></td>
                            <td>
                                <form action="/user/delete" method="post">
                                    <input type="hidden" name="id" value="<?= $users->id; ?>">
                                    <input type="hidden" name="route" value="/user">
                                    <input type="submit" class="btn btn-secondary" value="Supprimer" name="deleteUser" onclick="//return confirm('Êtes-vous sûr de vouloir supprimer ?');">
                                </form>
                            </td>
                            <td>
                                <form action="/user/edit/<?= $users->id; ?>" method="post">
                                    <input type="submit" class="btn btn-secondary" value="Modifier" name="editUser">
                                </form>
                            </td>
                        </tr>
                        <?php $counter += 1 ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    <?php else :
        echo "Oops, vous n'avez pas encore d'utilisateurs, rajoutez en un pour commencer" // CHANGE -------------------------------------------------------------------
    ?>
    <?php endif; ?>