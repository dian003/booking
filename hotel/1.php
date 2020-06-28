<?php
error_reporting(0);
use Twlve\Bookingcom\Booking;

require 'vendor/autoload.php';

$booking = new Booking();
$hotels  = ['3326463', '4984319'];

echo "\n[*] Register";
echo "\n------------------\n";

echo "[+] File Email : ";
$fileakun = trim(fgets(STDIN));
$password = "Dianmaho123";


print PHP_EOL."Total Ada : ".count(explode("\r", @file_get_contents($fileakun)))." Akun ".PHP_EOL."Letsgo..";
        $time = date("Y-m-d H:i:s");
    //    echo PHP_EOL."Start : ".$time;
   //     foreach(@explode("\n", @file_get_contents($fileakun)) as $c => $email)
$dian_data=file_get_contents($fileakun);
$dian_ex = explode("\n", str_replace("\r", "\n", $dian_data));
$dian_count = count($dian_ex);
for($i=0;$i<$dian_count;$i++) 
        {  
            //echo $dian_ex[$i];
            $email = $dian_ex[$i];
echo "\n[*] Ekse Akun : $email";
$register = $booking->register($email, "Dianmaho123");
if (!$register->success) {
    checkConnection($register);
    echo "\n[!] ERROR REGISTER : " . $register->error_message . "\n";
$booking->logout();

if($register->error_message == "Authentication token is invalid, please login."){
    die();
} else {
 delete_email($fileakun,$email);    
}
}

echo "\n[*] Register Success | {$email} : {$password}\n";

echo "\n[*] Claim Reward";

$booking->setAuthToken($register->data->auth_token);
$createWishList = $booking->createWishList();

if (!$createWishList->success) {
    checkConnection($createWishList);
    echo "\n\n[!] ERROR : " . $createWishList->error_message . "\n";
    // die();
}

foreach ($hotels as $hotel) {
    $saveWishList = $booking->saveWishList($createWishList->data->id, $hotel);
    if (!$saveWishList->success) {
        checkConnection($saveWishList);
        echo "\n\n[!] ERROR : " . $saveWishList->error_message . "\n";
       // die();
    }

    if ($saveWishList->data->gta_add_three_items_campaign_status->status == 'reward_given_wallet') {
        echo "\n\n[*] " . $saveWishList->data->gta_add_three_items_campaign_status->modal_body_text . "\n";
        echo "[*] " . $saveWishList->data->gta_add_three_items_campaign_status->modal_header_text . "\n";

        echo "\n[*] Logout\n";
        $logout = $booking->logout();
        delete_email($fileakun,$dian_ex[$i]);
       // die();
    }
    
}

}
function checkConnection($data)
{
    if (strtolower($data->error_message) == 'no connection') {
        echo "\n\n";
        echo "[!] ERROR : " . $data->error_message . "\n";
        echo " ______     ________ ______     ________ _ _ _ \n";
        echo "|  _ \ \   / /  ____|  _ \ \   / /  ____| | | |\n";
        echo "| |_) \ \_/ /| |__  | |_) \ \_/ /| |__  | | | |\n";
        echo "|  _ < \   / |  __| |  _ < \   / |  __| | | | |\n";
        echo "| |_) | | |  | |____| |_) | | |  | |____|_|_|_|\n";
        echo "|____/  |_|  |______|____/  |_|  |______(_|_|_)\n";
        echo "  _____ _    _ _    _ _______ _____   ______          ___   _ _ _ _ \n";
        echo " / ____| |  | | |  | |__   __|  __ \ / __ \ \        / / \ | | | | |\n";
        echo "| (___ | |__| | |  | |  | |  | |  | | |  | \ \  /\  / /|  \| | | | |\n";
        echo " \___ \|  __  | |  | |  | |  | |  | | |  | |\ \/  \/ / | . ` | | | |\n";
        echo " ____) | |  | | |__| |  | |  | |__| | |__| | \  /\  /  | |\  |_|_|_|\n";
        echo "|_____/|_|  |_|\____/   |_|  |_____/ \____/   \/  \/   |_| \_(_|_|_)\n";
        sleep(2);
        die();
    }
}

function delete_email($file,$email)
{
    $contents = file_get_contents($file);
$new_contents= "";
if( strpos($contents, $email) !== false) { // if file contains ID
    $contents_array = preg_split("/\\r\\n|\\r|\\n/", $contents);
    foreach ($contents_array as &$record) {    // for each line
        if (strpos($record, $email) !== false) { // if we have found the correct line
          //  pass; // we've found the line to delete - so don't add it to the new contents.
        }else{
            $new_contents .= $record . "\r"; // not the correct line, so we keep it
        }
    }
    file_put_contents($file, $new_contents); // save the records to the file
    echo "\n[!]Sucksess : Delete Email Di File";
}
}
