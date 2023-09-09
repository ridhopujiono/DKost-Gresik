<div>
    <div class="toast bs-toast fade @if (session('success') || session('error')) show @else fade @endif position-fixed  p-3 @if (session('success')) bg-primary @elseif (session('error')) bg-danger @endif"
        style="z-index: 999999999999; top: 20px; right: 20px" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <i
                class="bx @if (session('success')) bx-check @elseif(session('error')) bx-error @endif me-2"></i>
            <div class="me-auto fw-semibold">
                @if (session('success'))
                    Success
                @elseif(session('error'))
                    Error
                @endif
            </div>

            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            @if (session('success'))
                {{ session('success') }}
            @elseif(session('error'))
                {{ session('error') }}
            @endif
        </div>
    </div>
</div>
