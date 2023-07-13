<?php
$expr = '1+2*9-2/2*(1*2)+(7*2)';
$expr = preg_replace('/[^\s0-9\(\)\+\-\*\/]/u', '', $expr);
$result = @eval("return $expr;");
if ($result !== false) {
	echo $result;
} else {
	echo 'ERROR!';
}