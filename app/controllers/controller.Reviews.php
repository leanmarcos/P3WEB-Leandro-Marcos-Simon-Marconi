<?php

require_once "app/models/model.reviews.php";
require_once "app/views/api.view.php";

class ControllerReviews
{
    private $model;
    private $view;

    public function __construct()
    {
        $this->model = new ModelReviews();
        $this->view = new APIView();
    }

    public function getAllReviews($req, $res)
    {
        $orderBy = false;
        $typeOfOrder = "ASC";

        // Vemos si se pide ordernar por un atributo en especifico
        if (isset($req->query->orderBy)) {

            // Si se pide ordenar lo guardamos
            $orderBy = $req->query->orderBy;

            // Verificamos que sean solamente los atributos para prevenir inyecciones SQL
            if ($orderBy != "titulo" && $orderBy != "descripcion" && $orderBy != "valor") {

                // Si no es ninguno de los atributos, convertimos la inyeccion en un valor nulo y mostramos error
                $orderBy = null;
                $this->view->response("La orden no es correcta", 400);
                return;
            } else {
                // Vemos si se pide un orden especifico (ascendente o descendiente)
                if (isset($req->query->order)) {
                    $typeOfOrder = $req->query->order;

                    // Prevencion de ataques con inyeccion SQL (solamente se acepta ASCENDENTE O DESCENDENTE)
                    if ($typeOfOrder != "ASC" && $typeOfOrder != "DESC") {
                        $typeOfOrder = null;
                        return $this->view->response("La orden no es correcta", 400);
                    }
                }
            }
        }

        $reviews = $this->model->getAllReviews($orderBy, $typeOfOrder);

        if (!empty($reviews)) {
            return $this->view->response($reviews, 200);
        } else {
            return $this->view->response("No se encontraron resenias", 404);
        }
    }

    public function getReview($req, $res)
    {
        $id = $req->params->id;

        $review = $this->model->getReview($id);

        if (empty($review)) {
            return $this->view->response("La resenia con el id $id no existe", 404);
        }

        return $this->view->response($review, 200);
    }

    public function deleteReview($req)
    {
        $id = $req->params->id;

        $review = $this->model->getReview($id);

        // Chequeo de existencia de id
        if (empty($review)) {
            return $this->view->response("La resenia con el id $id no existe", 404);
        }

        $this->model->deleteReview($id);

        return $this->view->response("Resenia eliminada correctamente", 200);
    }

    public function createReview($req)
    {
        $title = $req->body->titulo;
        $description = $req->body->descripcion;
        $value = $req->body->valor;

        if (empty($title)) {
            return $this->view->response("titulo vacio", 400);
        }

        if (empty($description)) {
            return $this->view->response("descripcion vacia", 400);
        }

        if (empty($value)) {
            return $this->view->response("valoracion vacia", 400);
        }

        $this->model->newReview($title, $description, $value);

        $this->view->response("Resenia creada", 201);
    }

    public function updateReview($req)
    {
        $id = $req->params->id;

        $checkId = $this->model->getReview($id);

        if (!$checkId) {
            return $this->view->response("el id no existe", 404);
        }

        $title = $req->body->titulo;
        $description = $req->body->descripcion;
        $value = $req->body->valor;

        if (empty($title)) {
            return $this->view->response("titulo vacio", 400);
        }

        if (empty($description)) {
            return $this->view->response("descripcion vacia", 400);
        }

        if (empty($value)) {
            return $this->view->response("valoracion vacia", 400);
        }


        $this->model->updateReview($title, $description, $value, $id);

        return $this->view->response("Reseña editada correctamente", 201);
    }

    public function default()
    {
        $this->view->response("No existe nada con esa url", 404);
    }
}
