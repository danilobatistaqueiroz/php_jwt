<?php

require_once ('../vendor/autoload.php');
use \Firebase\JWT\JWT;

$tokVal = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJpYXQiOjE1MTE4ODkzMTQsImp0aSI6IlRZVFwvUnZsemMyMGZUa1FUXC9qMjAzYlZuemlpZjlMckNcL29VdkxaYkx0MGc9IiwiaXNzIjoiaHR0cDpcL1wvbG9jYWxob3N0OjgwODJcL3BocC1qc29uXC8iLCJuYmYiOjE1MTE4ODkzMjQsImV4cCI6MTUxMTg5NjUyNCwiZGF0YSI6eyJpZCI6MSwibmFtZSI6ImRhbmlsbyJ9fQ.l1Sdd9GrlucFu4RuiO5R-AkbaRR2AFLoSvMux87Igum7u5dms3zNgpkXzduMS73X3LS8iEkCUqiEsWmQaE68qw";
$secretKey = base64_decode('Your-Secret-Key'); 
$ALGORITHM = 'HS512';

$DecodedDataArray = JWT::decode($tokVal, $secretKey, array($ALGORITHM));

echo  "{'status' : 'success' ,'data':".json_encode($DecodedDataArray)." }";die();