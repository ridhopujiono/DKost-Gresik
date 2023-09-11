@extends('admin.layouts.main')


@section('container')
    <div>

        @livewire('guest-waiting-list-table', ['sub_title' => $sub_title])

    </div>
@endsection
