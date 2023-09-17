<div>
    @push('style')
        @livewireStyles
    @endpush
    <h4 class="card-title">{{ $sub_title }}</h4>

    @include('admin.layouts.toast_flash_message')


    <div class="row">
        <div class="col-md-6 mb-3">
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
                                        <option {{ $location_id == $location->id ? 'selected' : '' }}
                                            value="{{ $location->id }}">
                                            {{ $location->location_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('locationSelected')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif
                        <div class="form-group mb-3">
                            <label for="room_name" class="form-label">Nama Kamar</label>
                            <input {{ $showMode ? 'disabled' : '' }} wire:model='room_name' type="text"
                                class="form-control @error('room_name') is-invalid
                            @enderror"
                                name="room_name" value="{{ $room_name }}" /> @error('room_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label id="room_type" class="form-label">Pilih Tipe Kamar</label>
                            <select {{ $showMode ? 'disabled' : '' }} id="room_type"
                                class="form-select @error('roomTypeSelected') is-invalid @enderror"
                                wire:model='roomTypeSelected'>
                                <option>SILAHKAN PILIH TIPE KAMAR</option>
                                <option {{ $room_type == 'putri' ? 'selected' : '' }} value="putri">Putri</option>
                                <option {{ $room_type == 'putra' ? 'selected' : '' }} value="putra">Putra</option>
                                <option {{ $room_type == 'campur' ? 'selected' : '' }} value="campur">Campur</option>
                            </select>
                            @error('roomTypeSelected')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="capacity" class="form-label">Kapasitas Kamar</label>
                            <input {{ $showMode ? 'disabled' : '' }} wire:model='capacity' type="number"
                                class="form-control @error('capacity') is-invalid
                            @enderror"
                                name="capacity" value="{{ $capacity }}" /> @error('capacity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="price" class="form-label">Harga per-bulan</label>
                            <input {{ $showMode ? 'disabled' : '' }} wire:model.debounce.500ms='price' type="text"
                                class="form-control @error('price') is-invalid
                            @enderror"
                                name="price" value="{{ $price }}" />
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="stock" class="form-label">Jumlah Kamar Tersedia</label>
                            <input {{ $showMode ? 'disabled' : '' }} wire:model='stock' type="number"
                                class="form-control @error('stock')
                            is-invalid @enderror"
                                name="stock" value="{{ $stock }}" /> @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label id="room_type" class="form-label">Pilih Status Kamar</label>
                            <select {{ $showMode ? 'disabled' : '' }} id="room_type"
                                class="form-select @error('roomStatusSelected') is-invalid @enderror"
                                wire:model='roomStatusSelected'>
                                <option>SILAHKAN PILIH STATUS KAMAR</option>
                                <option {{ $room_status == 'tersedia' ? 'selected' : '' }} value="tersedia">Tersedia
                                </option>
                                <option {{ $room_status == 'penuh' ? 'selected' : '' }} value="penuh">Penuh</option>
                            </select>
                            @error('roomStatusSelected')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-body">
                    @if ($facilities)
                        <div class="form-group mb-3">
                            <label id="facilities" class="form-label">Pilih Fasilitas</label>
                            @foreach ($facilities as $index => $facility)
                                <div class="form-check">
                                    <input {{ $showMode ? 'disabled' : '' }}
                                        class="form-check-input @error('facilitySelected') is-invalid @enderror"
                                        type="checkbox" value="{{ $facility->id }}" id="checkbox-{{ $facility->id }}"
                                        name="facilities" wire:model='facilitySelected'
                                        checked="{{ in_array($facility->id, $facility_ids) ? 'true' : 'false' }}">
                                    <label class="form-check-label" for="checkbox-{{ $facility->id }}">
                                        {{ $facility->facility_name }}
                                    </label>
                                </div>
                            @endforeach
                            @error('facilitySelected')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif

                    <div class="d-flex justify-content-between">
                        <a href="{{ url('rooms') }}" class="btn btn-light border"><span
                                class="bx bx-chevron-left"></span>Kembali
                        </a>
                        @if (!$showMode)
                            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                Simpan <span class="bx bx-save"></span>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('script')
        @livewireScripts
    @endpush
</div>
