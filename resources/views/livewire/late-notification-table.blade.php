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
    </div>
    <div wire:ignore class="card">
        <div class="card-body">
            <table class="table table-striped" id="table-body">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama Penghuni</th>
                        <th scope="col">Tanggal Dikirim</th>
                        <th scope="col">Dibaca</th>
                        <th scope="col">Pesan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($notifications as $id => $notif)
                        <tr>
                            <td>{{ $id + 1 }}</td>
                            <td>{{ $notif->resident->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($notif->notification_date)->diffForHumans() }}</td>
                            <td>
                                <span
                                    class="badge {{ $notif->read_status == 0 ? 'bg-danger' : 'bg-success' }} text-white">{{ $notif->read_status == 0 ? 'Belum' : 'Sudah' }}
                                </span>
                            </td>
                            <td>{!! $notif->notification_content !!}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @push('script')
        @livewireScripts
        <script src="https://cdn.datatables.net/v/bs5/dt-1.13.6/b-2.4.2/b-html5-2.4.2/b-print-2.4.2/r-2.5.0/datatables.min.js">
        </script>
        <script>
            let dataTable = $('#table-body').DataTable({});
        </script>
    @endpush
</div>
