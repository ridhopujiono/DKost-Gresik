@extends('admin.layouts.main')
@section('container')
    @livewire('late-notification-table', ['sub_title' => $sub_title])
@endsection
