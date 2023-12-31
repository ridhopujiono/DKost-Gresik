<div>
    @push('style')
        @livewireStyles
        <link
            href="https://cdn.datatables.net/v/bs5/dt-1.13.6/b-2.4.2/b-html5-2.4.2/b-print-2.4.2/r-2.5.0/datatables.min.css"
            rel="stylesheet">
    @endpush

    @include('admin.layouts.toast_flash_message')

    <div class="d-flex justify-content-between align-items-center py-3">
        <h4 class="card-title">{{ $sub_title }}</h4>
        <a href="{{ url('residents/create') }}" class="btn btn-primary">Tambah Penghuni <span
                class="bx bx-plus"></span></a>
    </div>
    <div wire:ignore class="card">
        <div class="card-body">
            <table class="table table-striped" id="table-body">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Checkout</th>
                        <th scope="col">Nama Kamar</th>
                        <th scope="col">Nama Penghuni</th>
                        <th scope="col">Terdaftar</th>
                        <th scope="col">Tanggal Mulai</th>
                        <th scope="col">Tanggal Berakhir</th>
                        <th scope="col">Lama Sewa Tersisa</th>
                        <th scope="col">Status</th>
                        <th scope="col">Telat</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    @push('script')
        @livewireScripts
        <script src="https://cdn.datatables.net/v/bs5/dt-1.13.6/b-2.4.2/b-html5-2.4.2/b-print-2.4.2/r-2.5.0/datatables.min.js">
        </script>
        <script>
            let dataTable = $('#table-body').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ url('residents') }}',
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
                        data: 'is_checkout',
                        name: 'is_checkout',
                        render: function(data, type, full, meta) {
                            if (parseInt(data) === 1) {
                                return `<div class="form-check form-switch">
                                    <input  onchange='checkoutResident(${full['id']},${full['room']['id']},false)' class="form-check-input" type="checkbox" style="width: 3em;height: 1.7em;" checked /></div>`
                            } else {
                                return `<div class="form-check form-switch">
                                    <input onchange='checkoutResident(${full['id']},${full['room']['id']},true)' class="form-check-input" type="checkbox" style="width: 3em;height: 1.7em;" /></div>`
                            }
                        },
                    },
                    {
                        data: 'room.room_name',
                        name: 'room_name',
                        searchable: true
                    },
                    {
                        data: 'name',
                        name: 'name',
                        searchable: true
                    },
                    {
                        data: 'registered_at',
                        name: 'registered_at',
                        searchable: true,
                        render: function(data) {
                            return data;
                        }
                    },
                    {
                        data: 'contract_start',
                        name: 'contract_start',
                        searchable: true
                    },
                    {
                        data: 'contract_end',
                        name: 'contract_end',
                        searchable: true
                    },
                    {
                        data: 'rental_period',
                        name: 'rental_period',
                        searchable: true
                    },
                    {
                        data: 'payment_status',
                        name: 'payment_status',
                        render: function(data) {
                            return data == 'lunas' ? `<span class="badge bg-success text-white">Lunas</span>` :
                                `<span class="badge bg-danger text-white">Belum Lunas</span>`
                        },
                        searchable: true
                    },
                    {
                        data: 'late_status',
                        name: 'late_status',
                        render: function(data) {
                            return data == 0 ? `<span class="badge bg-success text-white">Belum Telat</span>` :
                                `<span class="badge bg-danger text-white">Telat</span>`
                        },
                        searchable: true
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, full, meta) {
                            return data; // Menggunakan render untuk menginterpretasikan HTML
                        },
                    },
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

            function checkoutResident(resident_id, room_id, isChecked) {
                Livewire.emit('triggerCheckoutResident', resident_id, room_id, isChecked)
            }
        </script>
    @endpush
</div>
