@extends('admin.layouts.main')


@section('container')
    <div>

        @livewire('room-form', ['sub_title' => $sub_title, 'roomId' => $roomId ?? null, 'showMode' => $showMode ?? null])

    </div>
@endsection
