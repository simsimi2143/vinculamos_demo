@extends('admin.panel')

@section('contenido')
    <section style="display: flex; justify-content: center; align-items: center;margin-top:-3%;">
        <div >
            <a class="btn">                             {{-- Imagen de fondo en home --}}
                <img alt="image" src={{-- "{{ asset('public/img/fondo_home_aiep.png') }}" --}} width="100%">
            </a>
        </div>
        <span class="logo-name" style="font-size: 12px;" id="toastr-2">
        </span>

    </section>

    <script src="{{ asset('public/bundles/izitoast/js/iziToast.min.js') }}"></script>
    <script src="{{ asset('public/js/page/toastr.js') }}"></script>
@endsection
