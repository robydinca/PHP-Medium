<?php
class Modelo {
    private $id;
    private $name;
    private $brand;
    private $year;

    public function __construct($id, $name, $brand, $year) {
        $this->id = $id;
        $this->name = $name;
        $this->brand = $brand;
        $this->year = $year;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getBrand() {
        return $this->brand;
    }

    public function getYear() {
        return $this->year;
    }
    public function getValues() {
        return array('id'=>$this->id,'name'=> $this->name,'brand'=> $this->brand,'year'=> $this->year);
    }   
}
?>
