<?php
/** Home Page **/
require_once('Classes/PageCustomer.php');


$pageContent = <<<HERE
<h1 class="title">Welcome to quality cars</h1>

<p>
	Quality Cars is a car selling company.
</p>

<p>
	Unfortunately in this version of our web application, we don not provide search features so your only options is to list all the available cars by clicking Catalog menu above.
</p>
<p>
	You can order an unlimited number of the cars you can find in our catalog. 
	We never run out of cars!
</p>
<p>

	And surprisingly you don not  have to pay on this website when you order.
	However we do ask you register and be logged in when you place any order.
</p>
<p>
	We don not care if you give your real details when you register so if you do not
	like to give your real details, feel free to go ahead and make something up.
</p>
<p>
	So what are you waiting for?
</p>


HERE;


$thePage = new pageCustomer('Home | Quality Cars', 'Home', $pageContent);
echo $thePage->render();


?>