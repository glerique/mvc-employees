<?php

namespace App\Controller;

use App\Lib\Database;
use App\Lib\Renderer;
use App\Lib\Pagination;
use App\Entity\Employee;
use App\Controller\Controller;
use App\Model\EmployeeManager;
use App\Model\DepartementManager;

class EmployeeController extends Controller
{
    private $model;

    public function __construct(EmployeeManager $employeeManager)
    {
        $this->model = $employeeManager;
    }

    public function index()
    {
        $id = $_GET['id'];
        if (!$id or !is_int($id)) {
            $this->redirect(
                "/mvc-employees/employee/index/1"                
            );
        }

        $total = $this->model->count();
        $pagination = new Pagination($total);
        $pages = $pagination->getPages();
        $currentPage = $pagination->getCurrentPage();
        $perPage = $pagination->getPerPage();
        $employees = $this->model->PaginateFindAll($id, $perPage);
        if (!$employees) {
            $this->redirectWithError(
                "/mvc-employees/employee/index/1",
                "Vous essayez de consulter une page qui n'existe pas !"
            );
        }

        Renderer::render("employee/listing", compact('employees', 'currentPage', 'pages'));
    }

    public function show()
    {
        $id = filter_var($_GET['id'], FILTER_VALIDATE_INT); 
        if (!$id or !is_int($id)) {
            $this->redirectWithError(
                "/mvc-employees/employee/index",
                "Merci de renseigner un id"
            );
        }
        $employee = $this->model->findById($id);
        if (!$employee) {
            $this->redirectWithError(
                "/mvc-employees/employee/index",
                "Vous essayez de consulter un employee qui n'existe pas !"
            );
        }

        Renderer::render("employee/details", compact('employee'));
    }

    public function newView()
    {
        $db = new Database;
        $departementManager = new DepartementManager($db);
        $departements = $departementManager->findAll();
        Renderer::render("employee/nouveau", compact('departements'));
    }

    public function new()
    {
        $lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_SPECIAL_CHARS);
        $firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_SPECIAL_CHARS);
        $birthDate = filter_input(INPUT_POST, 'birthDate', FILTER_SANITIZE_SPECIAL_CHARS);
        $hireDate = filter_input(INPUT_POST, 'hireDate', FILTER_SANITIZE_SPECIAL_CHARS);
        $salary = filter_input(INPUT_POST, 'salary', FILTER_SANITIZE_SPECIAL_CHARS);
        $departementId = filter_input(INPUT_POST, 'departementId', FILTER_SANITIZE_SPECIAL_CHARS);

        if (!$lastName || !$firstName || !$birthDate || !$hireDate || !$salary || !$departementId) {
            $this->redirectWithError(
                "/mvc-employees/employee/new",
                "Merci de bien remplir le formulaire"
            );
        }
/*
        $id = $this->getPostData('id', FILTER_VALIDATE_INT);
        $formData = [
            'lastName' => $this->getPostData('lastName'),
            'firstName' => $this->getPostData('firstName'),
            'birthDate' => $this->getPostData('birthDate'),
            'hireDate' => $this->getPostData('hireDate'),
            'salary' => $this->getPostData('salary'),
            'departementId' => $this->getPostData('departementId'),
        ];
        
        if (!$id || in_array(null, $formData, true)) {
            $this->handleError("/mvc-employees/employee/new", "Merci de bien remplir le formulaire !");
        }
*/       
        $manager = $this->model;        
        $employee = new Employee([
            'lastName' => $lastName,
            'firstName' => $firstName,
            'birthDate' => $birthDate,
            'hireDate' => $hireDate,
            'salary' => $salary,
            'departementId' => $departementId
        ]);  

        $manager->add($employee);

        $this->redirectWithSuccess(
            "/mvc-employees/employee/index",
            "Employé ajouté avec succès"
        );
    }

    public function editView()
    {
        $id = filter_var($_GET['id'], FILTER_VALIDATE_INT); 
        if (!$id or !is_int($id)) {
            $this->redirectWithError(
                "/mvc-employees/employee/index",
                "Merci de renseigner un id"
            );
        }
        $manager = $this->model;
        $db = new Database;
        $departementManager = new DepartementManager($db);
        $employee = $manager->findById($id);
        if (!$employee) {
            $this->redirectWithError(
                "/mvc-employees/employee/index",
                "Vous essayez de modifier un employé qui n'existe pas !"
            );
        }
        $departements = $departementManager->findAll();
        Renderer::Render("employee/modifier", compact('employee', 'departements'));
    }

    public function edit()
    {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_SPECIAL_CHARS);
        $firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_SPECIAL_CHARS);
        $birthDate = filter_input(INPUT_POST, 'birthDate', FILTER_SANITIZE_SPECIAL_CHARS);;
        $hireDate = filter_input(INPUT_POST, 'hireDate', FILTER_SANITIZE_SPECIAL_CHARS);
        $salary = filter_input(INPUT_POST, 'salary', FILTER_SANITIZE_SPECIAL_CHARS);
        $departementId = filter_input(INPUT_POST, 'departementId', FILTER_SANITIZE_SPECIAL_CHARS);

        if (!$id || !$lastName || !$firstName || !$birthDate || !$hireDate || !$salary || !$departementId) {
            $this->redirectWithError(
                "/mvc-employees/employee/new",
                "Merci de bien remplir le formulaire !"
            );
        }

        $manager = $this->model;
        $employee = new Employee([
            'id' => $id,
            'lastName' => $lastName,
            'firstName' => $firstName,
            'birthDate' => $birthDate,
            'hireDate' => $hireDate,
            'salary' => $salary,
            'departementId' => $departementId
        ]);  
        $manager->update($employee);

        $this->redirectWithSuccess(
            "/mvc-employees/employee/index",
            "Employé modifié avec succès"
        );
    }

    public function delete()
    {
        $id = filter_var($_GET['id'], FILTER_VALIDATE_INT); 
        if (!$id or !is_int($id)) {
            $this->redirectWithError(
                "/mvc-employees/employee/index",
                "Merci de renseigner un id"
            );
        }
        $manager = $this->model;
        $employee = $manager->findById($id);
        if (!$employee) {
            $this->redirectWithError(
                "/mvc-employees/employee/index",
                "Vous essayez de supprimer un employé qui n'existe pas !"
            );
        }
        $manager->deleteById($employee);

        $this->redirectWithSuccess(
            "/mvc-employees/employee/index",
            "Employé supprimé avec succès"
        );
    }
}
