<div class="modal fade" id="deleteModal{{ $animal->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $animal->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel{{ $animal->id }}">Delete Animal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this animal?</p>
            </div>
            <div class="modal-footer">
                <form action="{{ url('delete-animal', $animal->id) }}" method="POST">
                    @csrf
                    @method('POST') <!-- Use DELETE method for better RESTful practice -->
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>