<?php
interface DatabaseInterface {
    public function Get();
    public function GetAll();
    public function Insert();
    public function Update();
    public function Delete();
}