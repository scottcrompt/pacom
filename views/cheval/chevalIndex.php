<div class='h1'>
    <h1>Chevaux</h1>
</div>
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
                        <td><?= $chevaux->user->nom; ?></td>
                        <td>
                            <form action="/cheval/delete" method="post">
                                <input type="hidden" name="id" value="<?= $chevaux->id; ?>">
                                <input type="submit" class="btn btn-secondary" value="Supprimer" name="deleteCheval">
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