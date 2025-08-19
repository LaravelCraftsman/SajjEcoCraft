<div class="d-flex justify-content-center gap-2">
    <a href="{{ route($route . '.edit', $id) }}" class="btn btn-sm btn-primary">Edit</a>

    <form action="{{ route($route . '.destroy', $id) }}" method="POST"
        onsubmit="return confirm('Are you sure you want to delete this {{ ucfirst($route) }}?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
    </form>
</div>
