@extends('layout.index')

@section('acceso')
    <ul class="sidebar-menu" style="font-size: 110%;">
    <li class="menu-header">Administrador</li>

        <li class="dropdown">
            <a href="{{route('admin.home')}}" class="nav-link">
                <i data-feather="home" id="saludo"></i><span>Inicio</span></a>
        </li>
        <li class="dropdown">
            <a href="#" class="menu-toggle nav-link has-dropdown"><i
                    data-feather="book-open"></i><span>Iniciativas</span></a>
            <ul class="dropdown-menu">
                <li><a style="font-size: 90%;" class="nav-link" href="{{route('admin.iniciativa.listar')}}">Registro de iniciativas</a></li>
                <li><a style="font-size: 90%;" class="nav-link" href="{{route('admin.inicitiativas.crear.primero')}}">Crear iniciativa</a></li>
            </ul>
        </li>
        <li class="dropdown">
        <a href="javascript:void(0)" class="menu-toggle nav-link has-dropdown"><i data-feather="users"></i><span>Usuarios</span></a>
        <ul class="dropdown-menu">
            <li><a style="font-size: 90%;" class="nav-link" href="{{route("admin.listar.usuarios")}}">Listado de usuarios</a></li>
        </ul>
        <li class="dropdown">
            <a href="#" class="menu-toggle nav-link has-dropdown"><i
                    data-feather="command"></i><span>Parámetros</span></a>
            <ul class="dropdown-menu">
                <li><a style="font-size: 90%;" class="nav-link" href="{{route("admin.listar.sedes")}}">Sedes</a></li>
                <li><a style="font-size: 90%;" class="nav-link" href="{{route("admin.listar.escuelas")}}">Escuelas</a></li>
                <li><a style="font-size: 90%;" class="nav-link" href="{{route("admin.listar.carreras")}}">Carreras</a></li>
                <li><a style="font-size: 90%;" class="nav-link" href="{{route("admin.listar.ambitos")}}">Ambitos de Contribución</a></li>
                <li><a style="font-size: 90%;" class="nav-link" href="{{route("admin.listar.programas")}}">Programas</a></li>
                <li><a style="font-size: 90%;" class="nav-link" href="{{route("admin.listar.convenios")}}">Convenios</a></li>
                <li><a style="font-size: 90%;" class="nav-link" href="{{route("admin.listar.socios")}}">Socios Comunitarios</a></li>
                <li><a style="font-size: 90%;" class="nav-link" href="{{route("admin.listar.mecanismos")}}">Mecanismos</a></li>
                <li><a style="font-size: 90%;" class="nav-link" href="{{route("admin.listar.grupos_int")}}">Grupos de interes</a></li>
                <li><a style="font-size: 90%;" class="nav-link" href="{{route("admin.listar.tipoact")}}">Tipos de actividad</a></li>
                <li><a style="font-size: 90%;" class="nav-link" href="{{route("admin.listar.tematica")}}">Tematicas</a></li>
            </ul>
        </li>
        <li class="dropdown">
            <a href="#" class="menu-toggle nav-link has-dropdown"><i
                    data-feather="star"></i><span>Objetivos</span></a>
            <ul class="dropdown-menu">
                <li><a style="font-size: 90%;" class="nav-link" href="{{route("admin.listar.ods")}}">ODS</a></li>
            </ul>
        </li>
        <li class="dropdown">
            <a href="#" class="menu-toggle nav-link has-dropdown"><i
                    data-feather="bar-chart-2"></i><span>Análisis de datos</span></a>
        </li>
        <li class="dropdown">
            <a href="#" class="menu-toggle nav-link has-dropdown"><i
                    data-feather="arrow-left-circle"></i><span>Extracción de datos</span></a>
        </li>

@endsection

@section('contenido')
