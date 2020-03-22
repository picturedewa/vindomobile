<?php
class Fcmessage {

    private $api_key;
    private $message;
    private $registration_ids;
    const SERVER_GCM = "https://fcm.googleapis.com/fcm/send";

    function set_api_key($api_key) {
        $this->api_key = $api_key;
        return $this;
    }

    public function addMsg($registrantId=[], $msg="") {
        $this->message = $msg;
        $this->registrantId = $registrantId;
        return $this;
    }

    public function addMsg_baru($topik,$msg=""){
        $this->message=$msg;
        $this->datatopic=$topik;
        return $this;
    }


    public function sentMessage() {
        $fields = ['registration_ids'=> $this->registrantId,'data'=> $this->message]; 
        // //$fields = ['data'  => $this->message];        
        $headers = ['Authorization: key=' . $this->api_key,'Content-Type: application/json'];         
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, Fcmessage::SERVER_GCM );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        curl_close( $ch );
                // echo "<pre>";
                // print_r($fields);
                // echo "<pre>";
                // return true;
         return $result;
    }


    public function sentMessage_baru() {
        $fields = ['to' => $this->datatopic, 'data'  => $this->message]; 
        // //$fields = ['data'  => $this->message];        
        $headers = ['Authorization: key=' . $this->api_key,'Content-Type: application/json'];         
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, Fcmessage::SERVER_GCM );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        curl_close( $ch );
                // echo "<pre>";
                // print_r($resilt);
                // echo "<pre>";
                // return true;
         return $result;
    }
}