<div>
    @push('style')
        @livewireStyles
    @endpush
    <h4 class="card-title">{{ $sub_title }}</h4>

    @include('admin.layouts.toast_flash_message')

    <div class="card">
        <div class="card-body">
            <form wire:submit.prevent="save">
                <div class="form-group mb-3">
                    <label for="facility_name" class="form-label">Nama Fasilitas</label>
                    <input {{ $showMode ? 'disabled' : '' }} wire:model='facility_name' type="text"
                        class="form-control @error('facility_name') is-invalid @enderror" name="facility_name"
                        value="{{ $facility_name }}" />
                    @error('facility_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-flex justify-content-between">
                    <a href="{{ url('facilities') }}" class="btn btn-light border"><span
                            class="bx bx-chevron-left"></span>Kembali
                    </a>
                    @if (!$showMode)
                        <button type="submit" class="btn btn-primary" wire:loading.attr='disabled'
                            wire:.loading.delay.longest>Simpan <span class="bx bx-save"></span>
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>
    @push('script')
        @livewireScripts
    @endpush
</div>
