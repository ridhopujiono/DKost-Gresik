@extends('admin.layouts.main')


@section('container')
    <div>

        @livewire('facility-table', ['sub_title' => $sub_title])

    </div>
@endsection
