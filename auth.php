<?php
$instagramConfig = json_decode(file_get_contents(__DIR__ . '/conf/instagram.json'));


//sending instagram account holder to instagram for authentication
?>
<a href="https://api.instagram.com/oauth/authorize/?client_id=<?php echo $instagramConfig->Client_ID?>&redirect_uri=<?php echo $instagramConfig->Redirect_Url; ?>&response_type=code&scope=public_content">Authenticate</a>