@extends('admin.layouts.main')


@section('container')
    <div>

        @livewire('facility-form', ['sub_title' => $sub_title, 'facilityId' => $facilityId ?? null, 'showMode' => $showMode ?? null])

    </div>
@endsection
