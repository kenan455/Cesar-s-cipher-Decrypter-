<?php
function decrypt($str, $shift) {
    $decrypted_text = "";
    $shift = $shift % 26;
    if($shift < 0) {
        $shift += 26;
    }
    $i = 0;
    while($i < strlen($str)) {
        $c = strtolower($str{$i}); 
        if(($c >= "a") && ($c <= 'z')) {
            if((ord($c) - $shift) < ord("a")) {
                $decrypted_text .= chr(ord($c) - $shift + 26);
        } else {
            $decrypted_text .= chr(ord($c) - $shift);
        }
      } else {
          $decrypted_text .= chr(ord($c));
      } 

      $i++;
    }
    return $decrypted_text;
}

$shift = 1;

print ("This code is a solution for the challenge from codenation.dev/aceleradev/react-online-1.<br><br>The algorithm decrypts a text that i had taken at codenation's API. This text was encrypted with Cesar's cipher, more specifically with the shift 1. After this i encrypt it again using the sha1 algorithm!<br>");
echo '<br>';
echo '<br>';

$json = file_get_contents('https://api.codenation.dev/v1/challenge/dev-ps/generate-data?token=99503a9389cf2d260baac6737b2c3e080062ced9');

file_put_contents('answer.json',$json);
$objectResponse = json_decode($json);

$encryptedText = $objectResponse->cifrado;
print("Encrypted text:"." ".$encryptedText);
echo '<br>';
echo '<br>';


$decryptedText = decrypt($encryptedText, $shift);
echo ("Dencrypted text:"." ".$decryptedText);
echo '<br>';
echo '<br>';


$objectResponse->decifrado = $decryptedText ;

$encryptedSha1 = sha1($decryptedText);
echo "Text encrypted using SHA1:"." ".$encryptedSha1;
$objectResponse->resumo_criptografico = $encryptedSha1;
echo '<br>';
echo '<br>';


file_put_contents('answer.json', json_encode($objectResponse));

echo "Final answer:"." ".'<br>';
print_r($objectResponse);

?>