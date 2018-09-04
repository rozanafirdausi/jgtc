@extends('frontend.layout.base')

@push('main-container-class')
site-main-inner-push
@endpush

@section('content')
    <div class="container">
        <h2 class="text-caps text-center h1 block">Halaman Tidak Ditemukan</h2>

        <p>Silahkan periksa kembali link yang Anda ingin tuju atau kembali ke <a href="{{route('frontend.home')}}">halaman depan</a>.</p>
    </div>
@endsection
