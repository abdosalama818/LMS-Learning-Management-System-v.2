@extends('backend.user.master')

@section('content')


@endsection

@push('scripts')
    <!-- Script inclusion -->
    <script src="{{asset('customjs/user/wishlist.js')}}"></script>
    <script src="{{asset('customjs/cart/index.js')}}"></script>
@endpush



