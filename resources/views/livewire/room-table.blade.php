<div>
    @push('style')
        @livewireStyles
        <link
            href="https://cdn.datatables.net/v/bs5/dt-1.13.6/b-2.4.2/b-html5-2.4.2/b-print-2.4.2/r-2.5.0/datatables.min.css"
            rel="stylesheet" />
    @endpush @include('admin.layouts.toast_flash_message')

    <div class="row justify-content-between align-items-center py-3">
        <div class="col-3">
            <h4 class="card-title">{{ $sub_title }}</h4>
        </div>
        <div class="col">
            <button type="button" class="btn btn-light shadow-sm ms-2 float-end" data-bs-toggle="modal"
                data-bs-target="#duplicateForm">
                Duplikasi Kamar Kos <span class="bx bx-copy"></span>
            </button>
            <a class="btn btn-primary float-end" href="{{ url('rooms/create') }}">Entri Data <span
                    class="bx bx-plus"></span></a>
        </div>
    </div>
    <div wire:ignore class="card">
        <div class="card-body">
            <table class="table table-striped" id="table-body">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama Lokasi</th>
                        <th scope="col">Nama Kamar</th>
                        <th scope="col">Tipe Kamar</th>
                        <th scope="col">Status Kamar</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <!-- Modal Body -->
    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
    <div wire:ignore.self class="modal fade" id="duplicateForm" tabindex="-1" data-bs-backdrop="static"
        data-bs-keyboard="false" role="dialog" aria-labelledby="duplicateFormModalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="duplicateFormModalTitleId">
                        Duplikasi Kamar Kos
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="save">
                        <div class="form-group mb-3">
                            <label id="locations" class="form-label">Pilih Lokasi</label>
                            <select id="locations" class="form-select @error('locationSelected') is-invalid @enderror"
                                wire:model='locationSelected'>
                                <option>SILAHKAN PILIH LOKASI</option>
                                @foreach ($locations as $location)
                                    <option value="{{ $location->id }}">
                                        {{ $location->location_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('locationSelected')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @if ($locationSelected !== null)
                            <div class="form-group mb-3">
                                <label id="rooms" class="form-label">Pilih Kamar</label>
                                <select id="rooms" class="form-select @error('roomSelected') is-invalid @enderror"
                                    wire:model='roomSelected'>
                                    <option>SILAHKAN PILIH KAMAR</option>
                                    @foreach ($rooms as $room)
                                        <option value="{{ $room->id }}">
                                            {{ $room->room_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('roomSelected')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Keluar
                    </button>
                    <button class="btn btn-primary" wire:loading.attr="disabled">
                        Duplikasi
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Optional: Place to the bottom of scripts -->
    <script>
        const myModal = new bootstrap.Modal(
            document.getElementById("modalId"),
            options
        );
    </script>
    @push('script')
        @livewireScripts
        <script src="https://cdn.datatables.net/v/bs5/dt-1.13.6/b-2.4.2/b-html5-2.4.2/b-print-2.4.2/r-2.5.0/datatables.min.js">
        </script>
        <script>
            let dataTable = $('#table-body').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ url('rooms') }}',
                    type: 'GET',
                },
                columns: [{
                        data: null,
                        name: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, full, meta) {
                            return meta.row + 1; // Ini akan menghasilkan nomor urut
                        }
                    },
                    {
                        data: 'location.location_name', // Nama kolom yang telah disertakan dalam respons JSON
                        name: 'location.location_name'
                    },
                    {
                        data: 'room_name', // Nama kolom yang telah disertakan dalam respons JSON
                        name: 'room_name'
                    }, {
                        data: 'room_type', // Nama kolom yang telah disertakan dalam respons JSON
                        name: 'room_type',
                        render: function(data) {
                            return `<div class="badge bg-${data == 'campur' ? 'primary' : data == 'putra' ? 'success' : 'warning'}">${data}</div>`;
                        }

                    },
                    {
                        data: 'is_reserved', // Nama kolom yang telah disertakan dalam respons JSON
                        name: 'is_reserved',
                        render: function(data) {
                            return `<div class="badge bg-${data ? 'danger' : 'success'}">${data ? 'penuh' : 'tersedia'}</div>`;
                        }
                    },
                    {
                        data: 'action', // Nama kolom yang telah disertakan dalam respons JSON
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, full, meta) {
                            return data; // Menggunakan render untuk menginterpretasikan HTML
                        },
                    }
                ],
                order: [
                    [1, 'asc']
                ] // Urutkan berdasarkan kolom No secara default
            });

            function showConfirmation(id) {
                if (confirm("Apakah Anda yakin ingin menghapus item ini?")) {
                    @this.delete(id); // Panggil metode Livewire jika konfirmasi "Ya"
                }
            }

            Livewire.on('needRefresh', () => {
                dataTable.ajax.reload()
            });
        </script>
    @endpush
</div>
