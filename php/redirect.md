# 重定向

1. I don’t really care about redirecting the user. I just want to forward the POST data.

curl
```php
<?php

//The names of the POST variables that we want to send
//to the external website.
$postVars = array('name', 'email', 'dob');

//An array to hold the data that we'll end up sending.
//Empty by default.
$postData = array();

//Attemp to find the POST variables that we want to send.
foreach($postVars as $name){
    if(isset($_POST[$name])){
        $postData[$name] = $_POST[$name];
    }
}

//Setup cURL
$ch = curl_init();

//The site we'll be sending the POST data to.
curl_setopt($ch, CURLOPT_URL, "http://example.com");

//Tell cURL that we want to send a POST request.
curl_setopt($ch, CURLOPT_POST, 1);

//Attach our POST data.
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

//Tell cURL that we want to receive the response that the site
//gives us after it receives our request.
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//Finally, send the request.
$response = curl_exec($ch);

//Close the cURL session
curl_close($ch);

//Do whatever you want to do with the output.
echo $response;
```

2. No. I need to make sure that the user is redirected.

visiable form

```php
<?php
$name = isset($_POST['name']) ? $_POST['name'] : null;
$email = isset($_POST['email']) ? $_POST['email'] : null;
$etc = isset($_POST['etc']) ? $_POST['etc'] : null;
?>

<form id="my_form" action="http://example.com" method="post">
    <input type="hidden" name="name" value="<?php echo htmlspecialchars($name); ?>">
    <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
    <input type="hidden" name="etc" value="<?php echo htmlspecialchars($etc); ?>">
    <input type="submit" name="submission_button" value="Click here if the site is taking too long to redirect!">
</form>

<script type="text/javascript">
    function submitForm() {
        document.getElementById('my_form').submit();
    }
    window.onload = submitForm;
</script>
```

reference: [PHP – Redirecting A Form With POST Variables](http://thisinterestsme.com/php-redirecting-a-form-with-post-variables/)


