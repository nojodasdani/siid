@extends('layouts.app')

@section('content')
    <div class="container">
        @if (Session::has('message'))
            <div class="alert alert-info">{{ Session::get('message') }}</div>
        @endif
        @if (Session::has('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Registrar un aviso para los colonos</div>
                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ route('crearAviso') }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="texto" class="col-md-4 control-label">Texto</label>
                                <div class="col-md-6">
                                    <textarea rows="5" id="texto" class="form-control" name="texto" placeholder="Contenido del aviso" required></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Crear aviso
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
