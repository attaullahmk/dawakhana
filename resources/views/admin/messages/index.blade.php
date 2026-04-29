@extends('admin.layouts.admin')

@section('header', __('Messages & Queries'))

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card p-4">
        <h5 class="fw-bold mb-4">{{ __('Customer Messages') }}</h5>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>{{ __('Date') }}</th>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Contact') }}</th>
                        <th>{{ __('Subject / Message') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th class="text-end">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($messages as $message)
                    <tr class="{{ $message->is_read ? 'text-muted' : 'fw-bold' }}" 
                        style="cursor: pointer;" 
                        onclick="if(!event.target.closest('.no-row-click')) viewMessage('{{ $message->id }}')">
                        <td class="small">{{ $message->created_at->format('M d, Y h:i A') }}</td>
                        <td>{{ $message->name }}</td>
                        <td>
                            <div class="small text-primary">{{ $message->email }}</div>
                            <small class="text-muted">{{ $message->phone ?? __('No Phone') }}</small>
                        </td>
                        <td>
                            <div class="text-truncate" style="max-width: 250px;">
                                <strong>{{ $message->subject ?: __('No Subject') }}</strong>
                                <p class="mb-0 small opacity-75">{{ Str::limit($message->message, 80) }}</p>
                            </div>
                        </td>
                        <td>
                            @if($message->is_read)
                                <span class="badge bg-light text-muted border read-status-{{ $message->id }}">{{ __('Read') }}</span>
                            @else
                                <span class="badge bg-primary rounded-pill read-status-{{ $message->id }}">{{ __('New') }}</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end no-row-click">
                                <form action="{{ route('admin.messages.destroy', $message->id) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure you want to delete this message?') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light text-danger" title="{{ __('Delete') }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">{{ __('No messages found.') }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Message Detail Modal -->
    <div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white border-0 py-3">
                    <h5 class="modal-title fw-bold" id="messageModalLabel">{{ __('Message Details') }}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
                </div>
                <div class="modal-body p-4">
                    <div id="modal-loading" class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">{{ __('Loading...') }}</span>
                        </div>
                    </div>
                    <div id="modal-content" class="d-none">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="text-muted small text-uppercase fw-bold">{{ __('From') }}</label>
                                <p id="modal-name" class="fw-bold fs-5 mb-0"></p>
                                <p id="modal-email" class="text-primary mb-0"></p>
                                <p id="modal-phone" class="text-muted small mb-0"></p>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <label class="text-muted small text-uppercase fw-bold">{{ __('Received On') }}</label>
                                <p id="modal-date" class="fw-semibold mb-0"></p>
                            </div>
                            <hr class="my-0">
                            <div class="col-12">
                                <label class="text-muted small text-uppercase fw-bold">{{ __('Subject') }}</label>
                                <p id="modal-subject" class="fw-bold lead"></p>
                            </div>
                            <div class="col-12">
                                <label class="text-muted small text-uppercase fw-bold">{{ __('Message') }}</label>
                                <div id="modal-message-body" class="p-3 bg-light rounded-3 border" style="white-space: pre-wrap;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">{{ __('Close') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function viewMessage(id) {
        const modalElement = document.getElementById('messageModal');
        const modal = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
        const modalContent = document.getElementById('modal-content');
        const modalLoading = document.getElementById('modal-loading');
        
        // Show loading state
        modalContent.classList.add('d-none');
        modalLoading.classList.remove('d-none');
        modal.show();

        // Fetch message data
        fetch(`/admin/messages/${id}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            // Populate modal
            document.getElementById('modal-name').textContent = data.name;
            document.getElementById('modal-email').textContent = data.email;
            document.getElementById('modal-phone').textContent = data.phone || 'No phone provided';
            document.getElementById('modal-subject').textContent = data.subject || 'No Subject';
            document.getElementById('modal-message-body').textContent = data.message;
            document.getElementById('modal-date').textContent = new Date(data.created_at).toLocaleString();

            // Show content
            modalLoading.classList.add('d-none');
            modalContent.classList.remove('d-none');

            // Update UI in table (mark as read)
            const row = document.querySelector(`tr[onclick*="viewMessage('${id}')"]`);
            if (row) {
                row.classList.remove('fw-bold');
                row.classList.add('text-muted');
                const badge = document.querySelector(`.read-status-${id}`);
                if (badge) {
                    badge.classList.remove('bg-primary', 'rounded-pill');
                    badge.classList.add('bg-light', 'text-muted', 'border');
                    badge.textContent = 'Read';
                }
            }
        })
        .catch(error => {
            console.error('Error fetching message:', error);
            modalLoading.innerHTML = '<div class="alert alert-danger">Error loading message. Please try again.</div>';
        });
    }
</script>
@endpush
