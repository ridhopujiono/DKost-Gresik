@extends('admin.layouts.main')


@section('container')
    <div>

        @livewire('room-media-form', ['sub_title' => $sub_title, 'roomId' => $roomId ?? null, 'showMode' => $showMode ?? null])

    </div>
@endsection
