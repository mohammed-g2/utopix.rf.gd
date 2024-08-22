<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-12">
            <form action="" method="post" class="glass-bg p-5" enctype="multipart/form-data">
                <h4 class="text-center">Create a new category</h4>
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input value="<?= $variables['category']['name'] ?? '' ?>" name="name" type="text" class="form-control" id="name">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" type="text" class="form-control" id="description"><?= $variables['category']['description'] ?? '' ?></textarea>
                </div>
                <div class="mb-3">
                    <input name="img" type="file" id="image-upload" accept="image/*">
                </div>
                <div class="text-center mt-5">
                    <button type="submit" class="btn btn-red px-5">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>