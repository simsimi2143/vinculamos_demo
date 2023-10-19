@if (Session::has('admin'))
    @php
        $role = 'admin';
    @endphp
@elseif (Session::has('digitador'))
    @php
        $role = 'digitador';
    @endphp
@elseif (Session::has('observador'))
    @php
        $role = 'observador';
    @endphp
@elseif (Session::has('supervisor'))
    @php
        $role = 'supervisor';
    @endphp
@endif
@extends('admin.panel')

@section('contenido')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-3"></div>
                        <div class="col-3">
                            @foreach (['errorResultados', 'exitoExterno', 'exitoInterno'] as $sessionKey)
                                @if (Session::has($sessionKey))
                                    <div
                                        class="alert {{ $sessionKey === 'errorResultados' ? 'alert-danger' : 'alert-success' }} alert-dismissible show fade mb-4 text-center">
                                        <div class="alert-body">
                                            <strong>{{ Session::get($sessionKey) }}</strong>
                                            <button class="close" data-dismiss="alert"><span>&times;</span></button>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <div class="col-3"></div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ $iniciativa->inic_nombre }} - Registro participantes internos</h4>
                            <div class="card-header-action">
                                <div class="dropdown d-inline">
                                    <a href="{{ route('admin.iniciativas.detalles', $iniciativa->inic_codigo) }}"
                                        class="btn btn-icon btn-warning icon-left" data-toggle="tooltip"
                                        data-placement="top" title="Ver detalles de la iniciativa"><i
                                            class="fas fa-eye"></i>Ver detalle</a>

                                    <a href="{{ route('admin.editar.paso1', $iniciativa->inic_codigo) }}"
                                        class="btn btn-icon btn-primary icon-left" data-toggle="tooltip"
                                        data-placement="top" title="Editar iniciativa"><i
                                            class="fas fa-edit"></i>Editar Iniciativa</a>

                                    {{-- <a href="javascript:void(0)" class="btn btn-icon btn-info icon-left"
                                        data-toggle="tooltip" data-placement="top" title="Calcular INVI"
                                        onclick="calcularIndice({{ $iniciativa->inic_codigo }})"><i
                                            class="fas fa-tachometer-alt"></i>INVI</a> --}}

                                    <a href="{{ route('admin.evidencias.listar', $iniciativa->inic_codigo) }}"
                                        class="btn btn-icon btn-success icon-left" data-toggle="tooltip"
                                        data-placement="top" title="Adjuntar evidencia"><i
                                            class="fas fa-paperclip"></i>Evidencias</a>

                                    {{-- <a href="{{ route('admin.cobertura.index', $iniciativa->inic_codigo) }}"
                                        class="btn btn-icon btn-success icon-left" data-toggle="tooltip" data-placement="top"
                                        title="Ingresar cobertura"><i class="fas fa-users"></i>Cobertura</a> --}}

                                    <a href="{{ route('admin.resultados.listado', $iniciativa->inic_codigo) }}"
                                        class="btn btn-icon btn-success icon-left" data-toggle="tooltip"
                                        data-placement="top" title="Ingresar resultado"><i
                                            class="fas fa-flag"></i>Resultado/s</a>

                                    {{-- <a href="{{ route($role . '.evaluar.iniciativa', $iniciativa->inic_codigo) }}"
                                        class="btn btn-icon btn-success icon-left" data-toggle="tooltip"
                                        data-placement="top" title="Evaluar iniciativa"><i
                                            class="fas fa-file-signature"></i>Evaluar</a> --}}

                                    <a href="{{ route('admin.iniciativa.listar') }}"
                                        class="btn btn-primary mr-1 waves-effect icon-left" type="button">
                                        <i class="fas fa-angle-left"></i> Volver a listado
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route($role . '.cobertura.interna.update', $iniciativa->inic_codigo) }}"
                                method="POST">
                                @csrf
                                <div class="row mt-3">
                                    <div class="col-2"></div>
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body p-0">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-md">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Escuela</th>
                                                                <th scope="col">Carrera</th>
                                                                <th scope="col">Docentes inicial</th>
                                                                <th scope="col">Docentes final</th>
                                                                <th scope="col">Estudiantes inicial</th>
                                                                <th scope="col">Estudiantes final</th>
                                                                <th scope="col">Funcionarios/as inicial</th>
                                                                <th scope="col">Funcionarios/as final</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="body-tabla-participantes">
                                                            {{-- {{$resultados}} --}}
                                                            @foreach ($resultados as $resultado)
                                                                <tr>
                                                                    <td>{{ $resultado->escu_nombre }}</td>
                                                                    <td>{{ $resultado->care_nombre }}</td>
                                                                    <td>{{ $resultado->pain_docentes }}</td>
                                                                    <td>
                                                                        <input type="number" class="form-control"
                                                                            id="cantidad-docentes-final-{{ $resultado->pain_codigo }}"
                                                                            name="docentes_final[{{ $resultado->pain_codigo }}]"
                                                                            value="{{ $resultado->pain_docentes_final }}"
                                                                            min="0">
                                                                    </td>
                                                                    <td>{{ $resultado->pain_estudiantes }}</td>
                                                                    <td>
                                                                        <input type="number" class="form-control"
                                                                            id="cantidad-estudiantes-final-{{ $resultado->pain_codigo }}"
                                                                            name="estudiantes_final[{{ $resultado->pain_codigo }}]"
                                                                            value="{{ $resultado->pain_estudiantes_final }}"
                                                                            min="0">
                                                                    </td>
                                                                    <td>{{ $resultado->pain_funcionarios }}</td>
                                                                    <td>
                                                                        <input type="number" class="form-control"
                                                                            id="cantidad-funcionarios-final-{{ $resultado->pain_codigo }}"
                                                                            name="funcionarios_final[{{ $resultado->pain_codigo }}]"
                                                                            value="{{ $resultado->pain_funcionarios_final }}"
                                                                            min="0">
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-md-12 col-lg-12 text-right">
                                                <input type="hidden" id="inic_codigo" name="inic_codigo"
                                                    value="{{ $iniciativa->inic_codigo }}">
                                                <button type="submit" class="btn btn-primary mr-1 waves-effect"><i
                                                        class="fas fa-save"></i> Guardar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ $iniciativa->inic_nombre }} - Registro de participantes externos</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route($role . '.cobertura.externa.update', $iniciativa->inic_codigo) }}"
                                method="post">
                                @csrf
                                <div class="row mt-3">
                                    <div class="col-2"></div>
                                    <div class="col-8">
                                        <div class="card">
                                            <div class="card-body p-0">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-md">

                                                        @if (count($participantes) > 0)
                                                            <thead>
                                                                <tr>
                                                                    <th>Socios/as</th>
                                                                    <th>Subgrupos</th>
                                                                    <th>Beneficiarios/as</th>
                                                                    <th>Beneficiarios/as final</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody>

                                                                @foreach ($participantes as $participante)
                                                                    <tr>
                                                                        <td>{{ $participante->soco_nombre_socio }}</td>
                                                                        <td>{{ $participante->sugr_nombre }}</td>
                                                                        <td>
                                                                            @if ($participante->inpr_total > 0)
                                                                                {{ $participante->inpr_total }}
                                                                            @else
                                                                                No registrado.
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            <input type="number"
                                                                                name="participantes[{{ $participante->inpr_codigo }}]"
                                                                                class="form-control"
                                                                                value="{{ $participante->inpr_total_final }}">
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        @else
                                                            <thead class="text-center">
                                                                <tr>
                                                                    <th>Al parecer no hay registro de participación externa
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                        @endif


                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-12 col-lg-12 text-right">
                                        <input type="hidden" id="inic_codigo" name="inic_codigo"
                                            value="{{ $iniciativa->inic_codigo }}">
                                        <a href="{{ route($role . '.iniciativa.listar') }}"
                                            class="btn btn-primary mr-1 waves-effect" type="button">
                                            <i class="fas fa-angle-left"></i> Volver a listado
                                        </a>
                                        <button type="submit" class="btn btn-primary mr-1 waves-effect"><i
                                                class="fas fa-save"></i> Guardar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="{{ asset('/js/admin/iniciativas/listar.js') }}"></script>
@endsection
