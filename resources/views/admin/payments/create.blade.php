@extends('admin.layouts.main')


@section('container')
    <div>

        @livewire('payment-form', ['sub_title' => $sub_title, 'paymentId' => $paymentId ?? null, 'showMode' => $showMode ?? null])

    </div>
@endsection
