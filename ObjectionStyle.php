<?php

use Objection\Enum\AccessRestriction;
use Objection\LiteObject;
use Objection\LiteSetup;


require_once __DIR__ . '/vendor/autoload.php';


/**
 * @property string 	$Name
 * @property int		$Age
 * @property array		$Classes Name of classes where student study.
 * @property string 	$Id Personal unique ID.
 * @property Student	$Tutor Tutor of this student.
 */
class Student extends LiteObject 
{
	/**
	 * @return array
	 */
	protected function _setup()
	{
		return [
			'Name'		=> LiteSetup::createString(),
			'Age'		=> LiteSetup::createInt(),
			'Classes'	=> LiteSetup::createString([], AccessRestriction::NO_SET),
			
			// Readonly field.
			'Id'		=> LiteSetup::createString(AccessRestriction::NO_SET),
			
			'Tutor'		=> LiteSetup::createInstanceOf(Student::class)
		];
	}
	
	
	public function __construct($id)
	{
		parent::__construct();
		
		// _p -> Private/Protected access to restricted fields.
		// Because Id is NO_SET, it can't be modified directly
		$this->_p->Id = $id;
	}
	
	
	public function hasTutor() 
	{
		return !is_null($this->Tutor); 
	}
}


$student = new Student('312982');

$student->Name = 'Some Name';
$student->Classes = '';

// Note that type is changed according to Property type.
$student->Age = "35";
var_dump($student->Age);

// Event arrays
$student->Classes = "Biology 101";
var_dump($student->Classes);

// Also array returned as reference, so this will work
$student->Classes[] = "Math 201";
var_dump($student->Classes);


// Note the validation for instance type:
try {
	$student->Tutor = new \stdClass();
} catch (\Exception $e) {
	var_dump($e->getMessage());
}


var_dump($student->hasTutor());
$student->Tutor = new Student('3124123');
var_dump($student->hasTutor());