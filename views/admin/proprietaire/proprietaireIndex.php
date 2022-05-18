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
        <h1>Propriétaires</h1>
    </div>

    <a href="/cheval"><button class="btn btn-lg btn-primary btn-block">Assigner un cheval à un utilisateur</button></a>
    <!-- Tableau display user -------------------------------->

    <?php if (!empty($user)) : ?>
        <section id="cheval-list">
            <?php $counter = 1 ?>
            <table class="table table-sm">
                <?php foreach ($proprietaire as $proprietaires) : ?>
                    <thead>
                        <tr>
                            <th scope="col"><?php echo (($proprietaires->prenom) . " " . ($proprietaires->nom)) ?></th>
                            <?php if ($proprietaires->id != $IDloggedUser['UserID']) :  ?>
                                <th>
                                    <form action="/user/delete" method="post">
                                        <input type="hidden" name="id" value="<?= $proprietaires->id; ?>">
                                        <input type="hidden" name="route" value="/user?redirect=prop&">
                                        <input type="submit" class="btn btn-danger" value="Supprimer propriétaire" name="deleteUser" onclick="//return confirm('Êtes-vous sûr de vouloir supprimer ?');">
                                    </form>
                                </th>
                            <?php else : ?>
                                <td>(MOI)</td>
                            <?php endif ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($proprietaires->cheval as $chevaux) :  // Afficher les chevaux de chaque propriétaire en dessous de clui-ci
                        ?>
                            <tr>
                                <td><?= $chevaux->__get('nom'); ?></td>
                                <td>
                                    <form action="/cheval/delete" method="post">
                                        <input type="hidden" name="id" value="<?= $chevaux->id; ?>">
                                        <input type="hidden" name="route" value="/user?redirect=prop&">
                                        <input type="submit" class="btn btn-secondary" value="Supprimer cheval" name="deleteUser" onclick="//return confirm('Êtes-vous sûr de vouloir supprimer ?');">
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php $counter += 1 ?>
                    <?php endforeach; ?>
                    </tbody>
            </table>
        </section>
    <?php else :
        echo "Oops, vous n'avez pas encore d'utilisateurs, rajoutez en un pour commencer" // CHANGE -------------------------------------------------------------------
    ?>
    <?php endif; ?>