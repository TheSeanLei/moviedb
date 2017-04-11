<?php
class ticket_class{
	#properties
	private $id;
	private $received;
	private $senderName;
	private $senderEmail;
	private $subject;
	private $description;
	private $tech;
	private $status;
	
	#constructor
	public function __construct($id, $received, $senderName, $senderEmail, $subject, $description, $tech, $status) {
    $this->id = $id;
	$this->received = $received;
	$this->senderName = $senderName;
	$this->senderEmail = $senderEmail;
	$this->subject = $subject;
	$this->description = $description;
	$this->tech = $tech;
	$this->status = $status;
  }
	
	#method declaration	
	#getter
    public function __get($property) {
		if (property_exists($this, $property)) {
			return $this->$property;
			}
		}
	#setter
	public function __set($property, $value) {
		if (property_exists($this, $property)) {
			$this->$property = $value;
		}
		return $this;
	}
}

?>