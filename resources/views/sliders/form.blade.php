@php
    $isEdit = isset($slider);
@endphp

<div class="mb-3">
    <label for="title" class="form-label">Title</label>
    <input type="text" name="title" class="form-control" value="{{ old('title', $slider->title ?? 'SajjEcoCraft') }}">
</div>

<div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea name="description" class="form-control">{{ old('description', $slider->description ?? 'SajjEcoCraft') }}</textarea>
</div>

<div class="mb-3">
    <label for="tag" class="form-label">Tag</label>
    <input type="text" name="tag" class="form-control" value="{{ old('tag', $slider->tag ?? 'SajjEcoCraft') }}">
</div>

<div class="mb-3">
    <label for="cta_label" class="form-label">CTA Label</label>
    <input type="text" name="cta_label" class="form-control"
        value="{{ old('cta_label', $slider->cta_label ?? 'SajjEcoCraft') }}">
</div>

<div class="mb-3">
    <label for="cta_url" class="form-label">CTA URL</label>
    <input type="url" name="cta_url" class="form-control"
        value="{{ old('cta_url', $slider->cta_url ?? 'https://www.google.com') }}">
</div>

<div class="mb-3">
    <label for="status" class="form-label">Status</label>
    <select name="status" class="form-select">
        <option value="active" {{ old('status', $slider->status ?? '') == 'active' ? 'selected' : '' }}>Active</option>
        <option value="inactive" {{ old('status', $slider->status ?? '') == 'inactive' ? 'selected' : '' }}>Inactive
        </option>
    </select>
</div>

<div class="mb-3">
    <label for="image" class="form-label">Slider Image</label>
    <input type="file" name="image" class="form-control">

    @if ($isEdit && $slider->image)
        <p class="mt-2">
            <strong>Current:</strong><br>
            <img src="{{ asset($slider->image) }}" width="200">
        </p>
    @endif
</div>
