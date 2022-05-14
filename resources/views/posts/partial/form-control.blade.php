<div class="form-group">
    <input type="file" name="thumbnail" class="form-control">
</div>
<div class="form-group mb-2">
    <label for="title">Title :</label>
    <input type="text" class="form-control" name="title" value="{{ old('title') ?? $post->title }}">
    @error('title') <span class="text-danger">{{ $message }}</span> @enderror
</div>

<div class="form-group mb-2">
    <label for="title">Category :</label>
    <select name="category" id="category" class="form-control">
        <option value="">Choose One</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ $category->id == $post->category_id ? 'selected' : '' }}>{{ $category->category }}</option>
        @endforeach
    </select>
</div>

<div class="form-group mb-2">
    <label for="title">Tags :</label>
    <select name="tags[]" id="tags" class="form-control select2-multiple" multiple>
        @foreach ($post->tags as $tag)
            <option value="{{ $tag->id }}" selected>{{ $tag->name }}</option>
        @endforeach
        @foreach($tags as $tag)
            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
        @endforeach
    </select>
</div>

<div class="form-group mb-4">
    <label for="body">Body :</label>
    <textarea name="body" id="body" class="form-control" rows="10">{{ old('body') ?? $post->body }}</textarea>
    @error('body') <span class="text-danger">{{ $message }}</span> @enderror
</div>

<button class="btn btn-success" type="submit">{{ $submit ?? 'Simpan Post' }}</button>
<a class="btn btn-default" style="margin-left: 10px;" href="/posts">Kembali</a>