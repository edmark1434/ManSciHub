<?php

require_once "api/Controller/AdminController.php";
require_once "api/Controller/StudentController.php";
require_once "api/Controller/AdmissionController.php";
require_once "api/Controller/RequestController.php";
require_once "api/Controller/DocumentController.php";
require_once "api/Controller/AuditLogRequestController.php";
require_once "api/Controller/AuditLogAdmissionController.php";
require_once "api/Controller/AdmissionHistoryController.php";
require_once "api/Controller/RequestHistoryController.php";
require_once "api/Controller/AdminControlsController.php";
require_once "backend/Controller/UpdateAdminControlsController.php";
require_once "backend/controller/LoginController.php";
require_once "backend/controller/DocumentRequestController.php";
require_once "backend/controller/AdmissionRequestController.php";
require_once "backend/controller/TransferAdmissionHistoryController.php";
require_once "backend/controller/TransferRequestHistoryController.php";
require_once "backend/controller/EmailController.php";
require_once "backend/controller/UpdateAdminDetailsController.php";
require_once "backend/controller/UpdateDocumentController.php";
require_once "backend/controller/CreateAdminController.php";

header("Content-Type: application/json");
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

class Router{

    private AdminController $admincontroller;
    private StudentController $studentcontroller;
    private AdmissionController $admissioncontroller;
    private RequestController $requestcontroller;
    private DocumentController $documentcontroller;
    private AuditLogAdmissionController $auditLogAdmissionController;
    private AuditLogRequestController $auditLogRequestController;
    private RequestHistoryController $requestHistoryController;
    private AdmissionHistoryController $admissionHistoryController;
    private AdminControlsController $adminControlsController;
    private UpdateAdminControlsController $updateAdminControlsController;
    private LoginController $loginController;
    private DocumentRequestController $documentRequestController;
    private AdmissionRequestController $admissionRequestController;
    private TransferAdmissionHistoryController $transferAdmissionHistoryController;
    private TransferRequestHistoryController $transferRequestHistoryController;
    private UpdateAdminDetailsController $updateAdminDetailsController;
    private EmailController $emailController;
    private UpdateDocumentController $updateDocumentController;
    private CreateAdminController $createAdminController;
    public function __construct()
    {
        $this->admincontroller = new AdminController();
        $this->studentcontroller = new StudentController();
        $this->admissioncontroller = new AdmissionController();
        $this->requestcontroller = new RequestController();
        $this->documentcontroller = new DocumentController();
        $this->auditLogRequestController = new AuditLogRequestController();
        $this->auditLogAdmissionController = new AuditLogAdmissionController();
        $this->admissionHistoryController = new AdmissionHistoryController();
        $this->requestHistoryController = new RequestHistoryController();
        $this->adminControlsController = new AdminControlsController();
        $this->updateAdminControlsController = new UpdateAdminControlsController();
        $this->loginController = new LoginController();
        $this->documentRequestController = new DocumentRequestController();
        $this->admissionRequestController = new AdmissionRequestController();
        $this->transferAdmissionHistoryController = new TransferAdmissionHistoryController();
        $this->transferRequestHistoryController = new TransferRequestHistoryController();
        $this->emailController = new EmailController();
        $this->updateAdminDetailsController = new UpdateAdminDetailsController();
        $this->updateDocumentController = new UpdateDocumentController();
        $this->createAdminController = new CreateAdminController();
    }

    public function route()
    {
        //get the endpoint
        $requestUri = explode("?", $_SERVER['REQUEST_URI'], 2)[0];
        //method request
        $method = $_SERVER['REQUEST_METHOD'];
        switch($method){
            case 'GET':
                $this->getRequest("Admin",$requestUri,$this->admincontroller,'getAdminByID','getAllAdmin');
                $this->getRequest("Student",$requestUri,$this->studentcontroller,'getStudentById','getAllStudent');
                $this->getRequest("Admission",$requestUri,$this->admissioncontroller,'getAdmissionById','getAllAdmission');
                $this->getRequest("Request",$requestUri,$this->requestcontroller,'getRequestById','getAllRequest');
                $this->getRequest("Document",$requestUri,$this->documentcontroller,'getDocumentById','getAllDocument');
                $this->getRequest("AuditLog-Admission",$requestUri,$this->auditLogAdmissionController,'getAuditLogAdmissionById','getAllAuditLogAdmission');
                $this->getRequest("AuditLog-Request",$requestUri,$this->auditLogRequestController,'getAuditLogRequestById','getAllAuditLogRequest');
                $this->getRequest("RequestHistory",$requestUri,$this->requestHistoryController,'getRequestHistoryById','getAllRequestHistory');
                $this->getRequest("AdmissionHistory",$requestUri,$this->admissionHistoryController,'getAdmissionHistoryById','getAllAdmissionHistory');
                $this->getRequest("AdmissionHistoryWithYear",$requestUri,$this->admissionHistoryController,'','getAllAdmissionHistoryWithYear');
                $this->getRequest("AdminControls",$requestUri,$this->adminControlsController,'getAdminControlsByKey','getAllAdminControls');
                break;
            case 'POST':
                $this->postAndPutRequest("Admin",$requestUri,$this->admincontroller,"addAdmin");
                $this->postAndPutRequest("Student",$requestUri,$this->studentcontroller,"addStudent");
                $this->postAndPutRequest("Admission",$requestUri,$this->admissioncontroller,"addAdmission");
                $this->postAndPutRequest("Request",$requestUri,$this->requestcontroller,"addRequest");
                $this->postAndPutRequest("Document",$requestUri,$this->documentcontroller,"addDocument");
                $this->postAndPutRequest("AuditLog-Request",$requestUri,$this->auditLogRequestController,"addAuditLogRequest");
                $this->postAndPutRequest("AuditLog-Admission",$requestUri,$this->auditLogAdmissionController,"addAuditLogAdmission");
                $this->postAndPutRequest("RequestHistory",$requestUri,$this->requestHistoryController,"addRequestHistory");
                $this->postAndPutRequest("AdmissionHistory",$requestUri,$this->admissionHistoryController,"addAdmissionHistory");
                $this->postAndPutRequest("AdminControls",$requestUri,$this->adminControlsController,"addAdminControls");
                $this->postAndPutRequest("Student/Filter",$requestUri,$this->studentcontroller,"getStudentByFilter");
                //Document Request
                $this->BackendLogicRequest("DocumentRequest", $requestUri, $this->documentRequestController, 'DocumentRequest');
                //Admission Request
                $this->BackendLogicRequest("AdmissionRequest", $requestUri, $this->admissionRequestController,"Admission");
                //Transfer Request
                $this->BackendLogicRequest("TransferRequest", $requestUri, $this->transferRequestHistoryController, "transferRequestHistory");
                $this->BackendLogicRequest("EmailNotification", $requestUri, $this->emailController, "EmailNotification");
                $this->BackendLogicRequest("Admin", $requestUri, $this->createAdminController, "addAdmin");
                //Transfer Admission
                $this->BackendLogicRequest("TransferAdmission", $requestUri, $this->transferAdmissionHistoryController, "TransferAllAdmission");
                //login
                if($requestUri === "/api/Admin/login"){
                    $data = json_decode(file_get_contents("php://input"), true);
                    $username = $data["username"] ?? NULL;
                    $password = $data["password"] ?? NULL;
                    if ($username !== null && $password !== null) {
                        $this->loginController->loginController($username, $password);
                    }
                }
                break;
            case 'PUT':
                $this->postAndPutRequest("Admin",$requestUri,$this->admincontroller,"updateAdmin");
                $this->postAndPutRequest("Student",$requestUri,$this->studentcontroller,"updateStudent");
                $this->postAndPutRequest("Admission",$requestUri,$this->admissioncontroller,"updateAdmission");
                $this->postAndPutRequest("Request",$requestUri,$this->requestcontroller,"updateRequest");
                $this->postAndPutRequest("Document",$requestUri,$this->documentcontroller,"updateDocument");
                $this->postAndPutRequest("RequestHistory",$requestUri,$this->requestHistoryController,"updateRequestHistory");
                $this->postAndPutRequest("AdmissionHistory",$requestUri,$this->admissionHistoryController,"updateAdmissionHistory");
                $this->BackendLogicRequest("AdminControls",$requestUri,$this->updateAdminControlsController,"updateAdminControls");
                $this->BackendLogicRequest("Update/Admin", $requestUri, $this->updateAdminDetailsController, "updateAdminDetails");
                $this->BackendLogicRequest("Document/Update", $requestUri, $this->updateDocumentController, "updateDocumentStatus");
                break;
            case 'DELETE':
                $this->deleteRequest('Admin', $requestUri,$this->admincontroller,'deleteAdmin');
                $this->deleteRequest("Student",$requestUri,$this->studentcontroller,"deleteStudent");
                $this->deleteRequest("Admission",$requestUri,$this->admissioncontroller,"deleteAdmission");
                $this->deleteRequest("Request",$requestUri,$this->requestcontroller,"deleteRequest");
                $this->deleteRequest("Document",$requestUri,$this->documentcontroller,"deleteDocument");
                $this->deleteRequest("RequestHistory",$requestUri,$this->requestHistoryController,"deleteRequestHistory");
                $this->deleteRequest("AdmissionHistory",$requestUri,$this->admissionHistoryController,"deleteAdmissionHistory");
                $this->deleteRequest("AdminControls",$requestUri,$this->updateAdminControlsController,"deleteAdminControls");
                break;
            default:
                http_response_code(404);
                break;
        }
    }
    private function getRequest($model,$requestUri,$controller,$methodById,$methodAll){
        if ($model !== "AdminControls") {
            if ($requestUri === "/api/{$model}") {
                $id = isset($_GET['id']) ? (int) htmlspecialchars($_GET['id']) : null;
                if ($id !== null) {
                    $controller->$methodById($id);
                } else {
                    $controller->$methodAll();
                }
            }
            if (preg_match("/\/api\/{$model}\/(\d+)/", $requestUri, $matches)) {
                $controller->$methodById($matches[1]);
            }
        } else {
            if ($requestUri === "/api/{$model}") {
                $key = isset($_GET['key']) ? htmlspecialchars($_GET['key']) : null;
                if ($key !== null) {
                    $controller->$methodById($key);
                } else {
                    $controller->$methodAll();
                }
            }
            if (preg_match("/\/api\/{$model}\/([a-zA-Z0-9]+)/", $requestUri, $matches)) {
                $controller->$methodById($matches[1]);
            }
        }
    }
    private function postAndPutRequest($model,$requestUri,$controller,$method){
                if ($requestUri === "/api/{$model}" || $requestUri === "/api/{$model}/Update") {
                    $entity = json_decode(file_get_contents("php://input"), true);
                    $controller->$method($entity);
                }
    }
    private function deleteRequest($model,$requestUri,$controller,$method){
        if ($model !== "AdminControls") {
            if ($requestUri === "/api/{$model}/Delete") {
                $id = htmlspecialchars($_GET["id"]);
                $controller->$method($id);
            }
            if (preg_match("/\/api\/{$model}\/Delete\/(\d+)/", $requestUri, $matches)) {
                $controller->$method($matches[1]);
            }
        } else {
            if ($requestUri === "/api/{$model}/Delete") {
                $key = htmlspecialchars($_GET["key"]);
                $controller->$method($key);
            }
            if (preg_match("/\/api\/{$model}\/Delete\/([a-zA-Z0-9]+)/", $requestUri, $matches)) {
                $controller->$method($matches[1]);
            }
        }
    }
    private function BackendLogicRequest($model,$requestUri,$controller,$method){
        if ($requestUri === "/api/Service/{$model}") {
            $entity = json_decode(file_get_contents("php://input"), true);
            $controller->$method($entity);
        }
    }
}

?>