<div>
    @push('style')
        @livewireStyles
    @endpush
    <h4 class="card-title">{{ $sub_title }}</h4>

    @include('admin.layouts.toast_flash_message')

    <div class="card">
        <div class="card-body">
            <form class="" wire:submit.prevent="save">

                @foreach ($images as $image)
                    @php
                        $extension = pathinfo($image->image, PATHINFO_EXTENSION);
                    @endphp

                    @if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif']))
                        <!-- Ini adalah gambar -->
                        <img src="{{ $image->image }}" alt="Image" height="200px" class="mb-3">
                    @elseif (in_array($extension, ['mp4', 'avi', 'mov', 'wmv']))
                        <!-- Ini adalah video -->
                        <video controls>
                            <source src="{{ $image->image }}" type="video/mp4" height="200px" class="mb-3">
                            Your browser does not support the video tag.
                        </video>
                    @endif
                @endforeach
                <div class="form-group"><button type='button' class="btn btn-primary" wire:click='addFile'>Tambah
                        File</button></div>
                @foreach ($files as $index => $file)
                    <div class="form-group mt-3 mb-3">
                        <div class="d-flex justify-content-between gap-2">
                            <input class="form-control" type="file" wire:model="files.{{ $index }}"
                                width="90%" accept="image/*, video/*" />
                            <button type="button" class="btn btn-danger"
                                wire:click="removeFile({{ $index }})"><span class="bx bx-trash"></span></button>
                        </div>
                    </div>
                @endforeach
                @if (count($files) > 0)
                    <div class="form-group mb-3">
                        <button type="submit" class="btn btn-primary">Simpan
                            <span class="bx bx-save"></span></button>
                    </div>
                @endif


            </form>
        </div>
    </div>
    @push('script')
        @livewireScripts
    @endpush
</div>
