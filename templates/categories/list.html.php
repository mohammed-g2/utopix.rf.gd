<div class="container my-5">
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php foreach ($variables['categories'] as $category): ?>
            <div class="col">
                <a href="/categories/get/<?= $category->id ?>">
                    <div class="card">
                        <img src="<?= $category->img_url ?? '' ?>" class="card-img-top">
                        <h5 class="card-title pt-2 ps-2"><?= $category->name ?></h5>
                        <div class="card-body">
                            <p class=""><?= $category->description ?></p>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>