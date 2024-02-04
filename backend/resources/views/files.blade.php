
<form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label for="title">Заголовок</label>
        <input type="text" name="title" id="title" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="preview">preview</label>
        <input type="text" name="preview" id="preview" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="description">Описание</label>
        <textarea name="text" id="description" class="form-control" rows="4" required></textarea>
    </div>


    <div class="form-group">
        <label for="img">Изображения</label>
        <input type="file" name="img" id="img" class="form-control-file" accept="image/*">
    </div>

    <button type="submit" class="btn btn-primary">Создать</button>
</form>
