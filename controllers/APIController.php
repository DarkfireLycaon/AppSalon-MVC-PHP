<?php 
namespace Controllers;
use Model\Servicio;
use Model\Cita;
use Model\CitaServicio;

class APIController{
    public static function index(){
        $servicios = Servicio::all();
        echo json_encode($servicios);
    }
    public static function guardar(){

        //almacena la cita y devuelve el Id
       $cita = new Cita ($_POST);
       $resultado = $cita->guardar();

       $id = $resultado['id'];
      //almacena las citas y el servicio
      $idServicios = explode(",", $_POST['servicios']);

      foreach($idServicios as $idServicio){
        $args = [
            'citaId'=>$id,
            'servicioId'=>$idServicio

        ];
        $citasServicio = new CitaServicio($args);
        $citasServicio->guardar();
      }
      //retornamos una respuesta
    
        echo json_encode(['resultado'=>$resultado]);
    }
    public static function eliminar(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id = $_POST['id'];
            $cita = Cita::find($id);
            $cita->eliminar();
            header('Location:' . $_SERVER['HTTP_REFERER']);
        }
    }
}
