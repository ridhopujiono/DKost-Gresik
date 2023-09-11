<div>
    <button type="button" class="btn btn-primary" wire:click="addFile">Tambah File <span
            class="bx bx-plus"></span></button>

    @foreach ($files as $index => $file)
        <div class="form-group">
            <div class="d-flex justify-content-between gap-2">
                <input class="form-control" type="file" wire:model="files.{{ $index }}" width="40%" />
                <div>
                    <label>
                        Sampul
                        <input type="radio" name="coverIndex" wire:model="coverIndex" value="{{ $index }}"
                            width="40%" />
                    </label>
                </div>
                <button type="button" class="btn btn-danger" wire:click="removeFile({{ $index }})"><span
                        class="bx bx-trash"></span></button>
            </div>
        </div>
    @endforeach
</div>
