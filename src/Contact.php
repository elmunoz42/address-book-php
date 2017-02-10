<?php
class Contact
{
    private $name;
    private $phone_number;
    private $address;

    function __construct($name_input, $phone_number_input, $address_input)
    {
        $this->name = $name_input;
        $this->$phone_number = $phone_number_input;
        $this->$address = $address_input;
    }
    function setName($new_name)
    {
        $this->name = (string) $new_name;
    }
    function getName()
    {
        return $this->name;
    }
    function setPhoneNumber($new_phone_number)
    {
        $this->$phone_number = $new_phone_number;
    }
    function getPhoneNumber()
    {
        return $this->phone_number;
    }
    function setAddress($new_address)
    {
        $this->address = $new_address;
    }
    function getAddress()
    {
        return $this->$address;
    }
    function save()
    {
        array_push($_SESSION['list_of_contacts'], $this);
    }
    static function getAll()
    {
        return $_SESSION['list_of_contacts'];
    }
    static function deleteAll()
    {
        $_SESSION['list_of_contacts'] = array();
    }
}
?>
