@extends('admin.layouts.main')


@section('container')
    <div>

        @livewire('payment-table', ['sub_title' => $sub_title])

    </div>
@endsection
