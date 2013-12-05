<html>

<script languaje = "javascript" > 
// verificar si viene un ancla 
if (document.location.hash != "") 
{    
 var elemento = document.location.hash.replace("#",""); 
 document.getElementById(elemento). style.color= '#fff'; 
} 
<body>
<div id=elemento>hola</div>
</body>
</html>