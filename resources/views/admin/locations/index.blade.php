@extends('admin.layouts.main')


@section('container')
    <div>
        
        @livewire('location-table', ['sub_title' => $sub_title])

    </div>
@endsection
