<div>
    @livewireStyles
    @include('admin.layouts.toast_flash_message')
    <!-- /Logo -->
    <h4 class="mb-2">Login</h4>

    <form id="formAuthentication" class="mb-3" wire:submit.prevent='authenticate'">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                wire:model='email' placeholder="Masukan email anda" autofocus @error('email') is-invalid @enderror />
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3 form-password-toggle">
            <div class="d-flex justify-content-between">
                <label class="form-label" for="password">Kata sandi</label>
            </div>
            <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control  @error('password') is-invalid @enderror"
                    name="password" wire:model='password' placeholder="" aria-describedby="password" />
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="mb-3">
            <button class="btn btn-primary d-grid w-100" wire:loading.attr='disabled' type="submit">Login</button>
        </div>
    </form>
    @livewireScripts
</div>
