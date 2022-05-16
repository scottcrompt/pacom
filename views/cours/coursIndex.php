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
        <h1>Cours</h1>
    </div>

    <a href="/cours/create"><button class="btn btn-lg btn-primary btn-block"> Créer un cours</button></a>
    <!-- Tableau display Cours -------------------------------->
<?php var_dump($cours); ?>
    <?php if (!empty($cours)) : ?>
        <section id="cheval-list">
            <?php $counter = 1 ?>
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Date et heure</th>
                        <th scope="col">Prix</th>
                        <th scope="col">Nombre de places</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cours as $courss) : ?>
                        <tr>
                            <th scope="row"><?= $counter ?></th>
                            <td><?= $courss->__get('CoursDateTime'); ?></td>
                            <td><?= $courss->__get('CoursPrix'); ?></td>
                            <td><?= $courss->__get('CoursPlace'); ?></td>
                            <td>
                                <form action="/cours/delete" method="post">
                                    <input type="hidden" name="id" value="<?= $courss->id; ?>">
                                    <input type="hidden" name="route" value="/cours">
                                    <input type="submit" class="btn btn-secondary" value="Supprimer" name="deleteCours" onclick="//return confirm('Êtes-vous sûr de vouloir supprimer ?');">
                                </form>
                            </td>
                            
                            <td>
                                <form action="/cours/edit/<?= $courss->id; ?>" method="post">
                                    <input type="submit" class="btn btn-secondary" value="Modifier" name="editCours">
                                </form>
                            </td>
                        </tr>
                        <?php $counter += 1 ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    <?php else :
        echo "Oops, vous n'avez pas encore de cours, rajoutez en un pour commencer" // CHANGE -------------------------------------------------------------------
    ?>
    <?php endif; ?>