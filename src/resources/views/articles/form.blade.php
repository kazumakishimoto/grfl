@csrf
<div class="md-form">
    <label>タイトル</label>
    <input type="text" name="title" class="form-control" required value="{{ $article->title ?? old('title') }}">
</div>

<div class="form-group">
    <label for="pref">所在地</label>
    <select class="form-control" id="pref" name="pref">
        @foreach($prefs as $key => $score)
        <option value="{{ $key }}">{{ $score }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <article-tags-input :initial-tags='@json($tagNames ?? [])' :autocomplete-items='@json($allTagNames ?? [])'>
    </article-tags-input>
</div>
<div class="form-group">
    <textarea name="body" required class="form-control" rows="16" placeholder="本文">{{ $article->body ?? old('body') }}</textarea>
</div>
<div class="form-group">
    <label for="image"></label>
    <input id="image" type="file" name="image" accept="image/*" onchange="previewImage(this);">
</div>
