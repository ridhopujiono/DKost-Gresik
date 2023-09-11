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
                    <label id="status" class="form-label">Pilih Status</label>
                    <select {{ $showMode ? 'disabled' : '' }} id="status"
                        class="form-select @error('status') is-invalid @enderror" wire:model='status'>
                        <option>SILAHKAN PILIH STATUS</option>
                        <option {{ $status == 'menunggu' ? 'selected' : '' }} value="menunggu">Menunggu
                        </option>
                        <option {{ $status == 'diterima' ? 'selected' : '' }} value="diterima">Diterima
                        </option>
                    </select>
                    @error('payment_status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-flex justify-content-between">
                    <a href="{{ url('guests') }}" class="btn btn-light border"><span
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
