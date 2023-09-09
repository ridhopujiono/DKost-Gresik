<div>
    @push('style')
        @livewireStyles
        <link
            href="https://cdn.datatables.net/v/bs5/dt-1.13.6/b-2.4.2/b-html5-2.4.2/b-print-2.4.2/r-2.5.0/datatables.min.css"
            rel="stylesheet">
    @endpush

    @include('admin.layouts.toast_flash_message')

    <div class="row justify-content-between align-items-center py-3">
        <div class="col-6">
            <h4 class="card-title">{{ $sub_title }}</h4>
        </div>
        <div class="col-6">
            <a class="btn btn-primary float-end" href="{{ url('location/create') }}">Entri Data <span
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
                        <th scope="col">Alamat</th>
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
                    url: '{{ url('location') }}',
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
                        data: 'location_name',
                        name: 'location_name'
                    },
                    {
                        data: 'address',
                        name: 'address'
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
        </script>
    @endpush
</div>
