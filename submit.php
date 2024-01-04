<?php
// require('./include/config.php');

// echo '<pre>';
// \Stripe\Stripe::setVerifySslCerts(false);
// print_r($_POST);
// $token = $_POST['stripeToken'];
// var_dump($token);

// $token = isset($_POST['stripeToken']) ? $_POST['stripeToken'] : '';
// if (empty($token)) {
//     echo 'Error: Stripe token is missing.';
//     exit;
// }

// try {
//     $data = \Stripe\Charge::create(array(
//         "amount" => 5000,
//         "currency" => "inr",
//         "description" => "programming with me desc",
//         "source" => $token,
//     ));

//     // Output the charge details
//     echo '<pre>';
//     print_r($data);
// } catch (\Stripe\Exception\CardException $e) {
//     echo 'Card Error: ' . $e->getError()->message;
// } catch (\Stripe\Exception\RateLimitException $e) {
//     echo 'Rate Limit Error: ' . $e->getError()->message;
// } catch (\Stripe\Exception\InvalidRequestException $e) {
//     echo 'Invalid Request Error: ' . $e->getError()->message;
// } catch (\Stripe\Exception\AuthenticationException $e) {
//     echo 'Authentication Error: ' . $e->getError()->message;
// } catch (\Stripe\Exception\ApiConnectionException $e) {
//     echo 'API Connection Error: ' . $e->getError()->message;
// } catch (\Stripe\Exception\ApiErrorException $e) {
//     echo 'Stripe API Error: ' . $e->getError()->message;
// } catch (Exception $e) {
//     echo 'Error: ' . $e->getMessage();
// }
