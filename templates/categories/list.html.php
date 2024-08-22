<div class="container my-5">
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php foreach ($variables['categories'] as $category): ?>
            <div class="col">
                <div class="card">
                    <img src="<?= $category->img_url ?? '' ?>" class="card-img-top">
                    <h5 class="card-title pt-2 ps-2"><?= $category->name ?></h5>
                    <div class="card-body">
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
            </div>
        <?php endforeach; ?>
    </div>
</div>