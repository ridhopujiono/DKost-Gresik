<div>
    @push('style')
        @livewireStyles
        <link
            href="https://cdn.datatables.net/v/bs5/dt-1.13.6/b-2.4.2/b-html5-2.4.2/b-print-2.4.2/r-2.5.0/datatables.min.css"
            rel="stylesheet">
        <style>
            .blur-effect {
                filter: blur(5px);
            }
        </style>
    @endpush

    @include('admin.layouts.toast_flash_message')
    <div>
        <div id='toastLoading' class="toast bs-toast fade position-fixed  p-3 "
            style="z-index: 999999999999; top: 20px; right: 20px" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <i class="me-2"><img style='width: 30px'
                        src="https://res.cloudinary.com/dfy3gxotz/image/upload/v1695635506/icons8-loading_h4ypea.gif"
                        alt=""></i>
                <div class="me-auto fw-semibold">
                    Proses
                </div>

                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                {{ $loadingContent }}
            </div>
        </div>
    </div>
    <div class="row justify-content-between align-items-center py-3">
        <div class="col-12 d-flex justify-content-between">
            <h4 class="card-title">{{ $sub_title }}</h4>
        </div>
    </div>
    <div class="alert alert-primary d-none" id="loadingAlert">Mengirim email pemberitahuan ke pengguna ...</div>
    <div wire:ignore class="card">
        <div class="card-body">
            <table class="table table-striped" id="table-body">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Kamar</th>
                        <th scope="col">Nama Lengkap</th>
                        <th scope="col">Kontak</th>
                        <th scope="col">Tanggal Permintaan</th>
                        <th scope="col">Status Kamar</th>
                        <th scope="col">Diterima</th>
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
                    url: '{{ url('guests') }}',
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
                        data: 'room.room_name',
                        name: 'room.room_name',
                    },
                    {
                        data: 'guest_name',
                        name: 'guest_name'
                    },
                    {
                        data: 'guest_contact',
                        name: 'guest_contact'
                    },
                    {
                        data: 'request_date',
                        name: 'request_date'
                    },
                    {
                        data: 'room.is_reserved',
                        name: 'room.is_reserved',
                        render: function(data, type, full, meta) {
                            return `<div class="badge bg-${data === 0 ? 'danger' : 'success'}">${data === 0 ? 'Penuh' : 'Tersedia'}</div>`
                        }
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data, type, full, meta) {
                            if (data == 'menunggu' || data == 'full_booked') {
                                return `<div class="form-check form-switch">
                                <input onchange='updateBookStatus(${full['id']},true)' class="form-check-input" type="checkbox" style="width: 3em;height: 1.7em;" /></div>`
                            } else {
                                return `<div class="form-check form-switch">
                                <input onchange='updateBookStatus(${full['id']},false)' class="form-check-input" type="checkbox" style="width: 3em;height: 1.7em;" checked /></div>`
                            }
                        },
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

            function updateBookStatus(id, isChecked) {
                Livewire.emit('triggerUpdate', id, isChecked)
                dataTable.ajax.reload()
            }

            document.addEventListener('hide-alert', function() {
                document.getElementById('loadingAlert').classList.add('d-none')
            })
        </script>
    @endpush
</div>
