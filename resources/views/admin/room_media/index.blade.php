@extends('admin.layouts.main')


@section('container')
    <div>

        @livewire('room-media-table', ['sub_title' => $sub_title])

    </div>
@endsection
