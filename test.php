<?php  

function notify($user_mobile_info)
{
    $result = -1; //Initialize default

    $pem_preference = "production";
    $device_type = $user_mobile_info['user_device_type'];
    $registration_ids = $user_mobile_info['user_mobile_token'];

    if ($device_type == "Android") {
        // API access key from Google API's Console
        define('API_ACCESS_KEY', ADD_YOUR_SERVER_KEY_HERE);

        $headers = array
        (
            'Authorization: key=' . API_ACCESS_KEY,
            'Content-Type: application/json'
        );

        $message = array
        (
            'title' => 'This is a title. title',
			'body' => ADD_YOUR_CUSTOM_MESSAGE_HERE,
            'subtitle' => 'This is a subtitle. subtitle',
            'tickerText' => 'Ticker text here...Ticker text here...',
            'vibrate' => 1,
            'sound' => 1,
            'largeIcon' => 'large_icon',
            'smallIcon' => 'small_icon'
        );

        $fields = array
        (
            'registration_ids' => array($registration_ids),
            'notification' => $message
        );
      
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, false );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        
        $result = curl_exec($ch);
        curl_close($ch);
    }
    return $result > 0;
}

$user_mobile_info = [
    'user_device_type'=>"Android", 
    'user_mobile_token'=> ADD_YOUR_DEVICE_TOKEN_HERE
];
notify($user_mobile_info);

?>
