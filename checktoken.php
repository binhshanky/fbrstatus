<?
    $token = $_GET['token'];
    function isJson($string) {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
    if(isJson($token)){
        $data = json_decode($token,1);
        if(isset($data['access_token'])){
            echo $data['access_token'];
        } else {
            echo "Username and Password not correct";
        }
    }