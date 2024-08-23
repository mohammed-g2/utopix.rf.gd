<link rel="stylesheet" href="/assets/css/write.css">

<script src="/assets/libs/js/showdown.min.js"></script>
<script src="/assets/js/write.js"></script>

<div class="container-fluid px-0 mx-0 h-100">
    <form action="" method="post" enctype="multipart/form-data">
        <div class="banner">
            <img src="<?=$variables['post']['img_url'] ?? '' ?>" id="img-preview" class="img-preview">
        </div>

        <div class="blog">
            <input 
                name="title" 
                value="<?=$variables['post']['title'] ?? '' ?>"
                class="title" 
                type="text" 
                id="post-title" 
                placeholder="Post Title...">
            <textarea 
                name="body" 
                class="article" 
                id="post-body" 
                placeholder='Start writing here...'><?=$variables['post']['body'] ?? ''?></textarea>
        </div>

        <div class="blog-options">
            <button class="btn btn-success me-3 px-5">Publish</button>
            <a href="#" class="btn btn-warning me-3 px-5" onclick="previewPost()">Preview</a>

            <input name="img" type="file" id="image-upload" class="img-upload" hidden="true" accept="image/*" onclick="imgUpload()">
            <label for="image-upload" class="btn btn-secondary px-4">Upload Image</label>

            <select name="category_id" class="form-select form-select-sm ms-3 py-2" style="max-width:160px;">
                <?php foreach ($variables['categories'] as $cat): ?>
                    <option value="<?=$cat->id?>"><?=$cat->name?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </form>

    <!-- error image upload modal -->
    <div id="upload-err" class="modal fade" style="color:#000;">
        <div class="modal-dialog">
            <div class="modal-content bg-warning border-0">
                <div class="modal-header border-bottom border-dark">
                    An Error ocurred
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">Image shouldn't be larger than 1 MB.</div>
            </div>
        </div>
    </div>

    <!-- preview post modal -->
    <div id="preview-post" class="modal fade" style="color:#000;">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title"></h1>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>
</div>

<script>
    window.onload = () => {
        document.getElementById('footer').outerHTML = '';
    };
</script>