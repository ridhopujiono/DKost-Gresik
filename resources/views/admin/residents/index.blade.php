@extends('admin.layouts.main')


@section('container')
    <div>
        
        @livewire('resident-table', ['sub_title' => $sub_title])

    </div>
@endsection
