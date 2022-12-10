<?php


namespace HamyarSaz\core;


class whmcs
{
    public function getUID($user_id=null)
    {
      if (empty($user_id)){
          $user_id=get_current_user_id();
      }
      $whmcs_uid=get_user_meta($user_id,'whmcs_uid',true);
        if (empty($whmcs_uid)){
            $whmcs_uid=$this->createUser($user_id);
            if ($whmcs_uid->hasError()){
                hmyarsaz_set_error($whmcs_uid->getError());
                return false;
            }
        }
        return $whmcs_uid;
    }

    public function createUser($user_id)
    {
        $user=get_user_by('id',$user_id);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://dash.hamyar.test/includes/api.php');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
                    http_build_query(
                        array(
                            'action' => 'AddClient',
                            // See https://developers.whmcs.com/api/authentication
                            'username' => 'kPBXg5pmRt9DKJ98pXjFKjns5lQbrDc9',
                            'password' => '8RT2oWng7kuNaWTpivrdrrDHNswTuTQt',
                            'firstname' => 'sample',
                            'lastname' => 'sample',
                            'email' => "user{$user_id}@hamyar.localhost",
                            'address1' => 'tehran',
                            'city' => 'tehran',
                            'state' => 'tehran',
                            'postcode' => '1234',
                            'country' => 'US',
                            'phonenumber' => '9123456789',
                            'password2' => md5($user_id.'hamyarsaz'),
                            'clientip' => '',
                            'responsetype' => 'json',
                        )
                    )
        );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);
        $response=json_decode($response,true);
        if (isset($response['clientid'])){
            update_user_meta($user_id,'whmcs_uid',$response['clientid']);
        }
        $this->response=$response;
        return $this;
    }

    public function hasError()
    {
        if (isset($this->response['result']) && $this->response['result']=='error'){
            return true;
        }
        return false;
    }

    public function getError()
    {
        if (isset($this->response['message']) && !empty($this->response['message'])){
            return $this->response['message'];
        }
        return '';
    }
}