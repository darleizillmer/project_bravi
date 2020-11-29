<?php

$baseApi = "http://localhost:3000/v1/";

function callAPI($type, $uri, $data){
    $curl = curl_init();
    switch ($type){
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);                              
            break;
        case "DELETE":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        default:
            if ($data)
                $uri = sprintf("%s?%s", $uri, http_build_query($data));
    }
    // OPTIONS:
    curl_setopt($curl, CURLOPT_URL, $uri);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
       'Api-Token: 80ed01f7ef2e4e538a6d24e50088495f',
       'Content-Type: application/json',
    ));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    // EXECUTA:
    $result = curl_exec($curl);
   
    $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
   
    if(in_array($httpcode, array(500, 404))){
       die("Connection Failure");
    }
    curl_close($curl);
    return $result;
}

$action = $_POST['action'];
$person = isset($_POST['person']) ? $_POST['person'] : 0;
$name   = isset($_POST['name']) ? $_POST['name'] : '';
$contact = isset($_POST['contact']) ? $_POST['contact'] : '';
$email   = isset($_POST['email']) ? $_POST['email'] : '';
$phone   = isset($_POST['phone']) ? $_POST['phone'] : '';
$whats   = isset($_POST['whats']) ? $_POST['whats'] : '';

// Pessoas
if ($action == 'getAllPerson'){
    $uri = $baseApi . 'person';
    $result = callAPI('GET', $uri, false);
}
else if ($action == 'getPerson'){
    $uri = $baseApi . 'person/' . $person;
    $result = callAPI('GET', $uri, false);
}
else if ($action == 'addPerson'){
    $uri = $baseApi . 'person';
    $data = json_encode(array('name' => $name));
    $result = callAPI('POST', $uri, $data);
}
else if ($action == 'putPerson'){
    $uri = $baseApi . 'person/' . $person;
    $data = json_encode(array('name' => $name));
    $result = callAPI('PUT', $uri, $data);
}
else if ($action == 'deletePerson'){
    $uri = $baseApi . 'person/' . $person;
    $result = callAPI('DELETE', $uri, false);
}
// Contatos
else if ($action == 'getAllContact'){
    $uri = $baseApi . 'contact/'.$person;
    $result = callAPI('GET', $uri, false);
}
else if ($action == 'getContact'){
    $uri = $baseApi . 'contact/unique/' . $contact;
    $result = callAPI('GET', $uri, false);
}
else if ($action == 'addContact'){
    $uri = $baseApi . 'contact';
    $data = json_encode(array('id_person' => $person,
                              'email'     => $email,
                              'phone_number' => $phone,
                              'whatsapp_number' => $whats));
    $result = callAPI('POST', $uri, $data);
}
else if ($action == 'putContact'){
    $uri = $baseApi . 'contact/' . $contact;
    $data = json_encode(array('id_person' => $person,
                              'email'     => $email,
                              'phone_number' => $phone,
                              'whatsapp_number' => $whats));
    $result = callAPI('PUT', $uri, $data);
}
else if ($action == 'deleteContact'){
    $uri = $baseApi . 'contact/' . $contact;
    $result = callAPI('DELETE', $uri, false);
}
echo $result;