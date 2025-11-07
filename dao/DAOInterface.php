<?php
interface DAOInterface {
    public function getById($id);
    public function getAll();
    public function create($object);
    public function update($object);
    public function delete($id);
}
