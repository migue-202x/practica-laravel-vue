@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Administrar notas') }}</div>
                <div class="card-body">
                    {{-- Aca voy a utilizar un componente --}}
                    <tareas />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
