@extends('admin.layouts.main')


@section('container')
    <div>

        @livewire('guest-waiting-list-form', ['sub_title' => $sub_title, 'guestId' => $guestId ?? null, 'showMode' => $showMode ?? null])

    </div>
@endsection
