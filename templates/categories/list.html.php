<div class="container my-5">
    <div class="row ">
        <?php foreach ($variables['categories'] as $category): ?>
            <div class="col-3">
                <div class="glass-bg p-3">
                    <h4 class=""><?= $category->name ?></h4>
                    <hr>
                    <p class=""><?= $category->description ?></p>

                    <?php if ($currentUser->hasPermission($permissions['EDIT_CATEGORY'])): ?>
                        <a href="categories/update/<?= $category->id ?>" class="btn btn-warning">Edit</a>
                    <?php endif; ?>

                    <?php if ($currentUser->hasPermission($permissions['DELETE_CATEGORY'])): ?>
                        <form class="d-inline" action="categories/delete" method="post">
                            <input type="hidden" name="id" value="<?= $category->id ?>">
                            <input type="submit" value="Delete" class="btn btn-danger">
                        </form>
                    <?php endif; ?>

                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>