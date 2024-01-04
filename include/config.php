<?php
require('./include/stripe-php-master/init.php');

$publishable_key = "pk_test_51ONBaqLU1sr7cVCEay81WOQU5EAlLVxoh5no4773KTCXcuttYApeaiOTNI0BN96jd1nlwRUPoCWjisi271Zm3vcf00g3GfjoPs";
$secret_key = "sk_test_51ONBaqLU1sr7cVCEACStJbjqnvSOQjPoxKQ5CsSOLxrwhnKX18BbVSlMYyXiYa01BDzRjLLD8ARYiTB9yeboWmn000trp5z8Rj";

\Stripe\Stripe::setApiKey($secret_key);