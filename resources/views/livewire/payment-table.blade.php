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
        {{-- <div class="col-6">
            <a class="btn btn-primary float-end" href="{{ url('payments/create') }}">Entri Data <span
                    class="bx bx-plus"></span></a>
        </div> --}}
    </div>
    <div wire:ignore class="card">
        <div class="card-body">
            <table class="table table-striped" id="table-body">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama Penghuni</th>
                        <th scope="col">Nama Kamar</th>
                        <th scope="col">Tanggal Pembayaran</th>
                        <th scope="col">Total Pembayaran</th>
                        <th scope="col">Lihat Bukti Pembayaran</th>
                        <th scope="col">Status Verifikasi</th>
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
                    url: '{{ url('payments') }}',
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
                        data: 'resident.name',
                        name: 'resident.name'
                    },
                    {
                        data: 'room_name',
                        name: 'room_name',
                        searchable: true,
                        render: function(data, type, full, meta) {
                            return data; // Menggunakan render untuk menginterpretasikan HTML
                        },
                    },
                    {
                        data: 'payment_date',
                        name: 'payment_date'
                    },
                    {
                        data: 'amount',
                        name: 'amount',
                        render: function(data) {
                            return new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR'
                            }).format(data);
                        }
                    },
                    {
                        data: 'payment_proof',
                        name: 'payment_proof',
                        render: function(data, type, full, meta) {
                            return `<a href="${data}" class="badge bg-primary" target="_blank">lihat</a>`; // Menggunakan render untuk menginterpretasikan HTML
                        },
                    },
                    {
                        data: 'verification_status',
                        name: 'verification_status'
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
