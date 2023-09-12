<div>
    @push('style')
        @livewireStyles
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    @endpush
    <h4 class="card-title">{{ $sub_title }}</h4>

    @include('admin.layouts.toast_flash_message')

    <div class="card">
        <div class="card-body">
            <form wire:submit.prevent="save">
                @if ($locations)
                    <div class="form-group mb-3">
                        <label id="locations" class="form-label">Pilih Lokasi</label>
                        <select {{ $showMode ? 'disabled' : '' }} id="locations"
                            class="form-select @error('locationSelected') is-invalid @enderror"
                            wire:model='locationSelected'>
                            <option>SILAHKAN PILIH LOKASI</option>
                            @foreach ($locations as $location)
                                <option {{ $location->id == $location_id ? 'selected' : '' }}
                                    value="{{ $location->id }}">
                                    {{ $location->location_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('locationSelected')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label id="rooms" class="form-label">Pilih Kamar</label>
                        <select {{ $showMode ? 'disabled' : '' }} id="rooms"
                            class="form-select @error('room_id') is-invalid @enderror" wire:model='room_id'>
                            <option>SILAHKAN PILIH KAMAR</option>
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}">
                                    {{ $room->room_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('room_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                @endif
                <div class="form-group mb-3">
                    <label for="name" class="form-label">Nama Penghuni</label>
                    <input {{ $showMode ? 'disabled' : '' }} wire:model='name' type="text"
                        class="form-control @error('name') is-invalid @enderror" name="name"
                        value="{{ $name }}" />
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="address" class="form-label">Alamat</label>
                    <textarea {{ $showMode ? 'disabled' : '' }} wire:model='address' type="text"
                        class="form-control @error('address') is-invalid @enderror" name="address" value="{{ $address }}">{{ $address }}</textarea>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="contact" class="form-label">Kontak Penghuni</label>
                    <input {{ $showMode ? 'disabled' : '' }} wire:model='contact' type="text"
                        class="form-control @error('contact') is-invalid @enderror" name="contact"
                        value="{{ $contact }}" />
                    @error('contact')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="contact_name" class="form-label">Nomor Darurat</label>
                    <div class="d-flex gap-2">
                        <div style='width: 50%'>
                            <input {{ $showMode ? 'disabled' : '' }} wire:model='contact_name' type="text"
                                class="form-control @error('contact_name') is-invalid @enderror" name="contact_name"
                                value="{{ $contact_name }}" placeholder="Nama Nomor Darurat. Contoh: Ibu, Ayah" />
                            @error('contact_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div style='width: 50%'>
                            <input {{ $showMode ? 'disabled' : '' }} wire:model='contact_number' type="text"
                                class="form-control @error('contact_number') is-invalid @enderror" name="contact_number"
                                value="{{ $contact_number }}" placeholder="Nomor Darurat" />
                            @error('contact_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="contract_start" class="form-label">Tanggal Mulai</label>
                    <input {{ $showMode ? 'disabled' : '' }} {{ $editMode ? 'disabled' : '' }}
                        wire:model='contract_start' type="text"
                        class="form-control {{ !$editMode ? 'is_date' : '' }} @error('contract_start') is-invalid @enderror"
                        name="contract_start" value="{{ $contract_start }}" autocomplete='off' />
                    @error('contract_start')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="contract_end" class="form-label">Tanggal Berakhir (Tenggat Pembayaran)</label>
                    <input disabled {{ $showMode ? 'disabled' : '' }} wire:model='contract_end' type="text"
                        class="form-control @error('contract_end') is-invalid @enderror" name="contract_end"
                        value="{{ $contract_end }}" />
                    @error('contract_end')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label id="payment_status" class="form-label">Pilih Status Pembayaran</label>
                    @if ($editMode)
                        <div class="alert alert-warning">Jika anda mengubahnya ke status <b>Lunas</b>, maka tenggat akan
                            bertambah 1 bulan</div>
                    @endif
                    <select {{ $showMode ? 'disabled' : '' }} id="payment_status"
                        class="form-select @error('payment_status') is-invalid @enderror" wire:model='payment_status'>
                        <option>SILAHKAN PILIH STATUS PEMBAYARAN</option>
                        <option {{ $payment_status == 'lunas' ? 'selected' : '' }} value="lunas">Lunas
                        </option>
                        <option {{ $payment_status == 'belum_lunas' ? 'selected' : '' }} value="belum_lunas">Belum
                            Lunas
                        </option>
                    </select>
                    @error('payment_status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-flex justify-content-between">
                    <a href="{{ url('residents') }}" class="btn btn-light border"><span
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
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script>
            $(".is_date").flatpickr({
                enableTime: true,
                time_24hr: true,
                minDate: "today",
                dateFormat: "Y-m-d H:i",
            });
        </script>
    @endpush
</div>
