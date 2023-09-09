<div>
    @push('style')
        @livewireStyles
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
            integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    @endpush
    <h4 class="card-title">{{ $sub_title }}</h4>

    @include('admin.layouts.toast_flash_message')

    <div class="card">
        <div class="card-body">
            <form wire:submit.prevent="save">
                <div class="form-group mb-3">
                    <label for="location_name" class="form-label">Nama Lokasi</label>
                    <input {{ $showMode ? 'disabled' : '' }} wire:model='location_name' type="text"
                        class="form-control @error('location_name') is-invalid @enderror" name="location_name"
                        value="{{ $location_name }}" />
                    @error('location_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="address" class="form-label">Alamat Lengkap</label>
                    <textarea {{ $showMode ? 'disabled' : '' }} wire:model='address'
                        class="form-control @error('address') is-invalid @enderror" name="address" value="{{ $address }}">$address</textarea>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group mb-3" wire:ignore>
                    <label for="map" wire:ignore class="form-label">Pilih Lokasi</label>
                    <div id='map' wire:ignore style="height: 500px; width: 100%"></div>
                </div>
                <div class="form-group mb-3">
                    <label for="latitudeInput" class="form-label">Latitude </label>
                    <input {{ $showMode ? 'disabled' : '' }} wire:model='latitude' disabled step='any'
                        type="text" class="form-control @error('latitude') is-invalid @enderror" name="latitude"
                        id="latitudeInput" value="{{ $latitude }}" />
                    @error('latitude')
                        <div class="invalid-feedback">{{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="longitude" class="form-label">Longitude </label>
                    <input {{ $showMode ? 'disabled' : '' }} wire:model='longitude' disabled step='any'
                        type="text" class="form-control @error('longitude') is-invalid @enderror" name="longitude"
                        id="longitudeInput" value="{{ $longitude }}" />
                    @error('longitude')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-flex justify-content-between">
                    <a href="{{ url('locations') }}" class="btn btn-light border"><span
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
        <!-- Make sure you put this AFTER Leaflet's CSS -->
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        <script>
            // initialize the map on the "map" div with a given center and zoom
            var map = L.map('map', {
                scrollWheelZoom: true, //disable zoom melalui scroll pada mouse
                zoomControl: true //disable zoom control (static)
            }).setView([-7.1635184, 112.6473031], 14); //set titik koordinat center dan zoom
            //sesuaikan titik koordinat dan zoom ini dengan posisi maps yang
            //ingin ditampilkan secara default 

            var layerGroup = L.layerGroup();

            //set base maps menggunakan google maps
            L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                attribution: 'Map &copy; <a href="https://maps.google.com/">Google Maps</a>',
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
                maxZoom: 20
            }).addTo(map);

            var markerIcon = L.icon({
                iconUrl: "{{ url('marker.png') }}",
                iconSize: [35, 35], // size of the icon
            });

            //style untuk geojson, silahkan ubah sesuai kebutuhan
            function style(feature) {
                return {
                    fillColor: '#ff7800',
                    weight: 2,
                    opacity: 1,
                    color: '#ff7800',
                    dashArray: '3',
                    fillOpacity: 0.7
                };
            }

            function addMarker(val) {
                if (map.hasLayer(layerGroup)) {
                    layerGroup.clearLayers();
                }

                var marker = L.marker(val, {
                    icon: markerIcon
                });
                layerGroup.addLayer(marker);
                map.addLayer(layerGroup);

                // Mendapatkan elemen input dengan id "latitudeInput"
                var latitudeInput = document.getElementById("latitudeInput");


                // Mengisi nilai input dengan nilai baru
                latitudeInput.value = val.lat;
                var inputEvent = new Event("input", {
                    bubbles: true,
                    cancelable: true,
                });
                latitudeInput.dispatchEvent(inputEvent);

                // Mendapatkan elemen input dengan id "longitudeInput"
                var longitudeInput = document.getElementById("longitudeInput");
                longitudeInput.value = val.lng;

                // Memicu event "input" pada elemen input untuk memperbarui model Livewire
                var inputEvent = new Event("input", {
                    bubbles: true,
                    cancelable: true,
                });
                longitudeInput.dispatchEvent(inputEvent);
            }
            // Tambahkan kode ini untuk menampilkan marker saat komponen dimuat

            @if (isset($editMode))
                @if ($editMode)
                    var lat = {{ $latitude }};
                    var lng = {{ $longitude }};
                    var initialLocation = L.latLng(lat, lng);
                    map.setView(initialLocation, 20);
                    addMarker(initialLocation);
                @endif
            @else
                // Jika $editMode tidak ada, maka kita mengatur editMode menjadi false
                var editMode = false;
            @endif

            map.on('click', function(ev) {
                var latlng = map.mouseEventToLatLng(ev.originalEvent);
                addMarker(latlng)
            });
        </script>
    @endpush
</div>
