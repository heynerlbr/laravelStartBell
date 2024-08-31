<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\preoperacionales;
use App\Models\facturas;
use App\Models\sucursales;
use App\Models\ordenes;
use App\Models\equipos;
use App\Models\equipos_multas;
use App\Models\equipos_conductores;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class dasboardController extends Controller
{
    public function index2()
    {
        return view('reportes.index');
    }

    # **********************************************
    # ************ En desarrollo ********
    # **********************************************


    public function graficaBarrasContadorXestado(){
        $Tipouser = Auth::user()->roles->first()->name;
       try {
        if ($Tipouser=='admin' || $Tipouser=='observador' || $Tipouser=='aprobador') {
            $ordenes=DB::table('ordenes')->distinct()            
            ->selectRaw(' count(ordenes.id) as data , ordenes.estado as name ')          
            ->whereRaw('YEAR(ordenes.created_at) = YEAR(CURRENT_DATE())')
            ->groupBy('ordenes.estado')
            ->get();

            $sumaValorTotal=DB::table('repuestos')  
            ->selectRaw(' ROUND(SUM(repuestos.valorTotal),2)  as valor,ordenes.estado')
            ->join('ordenes', 'ordenes.id', '=', 'repuestos.orden_id')
            ->whereRaw('YEAR(ordenes.created_at) = YEAR(CURRENT_DATE())')
            ->groupBy('ordenes.estado')
            ->get();


        }else {
            $ordenes=DB::table('ordenes')->distinct()
            ->selectRaw(' count(ordenes.id) as data , ordenes.estado as name')         
            ->whereRaw('ordenes.id_usuario ='.Auth::user()->id.' and YEAR(ordenes.created_at) = YEAR(CURRENT_DATE())')
            ->groupBy('ordenes.estado')
            ->get();

            $sumaValorTotal=DB::table('repuestos')
            ->selectRaw(' ROUND(SUM(repuestos.valorTotal),2)  as valor,ordenes.estado')
            ->join('ordenes', 'ordenes.id', '=', 'repuestos.orden_id')
            ->whereRaw('ordenes.id_usuario ='.Auth::user()->id.' and YEAR(ordenes.created_at) = YEAR(CURRENT_DATE())')
            ->groupBy('ordenes.estado')
            ->get();

        }
        //  dd($ordenes);
        $arrayEstado=[];
        for ($i=0; $i < count($ordenes) ; $i++) {
            $contendio='';
            $contendio.='name=>'.$ordenes[$i]->name.',';
            $contendio.='data=>['.$ordenes[$i]->data.']';
            $contendio.='';
            if ($ordenes[$i]->name!="" ||  $ordenes[$i]->name!=null ) {
                $contendio=(object)[
                    'name' => $ordenes[$i]->name,
                    'data' => [$ordenes[$i]->data],
                ];
                array_push($arrayEstado, $contendio);
            }
        }
        //fecha
        $year=date('Y');
        $m=date('m');
        
        $d=date('d');

        if ($Tipouser=='admin'  || $Tipouser=='aprobador' || $Tipouser=='observador') {
            $ordenesMeses = DB::table('repuestos')->distinct()
            ->leftJoin('ordenes', 'ordenes.id', '=', 'repuestos.orden_id')
            ->selectRaw('ROUND(SUM(repuestos.valorTotal),2) as data , DATE_FORMAT(ordenes.created_at, "%m" ) as mes ')
            ->where('ordenes.estado','FACTURADO')
            ->orWhere('ordenes.estado','TERMINADO')
            ->whereRaw('YEAR(ordenes.created_at) = YEAR(CURRENT_DATE())')        
            ->groupByRaw('DATE_FORMAT(ordenes.created_at, "%m-%'.$year.'")')
            ->get();

        }else {
            $ordenesMeses = DB::table('repuestos')->distinct()
            ->leftJoin('ordenes', 'ordenes.id', '=', 'repuestos.orden_id')
            ->selectRaw('ROUND(SUM(repuestos.valorTotal),2) as data , DATE_FORMAT(ordenes.created_at, "%m" ) as mes ')
            ->whereRaw('ordenes.id_usuario ='.Auth::user()->id.' and ( ordenes.estado="FACTURADO" or ordenes.estado="TERMINADO")')
            ->whereRaw('YEAR(ordenes.created_at) = YEAR(CURRENT_DATE())')

            ->groupByRaw('DATE_FORMAT(ordenes.created_at, "%m-%'.$year.'")')
            ->get();


        }
        $arrayValorxMes=[];
        $arrayValorxMesPrueba=['0','0','0','0','0','0','0','0','0','0','0','0'];
        $arrayCategorias=[];

        $contendio='';
        for ($i=0; $i < count($ordenesMeses) ; $i++) {
            if ($ordenesMeses[$i]->data!="" ||  $ordenesMeses[$i]->data!=null ) {
            switch ($ordenesMeses[$i]->mes) {
                case '01':
                    $contendio2='Ene';
                    array_push($arrayCategorias, $contendio2);
                    $pos=0;
                break;
                case '02':
                    $contendio2='Feb';
                    array_push($arrayCategorias, $contendio2);
                    $pos=1;
                break;
                case '03':
                    $contendio2='Mar';
                    array_push($arrayCategorias, $contendio2);
                    $pos=2;
                break;
                case '04':
                    $contendio2='Abr';
                    array_push($arrayCategorias, $contendio2);
                    $pos=3;
                break;
                case '05':
                    $contendio2='May';
                    array_push($arrayCategorias, $contendio2);
                    $pos=4;
                break;
                case '06':
                    $contendio2='Junio';
                    array_push($arrayCategorias, $contendio2);

                    $pos=5;
                break;
                case '07':
                    $contendio2='Jul';
                    array_push($arrayCategorias, $contendio2);
                    $pos=6;
                break;
                case '08':
                    $contendio2='Ago';
                    array_push($arrayCategorias, $contendio2);
                    $pos=7;
                break;
                case '09':
                    $contendio2='Sep';
                    array_push($arrayCategorias, $contendio2);
                    $pos=8;
                break;
                case '10':
                    $contendio2='Oct';
                    array_push($arrayCategorias, $contendio2);
                    $pos=9;
                break;
                case '11':
                    $contendio2='Nov';
                    array_push($arrayCategorias, $contendio2);
                    $pos=10;
                break;
                case '12':
                    $contendio2='Dic';
                    array_push($arrayCategorias, $contendio2);
                    $pos=11;
                break;
            }
        }
            if ($ordenesMeses[$i]->data!="" ||  $ordenesMeses[$i]->data!=null ) {
                $valor=$ordenesMeses[$i]->data;
                //  $valor=str_replace(',','.',$valor);
                //  $valor=number_format(floatval($valor), 2, ',', '.');

                $valor=floatval($valor);
                $contendio=(object)[
                    'name' => $contendio2,
                    'data' => [$valor],
                ];
                array_push($arrayValorxMes, $contendio);
                $arrayValorxMesPrueba[$pos]=$valor;

            }
        }

        if ($Tipouser=='admin' || $Tipouser=='observador' || $Tipouser=='aprobador' ) {
            $valorTotal = DB::table('repuestos')->distinct()
            ->leftJoin('ordenes', 'ordenes.id', '=', 'repuestos.orden_id')
            ->selectRaw('ROUND(SUM(repuestos.valorTotal),2) as total')
            ->whereRaw('YEAR(ordenes.created_at) = YEAR(CURRENT_DATE())')
            ->where('ordenes.estado','FACTURADO')
            ->orWhere('ordenes.estado','TERMINADO')
            ->get();
        }else {
            $valorTotal = DB::table('repuestos')->distinct()
            ->leftJoin('ordenes', 'ordenes.id', '=', 'repuestos.orden_id')
            ->selectRaw('ROUND(SUM(repuestos.valorTotal),2) as total')
            ->whereRaw('YEAR(ordenes.created_at) = YEAR(CURRENT_DATE()) and ( ordenes.estado="FACTURADO" or ordenes.estado="TERMINADO")'. ' and ordenes.id_usuario ='.Auth::user()->id.'')
            ->get();
        }


        $arrayValorxDias=['0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'];



        $from = date($year.'-'.$m.'-01');
        $to = date($year.'-'.$m.'-31');
        if ($Tipouser=='admin'  || $Tipouser=='aprobador' || $Tipouser=='observador') {
            $ordenesxDias = DB::table('repuestos')
            ->leftJoin('ordenes', 'ordenes.id', '=', 'repuestos.orden_id')
            ->selectRaw('ROUND(SUM(repuestos.valorTotal),2) as data , DATE_FORMAT(ordenes.created_at, "%d" ) as dia  , DATE_FORMAT(ordenes.created_at, "%d-%m" ) as fecha  , DATE_FORMAT(ordenes.created_at, "%m" ) as mes ')
            ->whereRaw(' ordenes.created_at Between "'.$from.'" and "'.$to .'" and ( ordenes.estado="FACTURADO" or ordenes.estado="TERMINADO") ')
             ->groupByRaw('DATE_FORMAT(ordenes.created_at, "%d-%m")')
            ->get();





         }else {
           
            $ordenesxDias = DB::table('repuestos')
            ->leftJoin('ordenes', 'ordenes.id', '=', 'repuestos.orden_id')
            ->selectRaw('ROUND(SUM(repuestos.valorTotal),2) as data , DATE_FORMAT(ordenes.created_at, "%d" ) as dia  , DATE_FORMAT(ordenes.created_at, "%d-%m" ) as fecha  , DATE_FORMAT(ordenes.created_at, "%m" ) as mes ')
            ->whereRaw(' ordenes.created_at Between "'.$from.'" and "'.$to .'" and ( ordenes.estado="FACTURADO" or ordenes.estado="TERMINADO") and ordenes.id_usuario ='.Auth::user()->id.' ')
             ->groupByRaw('DATE_FORMAT(ordenes.created_at, "%d-%m")')
            ->get();

         }


        //    dd($ordenesxDias);

          for ($i=0; $i < count($ordenesxDias); $i++) { 
            $diaMes=$ordenesxDias[$i]->dia;
            $valor=$ordenesxDias[$i]->data;
            $mes=$ordenesxDias[$i]->mes;
             switch ($diaMes) {
                case '01':
                    $pos=0;
                break;
                 case '02':
                    $pos=1;
                break;
                case '03':
                    $pos=2;
                break;
                case '04':
                    $pos=3;
                break;
                case '05':
                    $pos=4;
                break;
                case '06':
                    $pos=5;
                break;
                case '07':
                    $pos=6;
                break;
                case '08':
                    $pos=7;
                break;
                case '09':
                    $pos=8;
                break;
                case '10':
                    $pos=9;
                break;
                case '11':
                    $pos=10;
                break;
                case '12':
                    $pos=11;
                break;
                case '13':
                    $pos=12;
                break;
                case '14':
                    $pos=13;
                break;
                case '15':
                    $pos=14;
                break;
                case '16':
                    $pos=15;
                break;
                case '17':
                    $pos=16;
                break;
                case '18':
                    $pos=17;
                break;
                case '19':
                    $pos=18;
                break;
                case '20':
                    $pos=19;
                break;
                case '21':
                    $pos=20;
                break;
                case '22':
                    $pos=21;
                break;
                case '23':
                    $pos=22;
                break;
                case '24':
                    $pos=23;
                break;
                case '25':
                    $pos=24;
                break;
                case '26':
                    $pos=25;
                break;
                case '27':
                    $pos=26;
                break;
                case '28':
                    $pos=27;
                break;
                case '29':
                    $pos=28;
                break;
                case '30':
                    $pos=29;
                break;
                case '31':
                    $pos=30;
                break;
                default:
                $pos='NO';
                  break;
                
                
                
                
                
             }

             if ($pos!='NO' && $mes==$m) {
                $arrayValorxDias[$pos]=$valor;
             }
             
          }

         




        $mensaje = ["Titulo" => "Éxito", "Respuesta" => "la informaci&oacuten satisfatoria", "Tipo" => "success","ordenes"=>$arrayEstado,"ordenesMes"=>$arrayValorxMes,"categoriasMesValor"=>$arrayCategorias,"cantidad"=>$ordenes,"valorTotal"=>$valorTotal,"arrayValorxMesPrueba"=>$arrayValorxMesPrueba,"arrayValorxDias"=>$arrayValorxDias,"sumaValorTotal"=>$sumaValorTotal];
       } catch (\Throwable $th) {
         
        $mensaje = ["Titulo" => "Error", "Respuesta" => "Disculpe, se presentó un problema al listar", "Tipo" => "error"];
       }
       return json_encode($mensaje);
    }

    # **********************************************
    # ************ Hallazgos Dasboard ********
    # **********************************************

    public function HallazgosDasborad(){

        $hallazgos="";
        $idEmpresa = Auth::user()->idEmpresa;
        $jsonSucursal=Auth::user()->id_sucursal;
        $jsonSucursal = json_decode($jsonSucursal);
        $id_zona=Auth::user()->id_zona;
        $Tipouser = Auth::user()->roles->first()->name;
        $fechaActual = Carbon::now()->toDateString();

        $Numconductores = 0;
        $NumVehiculos = 0;
        $Novedades = 0;
        $NumPreoperacionales = 0;
        
        $PlacasConPreperacionales = "";

        try{

            if ($Tipouser == "admin") {

                // 🚧🔥 ¡ALERTA DE CAMBIO POR RENDIMIENTO! 🔥🚧
                $hallazgos = $this->hallazgosTodos();
                // 🚧🚧
                $placasSinPreoperacionales = $this->placasSinPreoperacionalesTodos($fechaActual);
                $PlacasConPreoperacionales = $this->placasConPreoperacionalesTodos($fechaActual);
                
                // Indicadores --------
                $Numconductores = $this->NumconductoresTodos();
                $NumVehiculos = $this->NumVehiculosTodos();
                $Novedades = $hallazgos->count();
                $NumPreoperacionales = $PlacasConPreoperacionales->count();
                // --------------------------------

            }elseif ($Tipouser == "superadministrador") {


                // 🚧🔥 ¡ALERTA DE CAMBIO POR RENDIMIENTO! 🔥🚧
                $hallazgos = $this->hallazgosEmpresa($idEmpresa,$fechaActual);
                // 🚧🚧
                $placasSinPreoperacionales = $this->placasSinPreoperacionalesEmpresa($idEmpresa,$fechaActual);
                $PlacasConPreoperacionales = $this->placasConPreoperacionalesEmpresa($idEmpresa,$fechaActual);

                // Indicadores --------
                $Numconductores = $this->NumconductoresEmpresa($idEmpresa);
                $NumVehiculos = $this->NumVehiculosEmpresa($idEmpresa);
                $Novedades = $hallazgos->count();
                $NumPreoperacionales = $PlacasConPreoperacionales->count();
                // ----------------------

            }else {
                // 🚧🔥 ¡ALERTA DE CAMBIO POR RENDIMIENTO! 🔥🚧
                $hallazgos = $this->hallazgosSurcusal($jsonSucursal);
                // 🚧🚧
                $placasSinPreoperacionales = $this->placasSinPreoperacionalesSucursal($jsonSucursal,$fechaActual);
                $PlacasConPreoperacionales = $this->placasConPreoperacionalesSucursal($jsonSucursal,$fechaActual);
                
                // indicadores -----------
                    $Numconductores = $this->NumconductoresSucursal($jsonSucursal);
                    $NumVehiculos = $this->NumVehiculosSucursal($jsonSucursal);
                    $Novedades = $hallazgos->count();
                    $NumPreoperacionales = $PlacasConPreoperacionales->count();
                // ---------------------------------
            } 

            $mensaje = ["Titulo"=>"Exito","Respuesta"=>"la informaciom se subio satisfatoria","Tipo"=>"success",
                "hallazgos"=>$hallazgos,
                "placasSinPreoperacionales"=>$placasSinPreoperacionales,
                "NumConductores"=>$Numconductores,
                'NumVehiculos'=>$NumVehiculos,
                'NumPreoperacionales'=>$NumPreoperacionales,
                'Novedades'=>$Novedades,
                'PlacasConPreperacionales'=>$PlacasConPreoperacionales,
            ]; 
        }catch(\Exception $e){
            dd($e);
            $mensaje = ["Titulo"=>"Error","Respuesta"=>"Algo salio mal contacte con al administrador del sistema.","Tipo"=>"error"]; 
        }
        return json_encode($mensaje);    
    }

    //══════════════════════════ Todos ══════════════════════════
    private function NumconductoresTodos()
    {

        return DB::table('users')
        ->select('users.*')
        ->join('role_user', 'users.id', '=', 'role_user.user_id')
        ->where('role_user.role_id', '=', 10)
        ->count();

    }
    private function NumVehiculosTodos() 
    {
        return DB::table('equipos')
        ->select('equipos.id')
        ->where('equipos.estado', '=', 1)
        ->count();
    }
    private function NovedadesTodos () 
    {

        return DB::table('preoperacionales as p1')
                ->select('p1.placa', 'p1.cantidad_novedades', 'p1.id as max_id')
                ->whereRaw('p1.id = (SELECT MAX(p2.id) FROM preoperacionales as p2 WHERE p1.placa = p2.placa)')
                ->having('cantidad_novedades', '>=', 1)
                ->orderByDesc('cantidad_novedades')
                ->count();
    }
    private function hallazgosTodos () 
    {
        return DB::table('preoperacionales as p1')
            ->leftJoin('equipos', 'equipos.codigo', '=', 'p1.placa')
            ->leftJoin('equipos_conductores', 'equipos_conductores.id_equipo', '=', 'equipos.id')
            ->leftJoin('users', 'users.id', '=', 'equipos_conductores.id_conductor')
            ->select('p1.placa', 'p1.cantidad_novedades', 'p1.id as max_id', 'equipos.id_propietario as NombrePropietario','equipos.id','equipos_conductores.id_conductor')
            ->selectRaw('CONCAT(users.apellidos, " ", users.name)  as nombre_conductor')
            ->whereIn('p1.id', function ($query) {
                $query->select(DB::raw('MAX(p2.id)'))
                    ->from('preoperacionales as p2')
                    ->whereColumn('p1.placa', 'p2.placa')
                    ->groupBy('p2.placa');
            })
            ->having('cantidad_novedades', '>=', 1)
            ->orderByDesc('cantidad_novedades')
            ->get();
    }
    private function placasSinPreoperacionalesTodos($fechaActual)
    {
        return DB::table('equipos')
            ->select('equipos.codigo')
            ->where('equipos.estado', '=', 1)
            ->whereNotExists(function ($query) use ($fechaActual) {
                $query->select(DB::raw(1))
                    ->from('preoperacionales')
                    ->whereColumn('equipos.codigo', 'preoperacionales.placa')
                    ->whereNotNull('cantidad_novedades')
                    ->whereDate('fecha_crea', $fechaActual);
            })
            ->get();
    }
    private function placasConPreoperacionalesTodos($fechaActual) 
    {
        return DB::table('equipos')
            ->where('equipos.estado', '=', 1)
            ->join('preoperacionales', 'equipos.codigo', '=', 'preoperacionales.placa')
            ->select('equipos.codigo', 'preoperacionales.cantidad_novedades as cantidad_novedad')
            ->whereDate('preoperacionales.fecha_crea', $fechaActual)
            ->whereNotNull('preoperacionales.cantidad_novedades')
            ->distinct()
            ->get();
    }
    private function NumPreoperacionalesTodos($fechaActual) 
    {
        return Preoperacionales::where(function($query) {
        $query->whereNotNull('preoperacionales.kilometraje')
            ->orWhereNotNull('preoperacionales.horometro');
        })  
        ->whereDate('preoperacionales.fecha_crea', '=', $fechaActual)
        ->count();
    }
    // --------------------------------


    //══════════════════════════ Por Empresa ══════════════════════════
    private function NumconductoresEmpresa($idEmpresa)
    {

        return DB::table('users')
        ->select('users.*')
        ->where('users.idEmpresa', '=', $idEmpresa)
        ->join('role_user', 'users.id', '=', 'role_user.user_id')
        ->where('role_user.role_id', '=', 10)
        ->count();

    }
    private function NumVehiculosEmpresa($idEmpresa) 
    {
        return DB::table('equipos')
        ->select('equipos.id')
        ->where('equipos.id_empresa', '=', $idEmpresa)
        ->where('equipos.estado', '=', 1)
        ->count();
    }
    private function hallazgosEmpresa ($idEmpresa,$fechaActual) 
    {
        return DB::table('preoperacionales as p1')
            ->leftJoin('equipos', 'equipos.codigo', '=', 'p1.placa')
            ->leftJoin('equipos_conductores', 'equipos_conductores.id_equipo', '=', 'equipos.id')
            ->leftJoin('users', 'users.id', '=', 'equipos_conductores.id_conductor')
            ->select('p1.placa', 'p1.cantidad_novedades', 'p1.id as max_id', 'equipos.id_propietario as NombrePropietario','equipos.id','equipos_conductores.id_conductor')
            ->where('equipos.id_empresa', '=', $idEmpresa)
            ->selectRaw('CONCAT(users.apellidos, " ", users.name)  as nombre_conductor')
            ->whereIn('p1.id', function ($query) {
                $query->select(DB::raw('MAX(p2.id)'))
                    ->from('preoperacionales as p2')
                    ->whereColumn('p1.placa', 'p2.placa')
                    ->groupBy('p2.placa');
            })
            ->having('cantidad_novedades', '>=', 1)
            ->orderByDesc('cantidad_novedades')
            ->get();
    }
    private function placasSinPreoperacionalesEmpresa($idEmpresa,$fechaActual)
    {
        return DB::table('equipos')
            ->select('equipos.codigo')
            ->where('equipos.estado', '=', 1)
            ->where('equipos.id_empresa', '=', $idEmpresa)
            ->whereNotExists(function ($query) use ($fechaActual) {
                $query->select(DB::raw(1))
                    ->from('preoperacionales')
                    ->whereColumn('equipos.codigo', 'preoperacionales.placa')
                    ->whereNotNull('cantidad_novedades')
                    ->whereDate('fecha_crea', $fechaActual);
            })
            ->get();
    }
    private function placasConPreoperacionalesEmpresa($idEmpresa,$fechaActual) 
    {
        return DB::table('equipos')
            ->where('equipos.estado', '=', 1)
            ->join('preoperacionales', 'equipos.codigo', '=', 'preoperacionales.placa')
            ->select('equipos.codigo', 'preoperacionales.cantidad_novedades as cantidad_novedad')
            ->whereDate('preoperacionales.fecha_crea', $fechaActual)
            ->where('equipos.id_empresa', '=', $idEmpresa)
            ->whereNotNull('preoperacionales.cantidad_novedades')
            ->distinct()
            ->orderBy('equipos.codigo')
            ->get();
    }
    // --------------------------------

    //══════════════════════════ Por Sucursal ══════════════════════════
    private function NumconductoresSucursal($jsonSucursal)
    {

        return DB::table('users')
        ->select('users.*')
        ->whereJsonContains('users.id_sucursal', $jsonSucursal)
        // ->where('users.idEmpresa', '=', $idEmpresa)
        ->join('role_user', 'users.id', '=', 'role_user.user_id')
        ->where('role_user.role_id', '=', 10)
        ->count();

    }
    private function NumVehiculosSucursal($jsonSucursal) 
    {
        return DB::table('equipos')
        ->where('equipos.id_sucursal', '=', $jsonSucursal[0])
        ->where('equipos.estado', '=', 1)
        ->select('equipos.id')
        ->count();
    }
    private function hallazgosSurcusal ($jsonSucursal) 
    {
        return DB::table('preoperacionales as p1')
            ->leftJoin('equipos', 'equipos.codigo', '=', 'p1.placa')
            ->leftJoin('equipos_conductores', 'equipos_conductores.id_equipo', '=', 'equipos.id')
            ->leftJoin('users', 'users.id', '=', 'equipos_conductores.id_conductor')
            ->select('p1.placa', 'p1.cantidad_novedades', 'p1.id as max_id', 'equipos.id_propietario as NombrePropietario','equipos.id','equipos_conductores.id_conductor')
            // ->where('equipos.id_empresa', '=', $idEmpresa)
            ->selectRaw('CONCAT(users.apellidos, " ", users.name)  as nombre_conductor')
            ->where('equipos.id_sucursal', '=', $jsonSucursal[0])
            ->whereIn('p1.id', function ($query) {
                $query->select(DB::raw('MAX(p2.id)'))
                    ->from('preoperacionales as p2')
                    ->whereColumn('p1.placa', 'p2.placa')
                    ->groupBy('p2.placa');
            })
            ->having('cantidad_novedades', '>=', 1)
            ->orderByDesc('cantidad_novedades')
            ->get();
    }
    private function placasSinPreoperacionalesSucursal($jsonSucursal,$fechaActual)
    {
        return DB::table('equipos')
            ->select('equipos.*')
            ->where('equipos.estado', '=', 1)
            // ->where('equipos.id_empresa', '=', $idEmpresa)
            ->where('equipos.id_sucursal', '=', $jsonSucursal[0])
            ->whereNotExists(function ($query) use ($fechaActual) {
                $query->select(DB::raw(1))
                    ->from('preoperacionales')
                    ->whereColumn('equipos.codigo', 'preoperacionales.placa')
                    ->whereNotNull('cantidad_novedades')
                    ->whereDate('fecha_crea', $fechaActual);
            })
            ->get();
    }
    private function placasConPreoperacionalesSucursal($jsonSucursal,$fechaActual) 
    {
        return DB::table('equipos')
            ->where('equipos.estado', '=', 1)
            ->join('preoperacionales', 'equipos.codigo', '=', 'preoperacionales.placa')
            ->select('equipos.*', 'preoperacionales.cantidad_novedades as cantidad_novedad')
            ->whereDate('preoperacionales.fecha_crea', $fechaActual)
            // ->where('equipos.id_empresa', '=', $idEmpresa)
            ->where('equipos.id_sucursal', '=', $jsonSucursal[0])
            ->whereNotNull('preoperacionales.cantidad_novedades')
            ->distinct()
            ->orderBy('equipos.codigo')
            ->get();

    }

    // --------------------------------


    public function toMoney($val,$symbol='$',$r=2){
        $n = $val;
        $c = is_float($n) ? 1 : number_format($n,$r);
        $d = '.';
        $t = ',';
        $sign = ($n < 0) ? '-' : '';
        $i = $n=number_format(abs($n),$r);
        $j = (($j = strlen($i)) > 3) ? $j % 3 : 0;

        return  $symbol.$sign .($j ? substr($i,0, $j) + $t : '').preg_replace('/(\d{3})(?=\d)/',"$1" + $t,substr($i,$j)) ;
    }

    # **********************************************
    # ************ Idicadores / reportes ********
    # **********************************************

    public function recorrerTablaAlfa(){
        $registros = Preoperacionales::whereNotNull('preoperacionales.kilometraje')
        ->orderBy('preoperacionales.placa')
        ->orderBy('preoperacionales.fecha_crea', 'asc')
        ->leftJoin('equipos', 'equipos.codigo', '=', 'preoperacionales.placa')
        ->select('preoperacionales.*', 'equipos.id_sucursal', 'equipos.id_tipo_equipo')
        ->get();

        $primerRegistro = null;
        $ultimoRegistro = null;

        $diferenciasPositivas = [];

        foreach ($registros as $registro) {
            $placa = $registro->placa;
            $planta = $registro->id_sucursal;
            $tipo_equipo = $registro->id_tipo_equipo;

            if (!isset($primerRegistro[$placa])) {
                $primerRegistro[$placa] = $registro;
            }

            $ultimoRegistro[$placa] = $registro;
        }

        foreach ($primerRegistro as $placa => $primer) {
            $ultimo = $ultimoRegistro[$placa];

            $kilometrajePrimer = floatval(str_replace('.', '', $primer->kilometraje));
            $kilometrajeUltimo = floatval(str_replace('.', '', $ultimo->kilometraje));
            $diferenciaKilometraje = $kilometrajeUltimo - $kilometrajePrimer;

            if ($diferenciaKilometraje >= 0) {
                $diferenciasPositivas[] = [
                    'Placa' => $placa,
                    'Planta' => $planta,
                    'TipoEquipo' => $tipo_equipo,
                    'DiferenciaKilometraje' => $diferenciaKilometraje,
                    'FechaPrimerRegistro' => $primer->fecha_crea,
                    'FechaUltimoRegistro' => $ultimo->fecha_crea,
                    'PrimerKilometraje' => $kilometrajePrimer,
                    'UltimoKilometraje' => $kilometrajeUltimo,
                    
                ];
            }
        }
    
        foreach ($diferenciasPositivas as $diferencia) {
            echo "Placa: {$diferencia['Placa']},Planta: {$diferencia['Planta']},TipoEquipo: {$diferencia['TipoEquipo']}, Primer Kilometraje: {$diferencia['PrimerKilometraje']}, Ultimo Kilometraje: {$diferencia['UltimoKilometraje']}, Diferencia de Kilometraje: {$diferencia['DiferenciaKilometraje']}, Fecha Primer Registro: {$diferencia['FechaPrimerRegistro']}, Fecha Ultimo Registro: {$diferencia['FechaUltimoRegistro']}<br>";
            // echo "Placa: {$diferencia['Placa']}, Diferencia de Kilometraje: {$diferencia['DiferenciaKilometraje']}, Fecha Primer Registro: {$diferencia['FechaPrimerRegistro']}, Fecha Ultimo Registro: {$diferencia['FechaUltimoRegistro']}<br>";
        }
    }
    
    public function mostrarResultados() {
        $registros = Preoperacionales::whereNotNull('preoperacionales.kilometraje')
        ->orderBy('preoperacionales.placa')
        ->orderBy('preoperacionales.fecha_crea', 'asc')
        ->leftJoin('equipos', 'equipos.codigo', '=', 'preoperacionales.placa')
        ->select('preoperacionales.*', 'equipos.id_sucursal', 'equipos.id_tipo_equipo')
        ->get();
    
        $primerRegistro = [];
        $ultimoRegistro = [];
        $diferenciasPositivas = [];
        $totalDiferencia = 0;
        $totalPorSucursal = [];
        $totalPorTipoEquipo = [];
        
        foreach ($registros as $registro) {
            $placa = $registro->placa;
            $planta = $registro->id_sucursal;
            $tipo_equipo = $registro->id_tipo_equipo;
        
            if (!isset($primerRegistro[$placa])) {
                $primerRegistro[$placa] = $registro;
            }
        
            $ultimoRegistro[$placa] = $registro;
        }
        
        foreach ($primerRegistro as $placa => $primer) {
            $ultimo = $ultimoRegistro[$placa];
        
            $kilometrajePrimer = floatval(str_replace('.', '', $primer->kilometraje));
            $kilometrajeUltimo = floatval(str_replace('.', '', $ultimo->kilometraje));
            $diferenciaKilometraje = $kilometrajeUltimo - $kilometrajePrimer;
        
            if ($diferenciaKilometraje >= 0) {
                $totalDiferencia += $diferenciaKilometraje;
        
                // Total por id_sucursal
                if (!isset($totalPorSucursal[$planta])) {
                    $totalPorSucursal[$planta] = 0;
                }
                $totalPorSucursal[$planta] += $diferenciaKilometraje;
        
                // Total por tipo equipo
                if (!isset($totalPorTipoEquipo[$tipo_equipo])) {
                    $totalPorTipoEquipo[$tipo_equipo] = 0;
                }
                $totalPorTipoEquipo[$tipo_equipo] += $diferenciaKilometraje;
        
                $diferenciasPositivas[] = [
                    'Placa' => $placa,
                    'Planta' => $planta,
                    'TipoEquipo' => $tipo_equipo,
                    'DiferenciaKilometraje' => $diferenciaKilometraje,
                    'FechaPrimerRegistro' => $primer->fecha_crea,
                    'FechaUltimoRegistro' => $ultimo->fecha_crea,
                    'PrimerKilometraje' => $kilometrajePrimer,
                    'UltimoKilometraje' => $kilometrajeUltimo,
                ];
            }
        }
        
        // Imprimir resultados
        echo "Total de Diferencia: $totalDiferencia<br>";
        
        echo "<br>Total por Sucursal:<br>";
        foreach ($totalPorSucursal as $sucursal => $total) {
            echo "Sucursal $sucursal: $total<br>";
        }
        
        echo "<br>Total por Tipo de Equipo:<br>";
        foreach ($totalPorTipoEquipo as $tipo => $total) {
            echo "Tipo de Equipo $tipo: $total<br>";
        }

        // generar excelK¿

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $styleArrayHeader = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4F81BD'], // Cambia este valor a un azul suave de tu elección
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ];

        // Encabezados
        $sheet->setCellValue('A1', 'Placa');
        $sheet->setCellValue('B1', 'Planta');
        $sheet->setCellValue('C1', 'Tipo de Equipo');
        $sheet->setCellValue('D1', 'Diferencia de Kilometraje');
        $sheet->setCellValue('E1', 'Fecha Primer Registro');
        $sheet->setCellValue('F1', 'Fecha Ultimo Registro');
        $sheet->setCellValue('G1', 'Primer Kilometraje');
        $sheet->setCellValue('H1', 'Ultimo Kilometraje');

        // Aplicar estilos al encabezado
        $sheet->getStyle('A1:H1')->applyFromArray($styleArrayHeader);

        // Datos
        $row = 2;
        foreach ($diferenciasPositivas as $diferencia) {
            $sheet->setCellValue('A' . $row, $diferencia['Placa']);
            $sheet->setCellValue('B' . $row, $diferencia['Planta']);
            $sheet->setCellValue('C' . $row, $diferencia['TipoEquipo']);
            $sheet->setCellValue('D' . $row, $diferencia['DiferenciaKilometraje']);
            $sheet->setCellValue('E' . $row, $diferencia['FechaPrimerRegistro']);
            $sheet->setCellValue('F' . $row, $diferencia['FechaUltimoRegistro']);
            $sheet->setCellValue('G' . $row, $diferencia['PrimerKilometraje']);
            $sheet->setCellValue('H' . $row, $diferencia['UltimoKilometraje']);

            // Aplicar bordes a cada celda con datos
            foreach (range('A', 'H') as $col) {
                $sheet->getStyle($col . $row)->applyFromArray(['borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ]]);
            }

            $row++;
        }

        // Total de Diferencia
        $sheet->setCellValue('A' . $row, 'Total de Diferencia');
        $sheet->setCellValue('B' . $row, $totalDiferencia);

        // Total por Sucursal
        $row++;
        $sheet->setCellValue('A' . $row, 'Total por Sucursal');
        $col = 'B';
        foreach ($totalPorSucursal as $sucursal => $total) {
            $sheet->setCellValue($col . $row, "Sucursal $sucursal");
            $col++;
            $sheet->setCellValue($col . $row, $total);

            // Aplicar bordes a cada celda con datos
            $sheet->getStyle($col . $row)->applyFromArray(['borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ]]);

            $col++;
        }

        // Total por Tipo de Equipo
        $row++;
        $sheet->setCellValue('A' . $row, 'Total por Tipo de Equipo');
        $col = 'B';
        foreach ($totalPorTipoEquipo as $tipo => $total) {
            $sheet->setCellValue($col . $row, "Tipo de Equipo $tipo");
            $col++;
            $sheet->setCellValue($col . $row, $total);

            // Aplicar bordes a cada celda con datos
            $sheet->getStyle($col . $row)->applyFromArray(['borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ]]);

            $col++;
        }

        // Ajustar automáticamente el tamaño de las columnas
        foreach (range('A', $sheet->getHighestDataColumn()) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Guardar el archivo Excel en el servidor
        $excelFilename = 'Prueba.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save($excelFilename);

        // Limpiar el búfer de salida
        ob_end_clean();

        // Establecer los encabezados para descargar el archivo Excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $excelFilename . '"');
        header('Cache-Control: max-age=0');

        // Leer y enviar el archivo Excel al navegador
        readfile($excelFilename);
        exit;
    }

    # = Prueba ===================
    public function mostrarRegistrosParaPlaca03(){
        // Obtener todos los registros ordenados por fecha ascendente para la placa '03'
        $registros = preoperacionales::where('placa', 'POV43E')->orderBy('fecha_crea')->get();

        // Imprimir o devolver los registros
        foreach ($registros as $registro) {
            echo "Placa: {$registro->placa}, Kilometraje: {$registro->kilometraje}, Fecha: {$registro->fecha_crea}<br>";
        }
    }

    # = Mantenimiento Realizados ===================
    public function MantenimientosRealizados(){
        // Obtener datos de la tabla "facturas"
        $facturas = facturas::select('fecha_factura', 'id_conductor', 'id_placa', 'cantidad_hallazgos')->get();

        // Punto 1: Total de mantenimientos
        $totalMantenimientos = $facturas->count();

        // Punto 2: Total registros por id_placa
        $totalPorPlaca = $facturas->groupBy('id_placa')->map->count();

        // Punto 3: Total registros por id_conductor
        $totalPorConductor = $facturas->groupBy('id_conductor')->map->count();

        $totalNovedades = $facturas->sum('cantidad_hallazgos');

        // Crear un nuevo archivo Excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Estilos
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '3498db']],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']]],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ];

        // Encabezados
        // $sheet->setCellValue('A1', 'Fecha Factura');
        // $sheet->setCellValue('B1', 'ID Conductor');
        // $sheet->setCellValue('C1', 'ID Placa');

        // // Aplicar estilos a la primera fila
        // $sheet->getStyle('A1:C1')->applyFromArray($headerStyle);

        // Datos
        $row = 0;
        // foreach ($facturas as $factura) {
        //     $sheet->setCellValue('A' . $row, $factura->fecha_factura);
        //     $sheet->setCellValue('B' . $row, $factura->id_conductor);
        //     $sheet->setCellValue('C' . $row, $factura->id_placa);

        //     // Aplicar estilos y bordes a cada celda con datos
        //     foreach (range('A', 'C') as $col) {
        //         $sheet->getStyle($col . $row)->applyFromArray($headerStyle);
        //     }

        //     $row++;
        // }

        // Ajustar automáticamente el tamaño de las columnas
        foreach (range('A', $sheet->getHighestDataColumn()) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $row++;
        $sheet->setCellValue('A' . $row, 'Total Mantenimientos');
        $sheet->setCellValue('B' . $row, $totalMantenimientos);

        $row++;
        $sheet->setCellValue('A' . $row, 'Total Hallazgos');
        $sheet->setCellValue('B' . $row, $totalNovedades);

        $row++;
        $sheet->setCellValue('A' . $row, 'Total por Placa');
        $col = 'B';
        foreach ($totalPorPlaca as $placa => $total) {
            $sheet->setCellValue($col . $row, "Placa $placa");
            $col++;
            $sheet->setCellValue($col . $row, $total);
            $col++;
        }

        $row++;
        $sheet->setCellValue('A' . $row, 'Total por Conductor');
        $col = 'B';
        foreach ($totalPorConductor as $conductor => $total) {
            $sheet->setCellValue($col . $row, "Conductor $conductor");
            $col++;
            $sheet->setCellValue($col . $row, $total);
            $col++;
        }

        // Guardar el archivo Excel en el servidor
        $excelFilename = 'Reporte_Facturas.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save($excelFilename);

        // Limpiar el búfer de salida
        ob_end_clean();

        // Establecer los encabezados para descargar el archivo Excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $excelFilename . '"');
        header('Cache-Control: max-age=0');

        // Leer y enviar el archivo Excel al navegador
        readfile($excelFilename);
        exit;
    }

    # = Cantidad Conductores ===================
    public function Conductores($Planta){

        $registros = DB::table('users')
        ->select('users.*')
        ->whereJsonContains('users.id_sucursal', $Planta)
        ->join('role_user', 'users.id', '=', 'role_user.user_id')
        ->where('role_user.role_id', '=', 10)
        ->count();
    

        // dd($registros); 
       
        // $totalConductores = users::where('descript', 'conductor')->count();
        // dd($totalConductores);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Establecer un estilo para el encabezado
        $styleArray = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '3498db'],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ];
        // $totalEquiposEstado2 = equipos::where('equipos.estado', '=', 1)
        // ->where('equipos.id_sucursal', '=', $Planta)
        // ->count();

        $nombreSucursal = sucursales::select('sucursales.nombre as NombreSU')
        ->where('sucursales.id', '=', 2)
        ->first();
        // dd($nombreSucursal);
        // Encabezados
        $sheet->setCellValue('A1', 'Sucursal');
        $sheet->setCellValue('A2', $nombreSucursal->NombreSU);
        $sheet->setCellValue('B1', 'Total Conductores');
        $sheet->setCellValue('B2', $registros);

        // $sheet->setCellValue('B1', 'Totales por Id_Sucursal');
        // foreach ($totalesPorSucursal as $totales) {
        //     $sheet->setCellValueByColumnAndRow(2, $totales->id_sucursal + 2, $totales->total);
        // }

        // Establecer estilos para el encabezado
        $sheet->getStyle('A1:B1')->applyFromArray($styleArray);

        // Ajustar automáticamente el tamaño de las columnas
        foreach (range('A', 'B') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Guardar el archivo Excel en el servidor
        $excelFilename = 'InformedeConductores.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save($excelFilename);

        // Limpiar el búfer de salida
        ob_end_clean();

        // Establecer los encabezados para descargar el archivo Excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $excelFilename . '"');
        header('Cache-Control: max-age=0');

        // Leer y enviar el archivo Excel al navegador
        readfile($excelFilename);
        exit;

    }

    # = Cantidad de preoperacionales ===================
    public function Preoperacionales($fechaInicio,$fechaFin){

        // Número total de registros
        // $totalRegistros = Preoperacionales::count();
            $totalRegistros = Preoperacionales::where(function($query) {
                $query->whereNotNull('preoperacionales.kilometraje')
                    ->orWhereNotNull('preoperacionales.horometro');
            })
            ->whereBetween('preoperacionales.fecha_crea', [$fechaInicio, $fechaFin])
            // ->whereJsonContains('users.id_sucursal', $Planta)
            ->count();

            // Número de registros divididos por id_sucursal
            $registrosPorSucursal = Preoperacionales::leftJoin('equipos', 'equipos.codigo', '=', 'preoperacionales.placa')
            ->select('preoperacionales.*', 'equipos.id_sucursal as id_sucursal')
            ->where(function($query) {
                $query->whereNotNull('preoperacionales.kilometraje')
                      ->orWhereNotNull('preoperacionales.horometro');
            })
            // ->whereJsonContains('users.id_sucursal', $Planta)
            ->whereBetween('preoperacionales.fecha_crea', [$fechaInicio, $fechaFin])
            ->get();


            $numRegistrosPorSucursal = $registrosPorSucursal->groupBy('id_sucursal')->map->count();

            // Obtener los nombres de sucursales correspondientes
            $nombreSucursales = sucursales::whereIn('id', $numRegistrosPorSucursal->keys())->pluck('nombre', 'id');
            
            // Mostrar resultados
            echo "Número total de registros: $totalRegistros<br>";
            
            echo "Número de registros por sucursal:<br>";
            foreach ($numRegistrosPorSucursal as $idSucursal => $numRegistros) {
                $nombreSucursal = $nombreSucursales[$idSucursal] ?? 'Desconocido';
                echo "Sucursal $nombreSucursal (ID $idSucursal): $numRegistros<br>";
            }

            // Crear una instancia de Spreadsheet
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Encabezados
            $sheet->setCellValue('A1', 'Número total de registros');
            $sheet->setCellValue('B1', $totalRegistros);
            $sheet->setCellValue('D1', $fechaInicio);
            $sheet->setCellValue('E1', $fechaFin);

            $sheet->setCellValue('A2', 'Número de registros por sucursal');

            // Encabezados específicos para registros por sucursal
            $sheet->setCellValue('B2', 'Sucursal');
            // $sheet->setCellValue('C2', 'ID Sucursal');
            $sheet->setCellValue('C2', 'Número de Registros');

            // Datos
            $row = 3;
            foreach ($numRegistrosPorSucursal as $idSucursal => $numRegistros) {
                $nombreSucursal = $nombreSucursales[$idSucursal] ?? 'Desconocido';
                $sheet->setCellValue('B' . $row, $nombreSucursal);
                // $sheet->setCellValue('C' . $row, $idSucursal);
                $sheet->setCellValue('C' . $row, $numRegistros);
                $row++;
            }

            // Ajustar automáticamente el tamaño de las columnas
            foreach (range('A', 'D') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            // Guardar el archivo Excel en el servidor
            $excelFilename = 'ResultadosPreoperacionales.xlsx';
            $writer = new Xlsx($spreadsheet);
            $writer->save($excelFilename);

            // Limpiar el búfer de salida
            ob_end_clean();

            // Establecer los encabezados para descargar el archivo Excel
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $excelFilename . '"');
            header('Cache-Control: max-age=0');

            // Leer y enviar el archivo Excel al navegador
            readfile($excelFilename);
            exit;


        }

    
        // cantidad vehiculos con novedades
    
        public function vehiculoNovedades () {
        $vehiculosConNovedades = DB::table('preoperacionales')
        ->select('placa', DB::raw('COUNT(*) as cantidad_novedades'))
        ->whereNotNull('kilometraje') // Añade otras condiciones según sea necesario
        ->groupBy('placa')
        ->having('cantidad_novedades', '>', 1)
        ->get();

        // Obtener el último registro de cada vehículo
        $ultimosRegistros = DB::table('preoperacionales')
            ->select('placa', DB::raw('MAX(id) as ultimo_registro_id'))
            ->whereNotNull('kilometraje') // Añade otras condiciones según sea necesario
            ->groupBy('placa')
            ->get();

        // Filtrar los resultados basados en el último registro
        $resultadosFinales = $ultimosRegistros->filter(function ($registro) use ($vehiculosConNovedades) {
            return $vehiculosConNovedades->contains('placa', $registro->placa);
        });

        // Mostrar resultados
        foreach ($vehiculosConNovedades as $resultado) {
            echo "Placa: $resultado->placa, Cantidad de Novedades: $resultado->cantidad_novedades<br>";
        }
    }   

    # = cantidad de infracciones ===================
    public function CantidadInfracciones () {
        $registros = equipos_multas::all();
        foreach ($registros as $registro) {
            echo "ID: {$registro->id}, Equipo: {$registro->id_equipo}, Fecha Inicio: {$registro->fecha_inicio}<br>";
        }
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $styleArray = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '3498db'],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ];

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Equipo');
        $sheet->setCellValue('C1', 'Fecha Inicio');

        $row = 2;

        foreach ($registros as $registro) {
            $sheet->setCellValue('A' . $row, $registro->id);
            $sheet->setCellValue('B' . $row, $registro->id_equipo);
            $sheet->setCellValue('C' . $row, $registro->fecha_inicio);

            foreach (range('A', 'C') as $col) {
                $sheet->getStyle($col . $row)->applyFromArray($styleArray);
            }

            $row++;
        }

        foreach (range('A', 'C') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $excelFilename = 'EquiposMultas.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save($excelFilename);

        ob_end_clean();

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $excelFilename . '"');
        header('Cache-Control: max-age=0');

        readfile($excelFilename);
        exit;
        
    }

    # = cantidad vehiculo ===================
    public function CantidadVehiculo ($Planta){
        $totalEquiposEstado2 = equipos::
        where('equipos.estado', '=', 1)
        ->where('equipos.id_sucursal', '=', $Planta)
        ->count();

    
        $totalEquiposEstado1 = equipos::select('sucursales.nombre as nombre_sucursal', 'equipos.id_sucursal', \DB::raw('count(*) as total'))
        ->join('sucursales', 'sucursales.id', '=', 'equipos.id_sucursal')
        ->groupBy('equipos.id_sucursal', 'sucursales.nombre')
        ->where('equipos.estado', '=', 1)
        ->where('equipos.id_sucursal', '=', $Planta)
        ->get();


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $styleArray = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '3498db'],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ];

        $sheet->setCellValue('A1', 'Planta');
        $sheet->setCellValue('B1', 'Total Equipos con Estado Activos');
        $sheet->setCellValue('B2', $totalEquiposEstado2);

        foreach ($totalEquiposEstado1 as $equipo) {
            $nombreSucursal = $equipo->nombre_sucursal;
            $idSucursal = $equipo->id_sucursal;
            $total = $equipo->total;

            $sheet->setCellValue('A2', $nombreSucursal);
        }
        $sheet->getStyle('A1:B1')->applyFromArray($styleArray);

        foreach (range('A', 'B') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $excelFilename = 'InformeEquipos.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save($excelFilename);

        ob_end_clean();

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $excelFilename . '"');
        header('Cache-Control: max-age=0');

        readfile($excelFilename);
        exit;
        
    }
    # = cantidad vehiculo ===================
    public function PreoperacionalesUnoUno ($fechaInicio,$fechaFin,$Planta) {

            $styleArray = [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '3498db'],
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ];

            $spreadsheet = new Spreadsheet();
            $sheet1 = $spreadsheet->getActiveSheet();   
            
            $sheet1->setCellValue('A1', 'Fecha');
            $sheet1->setCellValue('B1', 'Placa');
            $sheet1->setCellValue('C1', 'Conductor');
            $sheet1->setCellValue('D1', 'Cedula');
            
            $registrosPorSucursal = Preoperacionales::leftJoin('equipos', 'equipos.codigo', '=', 'preoperacionales.placa')
                ->leftJoin('users', 'users.id', '=', 'preoperacionales.id_usuario_crea')
                ->select('preoperacionales.*', 'equipos.id_sucursal as id_sucursal', 'users.name as nombre_usuario',
                    'users.identificacion as cedula_conductor', 'users.id_sucursal as sucursales')
                ->where(function ($query) {
                    $query->whereNotNull('preoperacionales.kilometraje')
                        ->orWhereNotNull('preoperacionales.horometro');
                })
                ->whereBetween('preoperacionales.fecha_crea', [$fechaInicio, $fechaFin])
                ->whereJsonContains('users.id_sucursal', $Planta)
                ->orderBy('preoperacionales.fecha_crea', 'asc')
                ->get();
            
            $row = 2;
            foreach ($registrosPorSucursal as $registro) {
                $sheet1->setCellValue('A' . $row, $registro->fecha_crea);
                $sheet1->setCellValue('B' . $row, $registro->placa);
                $sheet1->setCellValue('C' . $row, $registro->nombre_usuario);
                $sheet1->setCellValue('D' . $row, $registro->cedula_conductor);
                // $sheet1->setCellValue('E' . $row, $registro->sucursales);
                $row++;
            }
            
            $sheet1->getStyle('A1:D1')->applyFromArray($styleArray);
            
            foreach (range('A', 'D') as $col) {
                $sheet1->getColumnDimension($col)->setAutoSize(true);
            }
            
            $excelFilename = 'InformePreoperacionales.xlsx';
            $writer = new Xlsx($spreadsheet);
            $writer->save($excelFilename);
            
            ob_end_clean();
            
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $excelFilename . '"');
            header('Cache-Control: max-age=0');

            readfile($excelFilename);
            exit;
    }

    public function Prueba (Request $request, $fechaInicio, $fechaFin,$Tipo,$Planta) {

        if ($Tipo == 7){
            $this->PreoperacionalesUnoUno($fechaInicio, $fechaFin,$Planta);
        }elseif ($Tipo == 3) {
            // dd($Planta);
            $this->CantidadVehiculo($Planta);
        }elseif ($Tipo == 8) {
            // dd($Planta);
            $this->Conductores($Planta);
        }
        elseif ($Tipo == 4) {
            // dd($Planta);
            $this->Preoperacionales($fechaInicio, $fechaFin);
        }
        else {
            exit;
        }

        
        // dd($fechaInicio);
    }

}