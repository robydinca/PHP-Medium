<?php
class apiREST{
    private $modeloController;
    private $resource;

    public function __construct($modeloController, $resource){
        $this->modeloController = $modeloController;
        $this->resource = $resource;
    }
    public function action($endpoint){
        $values = null;
        $url = explode('/',$endpoint);
        //first parameter in endopoint is the name of the resource
        if($url[0]===$this->resource){
            //Endpoint has two parameters
            if(sizeof($url)===2){
                //second parameter is empty(index)
                if($url[1]===''){
                    if($_SERVER['REQUEST_METHOD']==='GET'){
                        $values = $this->modeloController->getAll();
                        echo json_encode($values);
                    }else{
                        $this->invalidMethod();
                    }
                    //second parameter is numeric                 
                }elseif(is_numeric($url[1])){
                    if($_SERVER['REQUEST_METHOD']==='GET' ){
                        $value = $this->modeloController->getById($url[1]);
                        if($value){
                            echo json_encode($value);
                        }else{
                            $this->notFound();
                        }
                    }else{
                        $this->invalidMethod();
                    }
                    //second parameter is store      
                }elseif($url[1]==='store'){
                    if($_SERVER['REQUEST_METHOD']==='POST'){
                        if($this->existsPOST(['name','brand','year'])){
                            $value = $this->modeloController->createModelo($_POST['name'], $_POST['brand'], $_POST['year']);
                            echo json_encode($value);
                        }else{
                            $this->badRequest();
                        }
                    }else{
                        $this->invalidMethod();
                    }
                    
                }else{
                    $this->notFound();
                }
                //Endpoint has two parameters
            }elseif(sizeof($url)===3){
                //second parameter is destroy
                if($url[1]==='destroy'){
                    if(is_numeric($url[2])){
                        if($_SERVER['REQUEST_METHOD']==='DELETE'){
                            if($this->modeloController->delete($url[2])){
                                $this->noContent();
                            }else{
                                $this->notFound();
                            }
                        }else{
                            $this->invalidMethod();
                        }
                    }else{
                        $this->badRequest();
                    }
                }else{
                    $this->notFound();
                }
            }else{
                $this->notFound();
            }
        }else{
            $this->notFound();
        }
    }

    public function existsPOST($array){
        foreach ($array as $value) {
            if(isset($_POST[$value])){
                if($_POST[$value] === ''){
                    return false;
                }
            }else{
                return false;
            }
        }
        return true;
    }

    private function invalidMethod(){
        http_response_code(405);
        header('Content-Type: application/json');
    
        $mensaje = array('error' => 'Metodo no válido');
        echo json_encode($mensaje);
        exit;
    }

    private function badRequest(){
        http_response_code(400);
        header('Content-Type: application/json');

        $mensaje = array('error' => 'Parametros incorrectos o faltantes');
        echo json_encode($mensaje);
        exit;
    }
    private function notFound() {
        http_response_code(404);
        header('Content-Type: application/json');
    
        $mensaje = array('error' => 'Recurso no encontrado');
        echo json_encode($mensaje);
        exit;
    }
    private function noContent(){
        http_response_code(204);
        header('Content-Type: application/json');

        $message = array('mensaje' => 'Elemento eliminado con éxito');
        echo json_encode($message);
    }
    
}
?>