@extends('admin.layouts.main')


@section('container')
    <div>

        @livewire('resident-form', ['sub_title' => $sub_title, 'residentId' => $residentId ?? null, 'showMode' => $showMode ?? null])

    </div>
@endsection
