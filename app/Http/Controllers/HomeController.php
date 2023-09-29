<?php

namespace App\Http\Controllers;
use App\Models\Grupos;
use App\Models\IniciativasComunas;
use App\Models\IniciativasEvidencias;
use App\Models\IniciativasGrupos;
use App\Models\IniciativasPais;
use App\Models\IniciativasParticipantes;
use App\Models\IniciativasRegiones;
use App\Models\IniciativasTematicas;
use App\Models\ParticipantesInternos;
use App\Models\SedesSocios;
use App\Models\SociosComunitarios;
use App\Models\SubGruposInteres;
use App\Models\Tematicas;
use App\Models\TipoActividades;
use App\Models\Escuelas;
use App\Models\Iniciativas;
use App\Models\Mecanismos;
use App\Models\MecanismosActividades;
use App\Models\Pais;
use App\Models\Sedes;
use App\Models\Convenios;
use App\Models\SedesEscuelas;
use App\Models\Region;
use App\Models\Ambitos;
use App\Models\Carreras;
use App\Models\Comuna;
use App\Models\GruposInteres;
use App\Models\Regiones;
use App\Models\Programas;
use App\Models\SedesProgramas;
use App\Models\TipoIniciativa;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Usuarios;

class HomeController extends Controller
{
    public function vistaHome() {
        $sedes = Sedes::select('sede_codigo', 'sede_nombre')->orderBy('sede_nombre', 'asc')->get();
        $escuelas = Escuelas::select('escu_codigo', 'escu_nombre')->orderBy('escu_nombre', 'asc')->get();
        $nIniciativas = Iniciativas::all();
        $nEstudiantes = ParticipantesInternos::select(DB::raw('SUM(COALESCE(pain_estudiantes_final,0)) as estudiantes'))->get();
        $nDocentes = ParticipantesInternos::select(DB::raw('SUM(COALESCE(pain_docentes_final,0)) as docentes'))->get();
        // $nValor = $nEstudiantes[0]->estudiantes - $nDocentes[0]->docentes;
        $nSocios = SociosComunitarios::all();
        $nTitulados = IniciativasParticipantes::select(DB::raw('SUM(COALESCE(inpr_total_final,0)) as titulados'))->where('soco_codigo',15)->get();
        // return $nTitulados;
        $nBeneficiarios = IniciativasParticipantes::select(DB::raw('SUM(COALESCE(inpr_total_final,0)) as beneficiarios'))->get();
        $comunas = Comuna::all();

        $programa1_m = Programas::select(['prog_meta_estudiantes', 'prog_meta_docentes', 'prog_meta_socios', 'prog_meta_beneficiarios'])
        ->where('prog_codigo', 1)->get();

        $programa1_avance =  DB::table('iniciativas_participantes')
                            ->select([
                                'iniciativas_participantes.inpr_codigo',
                                'iniciativas_participantes.inic_codigo',
                                DB::raw('SUM(COALESCE(participantes_internos.pain_docentes, 0)) as total_docentes'),
                                DB::raw('SUM(COALESCE(participantes_internos.pain_estudiantes, 0)) as total_estudiantes'),
                                DB::raw('(SELECT SUM(iniciativas_participantes.inpr_total) FROM iniciativas_participantes JOIN iniciativas ON iniciativas_participantes.inic_codigo = iniciativas.inic_codigo WHERE iniciativas.meca_codigo = 1 GROUP BY iniciativas_participantes.inpr_codigo) as total_beneficiarios'),
                                DB::raw('COUNT(DISTINCT iniciativas_participantes.soco_codigo) as total_socios')
                            ])
                            ->join('iniciativas', 'iniciativas_participantes.inic_codigo', '=', 'iniciativas.inic_codigo')
                            ->join('participantes_internos', 'iniciativas.inic_codigo', '=', 'participantes_internos.inic_codigo')
                            ->where('iniciativas.meca_codigo', 1)
                            ->groupBy('iniciativas_participantes.inpr_codigo', 'iniciativas_participantes.inic_codigo')
                            ->get();

        $programa2_m = Programas::select(['prog_meta_estudiantes', 'prog_meta_docentes', 'prog_meta_socios', 'prog_meta_beneficiarios'])
        ->where('prog_codigo', 3)->get();

        $programa2_avance =  DB::table('iniciativas_participantes')
                            ->select([
                                'iniciativas_participantes.inpr_codigo',
                                'iniciativas_participantes.inic_codigo',
                                DB::raw('SUM(COALESCE(participantes_internos.pain_docentes, 0)) as total_docentes'),
                                DB::raw('SUM(COALESCE(participantes_internos.pain_estudiantes, 0)) as total_estudiantes'),
                                DB::raw('(SELECT SUM(iniciativas_participantes.inpr_total) FROM iniciativas_participantes JOIN iniciativas ON iniciativas_participantes.inic_codigo = iniciativas.inic_codigo WHERE iniciativas.meca_codigo = 1 GROUP BY iniciativas_participantes.inpr_codigo) as total_beneficiarios'),
                                DB::raw('COUNT(DISTINCT iniciativas_participantes.soco_codigo) as total_socios')
                            ])
                            ->join('iniciativas', 'iniciativas_participantes.inic_codigo', '=', 'iniciativas.inic_codigo')
                            ->join('participantes_internos', 'iniciativas.inic_codigo', '=', 'participantes_internos.inic_codigo')
                            ->where('iniciativas.meca_codigo', 3)
                            ->groupBy('iniciativas_participantes.inpr_codigo', 'iniciativas_participantes.inic_codigo')
                            ->get();

        $programa3_m = Programas::select(['prog_meta_estudiantes', 'prog_meta_docentes', 'prog_meta_socios', 'prog_meta_beneficiarios'])
        ->where('prog_codigo', 4)->get();

        $programa3_avance =  DB::table('iniciativas_participantes')
                            ->select([
                                'iniciativas_participantes.inpr_codigo',
                                'iniciativas_participantes.inic_codigo',
                                DB::raw('SUM(COALESCE(participantes_internos.pain_docentes, 0)) as total_docentes'),
                                DB::raw('SUM(COALESCE(participantes_internos.pain_estudiantes, 0)) as total_estudiantes'),
                                DB::raw('(SELECT SUM(iniciativas_participantes.inpr_total) FROM iniciativas_participantes JOIN iniciativas ON iniciativas_participantes.inic_codigo = iniciativas.inic_codigo WHERE iniciativas.meca_codigo = 1 GROUP BY iniciativas_participantes.inpr_codigo) as total_beneficiarios'),
                                DB::raw('COUNT(DISTINCT iniciativas_participantes.soco_codigo) as total_socios')
                            ])
                            ->join('iniciativas', 'iniciativas_participantes.inic_codigo', '=', 'iniciativas.inic_codigo')
                            ->join('participantes_internos', 'iniciativas.inic_codigo', '=', 'participantes_internos.inic_codigo')
                            ->where('iniciativas.meca_codigo', 2)
                            ->groupBy('iniciativas_participantes.inpr_codigo', 'iniciativas_participantes.inic_codigo')
                            ->get();

        $programa4_m = Programas::select(['prog_meta_estudiantes', 'prog_meta_docentes', 'prog_meta_socios', 'prog_meta_beneficiarios'])
        ->where('prog_codigo', 2)->get();

        $programa4_avance =  DB::table('iniciativas_participantes')
                            ->select([
                                'iniciativas_participantes.inpr_codigo',
                                'iniciativas_participantes.inic_codigo',
                                DB::raw('SUM(COALESCE(participantes_internos.pain_docentes, 0)) as total_docentes'),
                                DB::raw('SUM(COALESCE(participantes_internos.pain_estudiantes, 0)) as total_estudiantes'),
                                DB::raw('(SELECT SUM(iniciativas_participantes.inpr_total) FROM iniciativas_participantes JOIN iniciativas ON iniciativas_participantes.inic_codigo = iniciativas.inic_codigo WHERE iniciativas.meca_codigo = 1 GROUP BY iniciativas_participantes.inpr_codigo) as total_beneficiarios'),
                                DB::raw('COUNT(DISTINCT iniciativas_participantes.soco_codigo) as total_socios')
                            ])
                            ->join('iniciativas', 'iniciativas_participantes.inic_codigo', '=', 'iniciativas.inic_codigo')
                            ->join('participantes_internos', 'iniciativas.inic_codigo', '=', 'participantes_internos.inic_codigo')
                            ->where('iniciativas.meca_codigo', 4)
                            ->groupBy('iniciativas_participantes.inpr_codigo', 'iniciativas_participantes.inic_codigo')
                            ->get();

        $metas_total = Sedes::select(
            DB::raw('SUM(COALESCE(sede_meta_estudiantes,0)) as meta_sede_estudiantes'),
            DB::raw('SUM(COALESCE(sede_meta_docentes,0)) as meta_sede_docentes'))
            ->get();

        return view('admin.home', compact('sedes','escuelas','comunas','nIniciativas','nEstudiantes',
        'nDocentes','nSocios','nBeneficiarios','nTitulados','programa1_m','programa2_m','programa3_m',
        'programa4_m','metas_total','programa1_avance','programa2_avance','programa3_avance','programa4_avance'));
    }

    public function coberturaSede(Request $request)
    {
        // Obtén el valor de 'select_sede' desde la solicitud
        $sedeCodigo = $request->input('select_sede');

        if ($sedeCodigo == 'all') {
            $cobertura_x_sedes = ParticipantesInternos::select(
            DB::raw('SUM(COALESCE(pain_docentes,0)) as total_docentes'),
            DB::raw('SUM(COALESCE(pain_estudiantes,0)) as total_estudiantes'))
            ->get();

            $metas_x_sede = Sedes::select(
                DB::raw('SUM(COALESCE(sede_meta_estudiantes,0)) as meta_sede_docentes'),
                DB::raw('SUM(COALESCE(sede_meta_docentes,0)) as meta_sede_estudiantes'))
                ->get();

            $programa1 = DB::table('iniciativas_participantes')
            ->select([
                'iniciativas_participantes.inpr_codigo',
                'iniciativas_participantes.inic_codigo',

                DB::raw('SUM(COALESCE(participantes_internos.pain_docentes, 0)) as total_docentes'),

                DB::raw('SUM(COALESCE(participantes_internos.pain_docentes_final, 0)) as total_docentes_final'),

                DB::raw('SUM(COALESCE(participantes_internos.pain_estudiantes, 0)) as total_estudiantes'),

                DB::raw('SUM(COALESCE(participantes_internos.pain_estudiantes_final, 0)) as total_estudiantes_final'),

                DB::raw('(SELECT SUM(iniciativas_participantes.inpr_total) FROM iniciativas_participantes JOIN iniciativas ON iniciativas_participantes.inic_codigo = iniciativas.inic_codigo WHERE iniciativas.meca_codigo = 1 GROUP BY iniciativas_participantes.inpr_codigo) as total_beneficiarios'),

                DB::raw('COUNT(DISTINCT iniciativas_participantes.soco_codigo) as total_socios')
            ])

            ->join('iniciativas', 'iniciativas_participantes.inic_codigo', '=', 'iniciativas.inic_codigo')
            ->join('participantes_internos', 'iniciativas.inic_codigo', '=', 'participantes_internos.inic_codigo')

            ->where('iniciativas.meca_codigo', 1)


            ->groupBy('iniciativas_participantes.inpr_codigo', 'iniciativas_participantes.inic_codigo')
            ->get();

            $programa2 = DB::table('iniciativas_participantes')
            ->select([
                'iniciativas_participantes.inpr_codigo',
                'iniciativas_participantes.inic_codigo',

                DB::raw('SUM(COALESCE(participantes_internos.pain_docentes, 0)) as total_docentes'),

                DB::raw('SUM(COALESCE(participantes_internos.pain_docentes_final, 0)) as total_docentes_final'),

                DB::raw('SUM(COALESCE(participantes_internos.pain_estudiantes, 0)) as total_estudiantes'),

                DB::raw('SUM(COALESCE(participantes_internos.pain_estudiantes_final, 0)) as total_estudiantes_final'),

                DB::raw('(SELECT SUM(iniciativas_participantes.inpr_total) FROM iniciativas_participantes JOIN iniciativas ON iniciativas_participantes.inic_codigo = iniciativas.inic_codigo WHERE iniciativas.meca_codigo = 1 GROUP BY iniciativas_participantes.inpr_codigo) as total_beneficiarios'),

                DB::raw('COUNT(DISTINCT iniciativas_participantes.soco_codigo) as total_socios')
            ])

            ->join('iniciativas', 'iniciativas_participantes.inic_codigo', '=', 'iniciativas.inic_codigo')
            ->join('participantes_internos', 'iniciativas.inic_codigo', '=', 'participantes_internos.inic_codigo')

            ->where('iniciativas.meca_codigo', 3)


            ->groupBy('iniciativas_participantes.inpr_codigo', 'iniciativas_participantes.inic_codigo')
            ->get();

            $programa3 = DB::table('iniciativas_participantes')
            ->select([
                'iniciativas_participantes.inpr_codigo',
                'iniciativas_participantes.inic_codigo',

                DB::raw('SUM(COALESCE(participantes_internos.pain_docentes, 0)) as total_docentes'),

                DB::raw('SUM(COALESCE(participantes_internos.pain_docentes_final, 0)) as total_docentes_final'),

                DB::raw('SUM(COALESCE(participantes_internos.pain_estudiantes, 0)) as total_estudiantes'),

                DB::raw('SUM(COALESCE(participantes_internos.pain_estudiantes_final, 0)) as total_estudiantes_final'),

                DB::raw('(SELECT SUM(iniciativas_participantes.inpr_total) FROM iniciativas_participantes JOIN iniciativas ON iniciativas_participantes.inic_codigo = iniciativas.inic_codigo WHERE iniciativas.meca_codigo = 1 GROUP BY iniciativas_participantes.inpr_codigo) as total_beneficiarios'),

                DB::raw('COUNT(DISTINCT iniciativas_participantes.soco_codigo) as total_socios')
            ])

            ->join('iniciativas', 'iniciativas_participantes.inic_codigo', '=', 'iniciativas.inic_codigo')
            ->join('participantes_internos', 'iniciativas.inic_codigo', '=', 'participantes_internos.inic_codigo')

            ->where('iniciativas.meca_codigo', 2)


            ->groupBy('iniciativas_participantes.inpr_codigo', 'iniciativas_participantes.inic_codigo')
            ->get();

            $programa4 = DB::table('iniciativas_participantes')
            ->select([
                'iniciativas_participantes.inpr_codigo',
                'iniciativas_participantes.inic_codigo',

                DB::raw('SUM(COALESCE(participantes_internos.pain_docentes, 0)) as total_docentes'),

                DB::raw('SUM(COALESCE(participantes_internos.pain_docentes_final, 0)) as total_docentes_final'),

                DB::raw('SUM(COALESCE(participantes_internos.pain_estudiantes, 0)) as total_estudiantes'),

                DB::raw('SUM(COALESCE(participantes_internos.pain_estudiantes_final, 0)) as total_estudiantes_final'),

                DB::raw('(SELECT SUM(iniciativas_participantes.inpr_total) FROM iniciativas_participantes JOIN iniciativas ON iniciativas_participantes.inic_codigo = iniciativas.inic_codigo WHERE iniciativas.meca_codigo = 1 GROUP BY iniciativas_participantes.inpr_codigo) as total_beneficiarios'),

                DB::raw('COUNT(DISTINCT iniciativas_participantes.soco_codigo) as total_socios')
            ])

            ->join('iniciativas', 'iniciativas_participantes.inic_codigo', '=', 'iniciativas.inic_codigo')
            ->join('participantes_internos', 'iniciativas.inic_codigo', '=', 'participantes_internos.inic_codigo')

            ->where('iniciativas.meca_codigo', 4)

            ->groupBy('iniciativas_participantes.inpr_codigo', 'iniciativas_participantes.inic_codigo')
            ->get();


        } else {
            // Realiza la consulta utilizando el valor de $sedeCodigo
            $cobertura_x_sedes = ParticipantesInternos::select('sede_codigo',
                DB::raw('SUM(COALESCE(pain_docentes,0)) as total_docentes'),
                DB::raw('SUM(COALESCE(pain_estudiantes,0)) as total_estudiantes'))
                ->where('sede_codigo', $sedeCodigo)
                ->groupBy('sede_codigo')
                ->get();

            $metas_x_sede = Sedes::select(['sede_meta_estudiantes','sede_meta_docentes'])
                ->where('sede_codigo', $sedeCodigo)
                ->get();

            $programa1 = DB::table('iniciativas_participantes')
            ->join('iniciativas', 'iniciativas_participantes.inic_codigo', '=', 'iniciativas.inic_codigo')
            ->join('participantes_internos', 'iniciativas.inic_codigo', '=', 'participantes_internos.inic_codigo')
            ->select([
                'iniciativas_participantes.inpr_codigo',
                DB::raw('SUM(COALESCE(participantes_internos.pain_docentes, 0)) as total_docentes'),
                DB::raw('SUM(COALESCE(participantes_internos.pain_docentes_final, 0)) as total_docentes_final'),
                DB::raw('SUM(COALESCE(participantes_internos.pain_estudiantes, 0)) as total_estudiantes'),
                DB::raw('SUM(COALESCE(participantes_internos.pain_estudiantes_final, 0)) as total_estudiantes_final'),
                DB::raw('SUM(COALESCE(iniciativas_participantes.inpr_total, 0)) as total_beneficiarios'),
                DB::raw('COUNT(DISTINCT iniciativas_participantes.soco_codigo) as total_socios')
            ])
            ->where('iniciativas.meca_codigo', 1)
            ->where('participantes_internos.sede_codigo', $sedeCodigo)
            ->groupBy('iniciativas_participantes.inpr_codigo')
            ->get();

            $programa2 = DB::table('iniciativas_participantes')
            ->join('iniciativas', 'iniciativas_participantes.inic_codigo', '=', 'iniciativas.inic_codigo')
            ->join('participantes_internos', 'iniciativas.inic_codigo', '=', 'participantes_internos.inic_codigo')
            ->select([
                'iniciativas_participantes.inpr_codigo',
                DB::raw('SUM(COALESCE(participantes_internos.pain_docentes, 0)) as total_docentes'),
                DB::raw('SUM(COALESCE(participantes_internos.pain_docentes_final, 0)) as total_docentes_final'),
                DB::raw('SUM(COALESCE(participantes_internos.pain_estudiantes, 0)) as total_estudiantes'),
                DB::raw('SUM(COALESCE(participantes_internos.pain_estudiantes_final, 0)) as total_estudiantes_final'),
                DB::raw('SUM(COALESCE(iniciativas_participantes.inpr_total, 0)) as total_beneficiarios'),
                DB::raw('COUNT(DISTINCT iniciativas_participantes.soco_codigo) as total_socios')
            ])
            ->where('iniciativas.meca_codigo', 3)
            ->where('participantes_internos.sede_codigo', $sedeCodigo)
            ->groupBy('iniciativas_participantes.inpr_codigo')
            ->get();

            $programa3 = DB::table('iniciativas_participantes')
            ->join('iniciativas', 'iniciativas_participantes.inic_codigo', '=', 'iniciativas.inic_codigo')
            ->join('participantes_internos', 'iniciativas.inic_codigo', '=', 'participantes_internos.inic_codigo')
            ->select([
                'iniciativas_participantes.inpr_codigo',
                DB::raw('SUM(COALESCE(participantes_internos.pain_docentes, 0)) as total_docentes'),
                DB::raw('SUM(COALESCE(participantes_internos.pain_docentes_final, 0)) as total_docentes_final'),
                DB::raw('SUM(COALESCE(participantes_internos.pain_estudiantes, 0)) as total_estudiantes'),
                DB::raw('SUM(COALESCE(participantes_internos.pain_estudiantes_final, 0)) as total_estudiantes_final'),
                DB::raw('SUM(COALESCE(iniciativas_participantes.inpr_total, 0)) as total_beneficiarios'),
                DB::raw('COUNT(DISTINCT iniciativas_participantes.soco_codigo) as total_socios')
            ])
            ->where('iniciativas.meca_codigo', 2)
            ->where('participantes_internos.sede_codigo', $sedeCodigo)
            ->groupBy('iniciativas_participantes.inpr_codigo')
            ->get();

            $programa4 = DB::table('iniciativas_participantes')
            ->join('iniciativas', 'iniciativas_participantes.inic_codigo', '=', 'iniciativas.inic_codigo')
            ->join('participantes_internos', 'iniciativas.inic_codigo', '=', 'participantes_internos.inic_codigo')
            ->select([
                'iniciativas_participantes.inpr_codigo',
                DB::raw('SUM(COALESCE(participantes_internos.pain_docentes, 0)) as total_docentes'),
                DB::raw('SUM(COALESCE(participantes_internos.pain_docentes_final, 0)) as total_docentes_final'),
                DB::raw('SUM(COALESCE(participantes_internos.pain_estudiantes, 0)) as total_estudiantes'),
                DB::raw('SUM(COALESCE(participantes_internos.pain_estudiantes_final, 0)) as total_estudiantes_final'),
                DB::raw('SUM(COALESCE(iniciativas_participantes.inpr_total, 0)) as total_beneficiarios'),
                DB::raw('SUM(COALESCE(iniciativas_participantes.inpr_total_final, 0)) as total_beneficiarios_final'),
                DB::raw('COUNT(DISTINCT iniciativas_participantes.soco_codigo) as total_socios')
            ])
            ->where('iniciativas.meca_codigo', 4)
            ->where('participantes_internos.sede_codigo', $sedeCodigo)
            ->groupBy('iniciativas_participantes.inpr_codigo')
            ->get();
        }

        $respuesta = [
            'cobertura_x_sedes' => $cobertura_x_sedes,
            'metas_x_sede' => $metas_x_sede,
            'programa1' => $programa1,
            'programa2' => $programa2,
            'programa3' => $programa3,
            'programa4' => $programa4,
        ];

        return response()->json($respuesta);
    }

    public function coberturaEscuela(Request $request)
    {
        // Obtén el valor de 'select_sede' desde la solicitud
        $escuelaCodigo = $request->input('select_escuela');
        if ($escuelaCodigo == 'all') {
            $cobertura_x_escuela = ParticipantesInternos::select(
            DB::raw('SUM(COALESCE(pain_docentes,0)) as total_docentes'),
            DB::raw('SUM(COALESCE(pain_estudiantes,0)) as total_estudiantes'))
            ->get();

            //TODO: cosas pasaron aqui
            $programa1 = DB::table('iniciativas_participantes')
            ->select([
                'iniciativas_participantes.inpr_codigo',
                'iniciativas_participantes.inic_codigo',

                DB::raw('SUM(COALESCE(participantes_internos.pain_docentes, 0)) as total_docentes'),

                DB::raw('SUM(COALESCE(participantes_internos.pain_docentes_final, 0)) as total_docentes_final'),

                DB::raw('SUM(COALESCE(participantes_internos.pain_estudiantes, 0)) as total_estudiantes'),

                DB::raw('SUM(COALESCE(participantes_internos.pain_estudiantes_final, 0)) as total_estudiantes_final'),

                DB::raw('(SELECT SUM(iniciativas_participantes.inpr_total) FROM iniciativas_participantes JOIN iniciativas ON iniciativas_participantes.inic_codigo = iniciativas.inic_codigo WHERE iniciativas.meca_codigo = 1 GROUP BY iniciativas_participantes.inpr_codigo) as total_beneficiarios'),

                DB::raw('COUNT(DISTINCT iniciativas_participantes.soco_codigo) as total_socios')
            ])

            ->join('iniciativas', 'iniciativas_participantes.inic_codigo', '=', 'iniciativas.inic_codigo')
            ->join('participantes_internos', 'iniciativas.inic_codigo', '=', 'participantes_internos.inic_codigo')

            ->where('iniciativas.meca_codigo', 1)


            ->groupBy('iniciativas_participantes.inpr_codigo', 'iniciativas_participantes.inic_codigo')
            ->get();

            $programa2 = DB::table('iniciativas_participantes')
            ->select([
                'iniciativas_participantes.inpr_codigo',
                'iniciativas_participantes.inic_codigo',

                DB::raw('SUM(COALESCE(participantes_internos.pain_docentes, 0)) as total_docentes'),

                DB::raw('SUM(COALESCE(participantes_internos.pain_docentes_final, 0)) as total_docentes_final'),

                DB::raw('SUM(COALESCE(participantes_internos.pain_estudiantes, 0)) as total_estudiantes'),

                DB::raw('SUM(COALESCE(participantes_internos.pain_estudiantes_final, 0)) as total_estudiantes_final'),

                DB::raw('(SELECT SUM(iniciativas_participantes.inpr_total) FROM iniciativas_participantes JOIN iniciativas ON iniciativas_participantes.inic_codigo = iniciativas.inic_codigo WHERE iniciativas.meca_codigo = 1 GROUP BY iniciativas_participantes.inpr_codigo) as total_beneficiarios'),

                DB::raw('COUNT(DISTINCT iniciativas_participantes.soco_codigo) as total_socios')
            ])

            ->join('iniciativas', 'iniciativas_participantes.inic_codigo', '=', 'iniciativas.inic_codigo')
            ->join('participantes_internos', 'iniciativas.inic_codigo', '=', 'participantes_internos.inic_codigo')

            ->where('iniciativas.meca_codigo', 3)


            ->groupBy('iniciativas_participantes.inpr_codigo', 'iniciativas_participantes.inic_codigo')
            ->get();

            $programa3 = DB::table('iniciativas_participantes')
            ->select([
                'iniciativas_participantes.inpr_codigo',
                'iniciativas_participantes.inic_codigo',

                DB::raw('SUM(COALESCE(participantes_internos.pain_docentes, 0)) as total_docentes'),

                DB::raw('SUM(COALESCE(participantes_internos.pain_docentes_final, 0)) as total_docentes_final'),

                DB::raw('SUM(COALESCE(participantes_internos.pain_estudiantes, 0)) as total_estudiantes'),

                DB::raw('SUM(COALESCE(participantes_internos.pain_estudiantes_final, 0)) as total_estudiantes_final'),

                DB::raw('(SELECT SUM(iniciativas_participantes.inpr_total) FROM iniciativas_participantes JOIN iniciativas ON iniciativas_participantes.inic_codigo = iniciativas.inic_codigo WHERE iniciativas.meca_codigo = 1 GROUP BY iniciativas_participantes.inpr_codigo) as total_beneficiarios'),

                DB::raw('COUNT(DISTINCT iniciativas_participantes.soco_codigo) as total_socios')
            ])

            ->join('iniciativas', 'iniciativas_participantes.inic_codigo', '=', 'iniciativas.inic_codigo')
            ->join('participantes_internos', 'iniciativas.inic_codigo', '=', 'participantes_internos.inic_codigo')

            ->where('iniciativas.meca_codigo', 2)


            ->groupBy('iniciativas_participantes.inpr_codigo', 'iniciativas_participantes.inic_codigo')
            ->get();

            $programa4 = DB::table('iniciativas_participantes')
            ->select([
                'iniciativas_participantes.inpr_codigo',
                'iniciativas_participantes.inic_codigo',

                DB::raw('SUM(COALESCE(participantes_internos.pain_docentes, 0)) as total_docentes'),

                DB::raw('SUM(COALESCE(participantes_internos.pain_docentes_final, 0)) as total_docentes_final'),

                DB::raw('SUM(COALESCE(participantes_internos.pain_estudiantes, 0)) as total_estudiantes'),

                DB::raw('SUM(COALESCE(participantes_internos.pain_estudiantes_final, 0)) as total_estudiantes_final'),

                DB::raw('(SELECT SUM(iniciativas_participantes.inpr_total) FROM iniciativas_participantes JOIN iniciativas ON iniciativas_participantes.inic_codigo = iniciativas.inic_codigo WHERE iniciativas.meca_codigo = 1 GROUP BY iniciativas_participantes.inpr_codigo) as total_beneficiarios'),

                DB::raw('COUNT(DISTINCT iniciativas_participantes.soco_codigo) as total_socios')
            ])

            ->join('iniciativas', 'iniciativas_participantes.inic_codigo', '=', 'iniciativas.inic_codigo')
            ->join('participantes_internos', 'iniciativas.inic_codigo', '=', 'participantes_internos.inic_codigo')

            ->where('iniciativas.meca_codigo', 4)


            ->groupBy('iniciativas_participantes.inpr_codigo', 'iniciativas_participantes.inic_codigo')
            ->get();




        } else {
            $cobertura_x_escuela = ParticipantesInternos::select('escu_codigo',
            DB::raw('SUM(COALESCE(pain_docentes,0)) as total_docentes'),
            DB::raw('SUM(COALESCE(pain_estudiantes,0)) as total_estudiantes'))
            ->where('escu_codigo', $escuelaCodigo)
            ->groupBy('escu_codigo')
            ->get();

            $programa1 = DB::table('iniciativas_participantes')
            ->select([
                'iniciativas_participantes.inpr_codigo',
                'iniciativas_participantes.inic_codigo',

                DB::raw('SUM(COALESCE(participantes_internos.pain_docentes, 0)) as total_docentes'),

                DB::raw('SUM(COALESCE(participantes_internos.pain_docentes_final, 0)) as total_docentes_final'),

                DB::raw('SUM(COALESCE(participantes_internos.pain_estudiantes, 0)) as total_estudiantes'),

                DB::raw('SUM(COALESCE(participantes_internos.pain_estudiantes_final, 0)) as total_estudiantes_final'),

                DB::raw('(SELECT SUM(iniciativas_participantes.inpr_total) FROM iniciativas_participantes JOIN iniciativas ON iniciativas_participantes.inic_codigo = iniciativas.inic_codigo WHERE iniciativas.meca_codigo = 1 GROUP BY iniciativas_participantes.inpr_codigo) as total_beneficiarios'),

                DB::raw('COUNT(DISTINCT iniciativas_participantes.soco_codigo) as total_socios')
            ])

            ->join('iniciativas', 'iniciativas_participantes.inic_codigo', '=', 'iniciativas.inic_codigo')
            ->join('participantes_internos', 'iniciativas.inic_codigo', '=', 'participantes_internos.inic_codigo')

            ->where('iniciativas.meca_codigo', 1)
            ->where('participantes_internos.escu_codigo', $escuelaCodigo)
            // ->where('participantes_internos.sede_codigo', $sedeCodigo)

            ->groupBy('iniciativas_participantes.inpr_codigo', 'iniciativas_participantes.inic_codigo')
            ->get();

            $programa2 = DB::table('iniciativas_participantes')
            ->select([
                'iniciativas_participantes.inpr_codigo',
                'iniciativas_participantes.inic_codigo',

                DB::raw('SUM(COALESCE(participantes_internos.pain_docentes, 0)) as total_docentes'),

                DB::raw('SUM(COALESCE(participantes_internos.pain_docentes_final, 0)) as total_docentes_final'),

                DB::raw('SUM(COALESCE(participantes_internos.pain_estudiantes, 0)) as total_estudiantes'),

                DB::raw('SUM(COALESCE(participantes_internos.pain_estudiantes_final, 0)) as total_estudiantes_final'),

                DB::raw('(SELECT SUM(iniciativas_participantes.inpr_total) FROM iniciativas_participantes JOIN iniciativas ON iniciativas_participantes.inic_codigo = iniciativas.inic_codigo WHERE iniciativas.meca_codigo = 1 GROUP BY iniciativas_participantes.inpr_codigo) as total_beneficiarios'),

                DB::raw('COUNT(DISTINCT iniciativas_participantes.soco_codigo) as total_socios')
            ])

            ->join('iniciativas', 'iniciativas_participantes.inic_codigo', '=', 'iniciativas.inic_codigo')
            ->join('participantes_internos', 'iniciativas.inic_codigo', '=', 'participantes_internos.inic_codigo')

            ->where('iniciativas.meca_codigo', 3)
            ->where('participantes_internos.escu_codigo', $escuelaCodigo)
            // ->where('participantes_internos.sede_codigo', $sedeCodigo)

            ->groupBy('iniciativas_participantes.inpr_codigo', 'iniciativas_participantes.inic_codigo')
            ->get();

            $programa3 = DB::table('iniciativas_participantes')
            ->select([
                'iniciativas_participantes.inpr_codigo',
                'iniciativas_participantes.inic_codigo',

                DB::raw('SUM(COALESCE(participantes_internos.pain_docentes, 0)) as total_docentes'),

                DB::raw('SUM(COALESCE(participantes_internos.pain_docentes_final, 0)) as total_docentes_final'),

                DB::raw('SUM(COALESCE(participantes_internos.pain_estudiantes, 0)) as total_estudiantes'),

                DB::raw('SUM(COALESCE(participantes_internos.pain_estudiantes_final, 0)) as total_estudiantes_final'),

                DB::raw('(SELECT SUM(iniciativas_participantes.inpr_total) FROM iniciativas_participantes JOIN iniciativas ON iniciativas_participantes.inic_codigo = iniciativas.inic_codigo WHERE iniciativas.meca_codigo = 1 GROUP BY iniciativas_participantes.inpr_codigo) as total_beneficiarios'),

                DB::raw('COUNT(DISTINCT iniciativas_participantes.soco_codigo) as total_socios')
            ])

            ->join('iniciativas', 'iniciativas_participantes.inic_codigo', '=', 'iniciativas.inic_codigo')
            ->join('participantes_internos', 'iniciativas.inic_codigo', '=', 'participantes_internos.inic_codigo')

            ->where('iniciativas.meca_codigo', 2)
            ->where('participantes_internos.escu_codigo', $escuelaCodigo)
            // ->where('participantes_internos.sede_codigo', $sedeCodigo)

            ->groupBy('iniciativas_participantes.inpr_codigo', 'iniciativas_participantes.inic_codigo')
            ->get();

            $programa4 = DB::table('iniciativas_participantes')
            ->select([
                'iniciativas_participantes.inpr_codigo',
                'iniciativas_participantes.inic_codigo',

                DB::raw('SUM(COALESCE(participantes_internos.pain_docentes, 0)) as total_docentes'),

                DB::raw('SUM(COALESCE(participantes_internos.pain_docentes_final, 0)) as total_docentes_final'),

                DB::raw('SUM(COALESCE(participantes_internos.pain_estudiantes, 0)) as total_estudiantes'),

                DB::raw('SUM(COALESCE(participantes_internos.pain_estudiantes_final, 0)) as total_estudiantes_final'),

                DB::raw('(SELECT SUM(iniciativas_participantes.inpr_total) FROM iniciativas_participantes JOIN iniciativas ON iniciativas_participantes.inic_codigo = iniciativas.inic_codigo WHERE iniciativas.meca_codigo = 1 GROUP BY iniciativas_participantes.inpr_codigo) as total_beneficiarios'),

                DB::raw('COUNT(DISTINCT iniciativas_participantes.soco_codigo) as total_socios')
            ])

            ->join('iniciativas', 'iniciativas_participantes.inic_codigo', '=', 'iniciativas.inic_codigo')
            ->join('participantes_internos', 'iniciativas.inic_codigo', '=', 'participantes_internos.inic_codigo')

            ->where('iniciativas.meca_codigo', 4)
            ->where('participantes_internos.escu_codigo', $escuelaCodigo)
            // ->where('participantes_internos.sede_codigo', $sedeCodigo)

            ->groupBy('iniciativas_participantes.inpr_codigo', 'iniciativas_participantes.inic_codigo')
            ->get();
        }

        $respuesta = [
            'cobertura_x_escuela' => $cobertura_x_escuela,
            'programa1' => $programa1,
            'programa2' => $programa2,
            'programa3' => $programa3,
            'programa4' => $programa4,
        ];

        return response()->json($respuesta);
    }


    # ---------------------------------
    # COBERTURA TOTAL
    # ---------------------------------
    //
}
