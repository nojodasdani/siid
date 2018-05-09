@extends('layouts.app')
@section('content')
    <div class="container">
        @if (Session::has('message'))
            <div class="alert alert-success">{{ Session::get('message') }}</div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Cambio de contraseña</div>
                    <div class="panel-body">
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <form class="form-horizontal" method="POST" action="{{ route('changePassword') }}">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                                <label for="new-password" class="col-md-4 control-label">Contraseña actual</label>
                                <div class="col-md-6">
                                    <input id="current-password" type="password" class="form-control"
                                           name="current-password" required placeholder="Contraseña actual">
                                    @if ($errors->has('current-password'))
                                        <span class="help-block">
<strong>{{ $errors->first('current-password') }}</strong>
</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('new-password') ? ' has-error' : '' }}">
                                <label for="new-password" class="col-md-4 control-label">Nueva contraseña</label>
                                <div class="col-md-6">
                                    <input id="new-password" type="password" class="form-control" name="new-password"
                                           placeholder="Nueva contraseña" required>
                                    @if ($errors->has('new-password'))
                                        <span class="help-block">
<strong>{{ $errors->first('new-password') }}</strong>
</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="new-password-confirm" class="col-md-4 control-label">Confirmar nueva
                                    contraseña
                                </label>
                                <div class="col-md-6">
                                    <input id="new-password-confirm" type="password" class="form-control"
                                           name="new-password_confirmation" required placeholder="Repetir contraseña">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Cambiar contraseña
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