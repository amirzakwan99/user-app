<div>
    <a href="{{ $editUrl }}" title="Edit">
        <button class="btn btn-warning" type="button">
            Edit
        </button>
    </a>
    <form action="{{ $deleteUrl }}" method="POST" onsubmit="return confirm('Are you sure?')" style="display:inline;">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger" type="submit" title="Delete">
            Delete
        </button>
    </form>
</div>
