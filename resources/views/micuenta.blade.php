@extends('layouts.app')

@section('content')
    <div class="container">
        @if (Session::has('message'))
            <div class="alert alert-success">{{ Session::get('message') }}</div>
        @endif
        <div class='alert alert-warning'>
            Para cambiar tu correo o tu domicilio, pónte en contacto con un administrador.
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Modifica tu cuenta</div>
                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ route('modify') }}">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Nombre</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name"
                                           value="{{Auth::user()->name}}" required>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">Correo electrónico</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email"
                                           value="{{Auth::user()->email}}" required readonly>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('telefono') ? ' has-error' : '' }}">
                                <label for="telefono" class="col-md-4 control-label">Teléfono de contacto</label>
                                <div class="col-md-6">
                                    <input id="telefono" type="tel" class="form-control" name="telefono"
                                           value="{{Auth::user()->telefono}}" required>
                                </div>
                            </div>
                            <?php
                            use Illuminate\Support\Facades\Auth;
                            $id_calle = Auth::user()->numero->calle->id;
                            $calle = Auth::user()->numero->calle->calle;
                            $id_num = Auth::user()->numero->id;
                            $num = Auth::user()->numero->numero;
                            ?>
                            <div class="form-group">
                                <label for="calle" class="col-md-2 control-label">Calle</label>
                                <div class="col-md-4">
                                    <select id="calle" class="form-control" name="calle" required disabled>
                                        <option value='{{$id_calle}}' selected>{{$calle}}</option>
                                    </select>
                                </div>
                                <label for="num" class="col-md-2 control-label">Número</label>

                                <div class="col-md-3">
                                    <select id="num" class="form-control" name="num" required disabled>
                                        <option value='{{$id_num}}'>{{$num}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-5">
                                    <button type="submit" class="btn btn-primary">
                                        Modificar
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