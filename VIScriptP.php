<?php

class Patient {
    /* Member variables */
    private $patient_id;
    private $patient_name;
    private $patient_sex;
    private $patient_dob;
    public $patient_firstandlast_name;
    
    
    /* Member functions */
    function setPatientData($row_data) {
        $this->patient_id = $row_data[0];
        $this->patient_name = $row_data[1];
        $this->patient_sex = $row_data[2];
        $this->patient_dob = $row_data[3];
    }
    
    function showPatientData() {
        return(get_object_vars($this));
    }
    
    function group_assoc($array, $key) {
        $return = array();
        foreach($array as $v) {
            $return[$v[$key]][] = $v;
        }
        return $return;
    }
}

if (PHP_SAPI === 'cli') {
    $fileName = $argv[1];
}
else {
    $fileName = $_GET['fileName'];
}
$txt_file    = file_get_contents($fileName);
$rows        = explode("\n", $txt_file);


//$patientObjArray[count($rows)] = array();

foreach($rows as $row => $data) {
    //get row data
    $row_data = explode(',', $data);
    $patient_name = $row_data[1];
    $name_split = explode("^",strtoupper($patient_name));
    unset($name_split[2]);
    $name_first_and_last = implode(" ", $name_split);
    $patientObjs[$row] = new Patient;
    $patientObjs[$row]->setPatientData($row_data);
    $patientObjs[$row]->patient_firstandlast_name = $name_first_and_last;
}

foreach($patientObjs as $row => $patientObj){
    $patientObjArray[$row] = $patientObj->showPatientData();
}

//Group the patients by their names
$group_info = group_assoc($patientObjArray, 'patient_firstandlast_name');
$group_info_result = array_values($group_info);

print_r($group_info_result);

//print_r($patientObjArray);
//var_dump($patientObjs);
//print_r(get_object_vars($patientObjs[1]));
//$patientObjs[1]->showPatientData();
exit;

if (PHP_SAPI === 'cli') {
    $fileName = $argv[1];
}
else {
    $fileName = $_GET['fileName'];
}

$txt_file    = file_get_contents($fileName);
$rows        = explode("\n", $txt_file);

$info       = parse_to_array($rows);

print_r($info);
echo '<br />';



function group_assoc($array, $key) {
    $return = array();
    foreach($array as $v) {
        $return[$v[$key]][] = $v;
    }
    return $return;
}


function parse_to_array($rows) {
    
    foreach($rows as $row => $data)
    {
        //get row data
        $row_data = explode(',', $data);
        $patient_name = $row_data[1];
        $name_split = explode("^",strtoupper($patient_name));
        unset($name_split[2]);
        $name_first_and_last = implode(" ", $name_split);

        $info[$row]['patient_id']           = $row_data[0];
        $info[$row]['patient_name']         = $patient_name;
        $info[$row]['patient_sex']          = $row_data[2];
        $info[$row]['patient_dob']          = $row_data[3];
        $info[$row]['name_first_and_last']   = $name_first_and_last;

    /*    //display data
        echo 'Row ' . $row . ' Id: ' . $info[$row]['patient_id'] . '<br />';
        echo 'Row ' . $row . ' Name: ' . $info[$row]['patient_name'] . '<br />';
        echo 'Row ' . $row . ' Sex: ' . $info[$row]['patient_sex'] . '<br />';
        echo 'Row ' . $row . ' DOB: ' . $info[$row]['patient_dob'] . '<br />';


        echo '<br />'; */
    }
    return $info;
}


//Group the requests by their account_id
$group_info = group_assoc($info, 'name_first_and_last');
$group_info2 = array_values($group_info);

print_r($group_info2);

?>