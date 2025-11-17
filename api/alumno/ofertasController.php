<?

require_once $_SERVER["DOCUMENT_ROOT"] . '/dao/OfertaDAO.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/models/entities/OfertaEntity.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/dao/AlumnoDAO.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/models/entities/AlumnoEntity.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/dao/CicloAlumnosDAO.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/models/entities/CiclosAlumnosEntity.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/dao/EmpresaDAO.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/models/entities/EmpresaEntity.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/dao/PostulacionDAO.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/models/entities/PostulacionEntity.php';

class ofertasController {

    private $ofertaDAO;
    private $alumno;
    private $cicloAlumnosDAO;
    private $empresaDAO;
    private $postulacionDAO;

    public function __construct() {
        $this->ofertaDAO = new ofertaDAO();
        $this->alumno = new alumnoDAO();
        $this->cicloAlumnosDAO = new cicloAlumnosDAO();
        $this->empresaDAO = new EmpresaDAO();
        $this->postulacionDAO = new PostulacionDAO();

    }

    public function getOfertas($bool)
    {
        if(isset($_SESSION["user_id"]))
        {
            $id = $this->alumno->findByUsuarioId($_SESSION["user_id"])->id;
        }

        $ciclosExtra = $this->cicloAlumnosDAO->getAllByAlumnoId($id);

        $ofertasTotales = [];
        $ofertasFiltradas = [];
        $ofertasPostuladas = [];

        $ofertasCicloPrincipal = $this->ofertaDAO->getByCicloId($id);
        
        foreach($ofertasCicloPrincipal as $oferta)
        {
            $ofertasTotales[] = $oferta;
        }

        foreach($ciclosExtra as $cicloExtra)
        {
            $idCiclo = $cicloExtra->ciclo_id;
            $ofertasCiclosExtra = $this->ofertaDAO->getByCicloId($idCiclo);
            
            foreach($ofertasCiclosExtra as $oferta)
            {
                $ofertasTotales[] = $oferta;
            }
        }

        foreach($ofertasTotales as $oferta){

            $yaPostulado = $this->postulacionDAO->comprobarOferta($oferta->id, $id);

            if(!$yaPostulado)
            {
                $ofertasFiltradas[] = $oferta;
            }
            else
            {
                $ofertasPostuladas[] = $oferta;
            }

        }

        $resultado = null;
        
        if(!$bool)
        {
            $resultado = $ofertasFiltradas;
        }

        if(!$bool)
        {
            return $ofertasFiltradas;
        }
        else
        {
            return $ofertasPostuladas;
        }

        return $resultado;
        
    }

    public function findEmpresaById($idEmpresa)
    {
        return $this->empresaDAO->getById($idEmpresa);
    }

}