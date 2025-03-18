<?php

define('DIA',array('domingo','lunes','martes','miércoles','jueves','viernes','sábado'));

function price($value){
   return number_format($value,2).' $';
}
//esto se crea nuevo para definir los dias
