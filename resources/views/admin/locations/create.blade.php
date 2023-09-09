@extends('admin.layouts.main')


@section('container')
    <div>

        @livewire('location-create', ['sub_title' => $sub_title, 'locationId' => $locationId ?? null, 'showMode' => $showMode ?? null])

    </div>
@endsection
