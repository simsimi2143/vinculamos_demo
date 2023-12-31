@extends('admin.panel')
@section('contenido')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="row"></div>

                    <div class="card">
                        <div class="card-header">
                            <h4>Información de la iniciativa</h4>
                            <div class="card-header-action">
                                <div class="dropdown d-inline">
                                    <button class="btn btn-primary dropdown-toggle" id="dropdownMenuButton2"
                                        data-toggle="dropdown">Iniciativa</button>
                                    <div class="dropdown-menu dropright">

                                        <a href="" class="dropdown-item has-icon"><i
                                                class="fas fa-users"></i>Ingresar cobertura</a>
                                        <a href="" class="dropdown-item has-icon"><i class="fas fa-flag"></i>Ingresar
                                            resultados</a>
                                        <a href="" class="dropdown-item has-icon"><i
                                                class="fas fa-file-signature"></i>Ingresar evaluación</a>
                                    </div>
                                </div>

                                <div class="dropdown d-inline">
                                    <button class="btn btn-primary dropdown-toggle" id="dropdownMenuButton2"
                                        data-toggle="dropdown">Estados</button>
                                    <div class="dropdown-menu dropright">

                                        <a href="" class="dropdown-item has-icon"><i class="fas fa-check"></i>Aprobar
                                            iniciativa</a>
                                        <a href="" class="dropdown-item has-icon"><i
                                                class="fas fa-times"></i>Rechazar Iniciativa</a>
                                    </div>
                                </div>

                                <a href="{{ route('admin.iniciativa.listar') }}" data-toggle="tooltip" data-placemet="top"
                                    type="button" class="btn btn-primary" title="Ir a iniciativas">
                                    <i class="fas fa-backward"></i>
                                </a>

                                <a href="" type="button" data-toggle="tooltip" class="btn btn-primary"
                                    data-placemet="top" title="Adjuntar evidencia">
                                    <i class="fas fa-paperclip"></i>
                                </a>

                                <a href="{{ route('admin.editar.paso1', $iniciativa[0]->inic_codigo) }}" type="button"
                                    data-toggle="tooltip" class="btn btn-warning" data-placemet="top"
                                    title="Editar iniciativa">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <a href="javascript:void(0)" class="btn btn-danger" data-toggle="tooltip"
                                    data-placement="top" title="Eliminar iniciativa"><i class="fas fa-trash"></i></a>
                                {{-- <a href="javascript:void(0)" class="dropdown-item has-icon"
                                    onclick="eliminarIniciativa({{ $iniciativa->inic_codigo }})" data-toggle="tooltip"
                                    data-placement="top" title="Eliminar">Eliminar Iniciativa<i
                                        class="fas fa-trash"></i></a> --}}

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table table-strip table-md">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <strong>Nombre de la iniciativa</strong>
                                                </td>
                                                <td>
                                                    {{ $iniciativa[0]->inic_nombre }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <strong>Año</strong>
                                                </td>
                                                <td>
                                                    {{ $iniciativa[0]->inic_anho }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <strong>Pertinencia</strong>
                                                </td>
                                                <td>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-sm small">
                                                            <thead>
                                                                <th>Local</th>
                                                                <th>Diciplinar</th>
                                                            </thead>
                                                            <tbody>
                                                                <tr style="background-color: inherit;">
                                                                    <td>{{ $iniciativa[0]->inic_pertinencia_local }}
                                                                    </td>

                                                                    <td>{{ $iniciativa[0]->inic_pertinencia_territorial }}
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td><strong>Mecanismo</strong></td>
                                                <td>{{ $iniciativa[0]->meca_nombre }}</td>
                                            </tr>

                                            <tr>
                                                <td><strong>Tipo de actividad</strong></td>
                                                <td>{{ $iniciativa[0]->tiac_nombre }}</td>
                                            </tr>

                                            <tr>
                                                <td><strong>Convenio</strong></td>
                                                <td>{{ $iniciativa[0]->conv_nombre }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Ubicaciones</strong></td>
                                                <td>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-sm small">
                                                            <thead>
                                                                <th>Región</th>
                                                                <th>Comunas</th>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($ubicaciones as $ubicacion)
                                                                    <tr style="background-color: inherit;">
                                                                        <td>{{ $ubicacion->regi_nombre }}</td>
                                                                        <td>{{ $ubicacion->comunas }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>

                                            {{-- <tr> --}}
                                            {{-- Todo: incluir el caso en el que no existan grupos implicados --}}
                                            {{-- <td><strong>Grupos incluidos</strong></td>
                                                <td>
                                                    <ol>
                                                    @foreach ($grupos as $grupo)
                                                    <li>{{$grupo->grup_nombre}}</li>
                                                    @endforeach
                                                    </ol>
                                                </td>
                                            </tr> --}}

                                            <tr>
                                                {{-- Todo: incluir el caso en el que no existan grupos implicados --}}
                                                <td><strong>Grupos y temáticas <br> relacionadas</strong></td>
                                                <td>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-sm small">
                                                            <thead>
                                                                <th>Grupos</th>
                                                                <th>Temáticas</th>
                                                            </thead>
                                                            <tbody>
                                                                <td>
                                                                    <ol>
                                                                        @foreach ($grupos as $grupo)
                                                                            <li>{{ $grupo->grup_nombre }}</li>
                                                                        @endforeach
                                                                    </ol>
                                                                </td>
                                                                <td>
                                                                    <ol>
                                                                        @foreach ($tematicas as $tematica)
                                                                            <li>{{ $tematica->tema_nombre }}</li>
                                                                        @endforeach
                                                                    </ol>
                                                                </td>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td><strong>Participantes externos</strong></td>
                                                <td>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-sm small">
                                                            <thead>
                                                                <th>Grupos</th>
                                                                <th>Subgrupos</th>
                                                                <th>Nombre del socio</th>
                                                                <th>Beneficiarios</th>
                                                            </thead>

                                                            <tbody>
                                                                @foreach ($externos as $externo)
                                                                    <tr>
                                                                        <td>{{ $externo->grin_nombre }}</td>
                                                                        <td>{{ $externo->sugr_nombre }}</td>
                                                                        <td>{{ $externo->soco_nombre_socio }}</td>
                                                                        <td>{{ $externo->inpr_total }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td><strong>Participantes internos</strong></td>
                                                <td>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-sm small">
                                                            <thead>
                                                                <th>Sedes</th>
                                                                <th>Esculas</th>
                                                                <th>Docentes</th>
                                                                <th>Docentes final</th>
                                                                <th>Estudiantes</th>
                                                                <th>Estudiantes final</th>
                                                            </thead>

                                                            <tbody>
                                                                @foreach ($internos as $interno)
                                                                    <tr>
                                                                        <td>{{ $interno->sede_nombre }}</td>
                                                                        <td>{{ $interno->escu_nombre }}</td>
                                                                        <td>
                                                                            @if ($interno->pain_docentes != null)
                                                                                {{ $interno->pain_docentes }}
                                                                            @else
                                                                                No registrado
                                                                            @endif
                                                                        </td>

                                                                        <td>
                                                                            @if ($interno->pain_docentes_final != null)
                                                                                {{ $interno->pain_docentes_final }}
                                                                            @else
                                                                                No registrado
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @if ($interno->pain_estudiantes != null)
                                                                                {{ $interno->pain_estudiantes }}
                                                                            @else
                                                                                No registrado
                                                                            @endif
                                                                        </td>

                                                                        <td>
                                                                            @if ($interno->pain_estudiantes_final != null)
                                                                                {{ $interno->pain_estudiantes_final }}
                                                                            @else
                                                                                No registrado
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
