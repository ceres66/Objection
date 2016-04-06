<?php
require_once __DIR__ . '/vendor/autoload.php';


// Classic way
class Student {
	
	private $name;
	private $age;
	private $classes = [];
	private $id;
	
	
	
	/** @var Student */
	private $tutor;
	
	
	public function __construct($id)
	{
		$this->id = $id;
	}
	
	
	/**
	 * @return mixed
	 */
	public function getName()
	{
		return $this->name;
	}
	
	/**
	 * @param string $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}
	
	/**
	 * @return int
	 */
	public function getAge()
	{
		return $this->age;
	}
	
	/**
	 * @param mixed $age
	 */
	public function setAge($age)
	{
		$this->age = $age;
	}
	
	/**
	 * @return array
	 */
	public function getClasses()
	{
		return $this->classes;
	}
	
	/**
	 * @param string $class
	 */
	public function addClass($class)
	{
		$this->classes[] = $class;
	}
	
	/**
	 * @return string
	 */
	public function getId()
	{
		return $this->id;
	}
	
	/**
	 * @return Student
	 */
	public function getTutor()
	{
		return $this->tutor;
	}
	
	/**
	 * @param Student $tutor
	 * @return Student
	 */
	public function setTutor($tutor)
	{
		$this->tutor = $tutor;
	}
	
	
	public function hasTutor() 
	{
		return !is_null($this->Tutor); 
	}
}