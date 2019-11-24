<?php
/** About us Page **/
require_once('Classes/PageCustomer.php');


$pageContent = <<<HERE
<h1 class="title">About quality cars</h1>
<p>
    Quality Cars is a fictional car selling company.
</p>

<p>
    This web application is developed by Basir Noutash for Assignment 2, class Web Application Development, , Semester 1 2010, Unitec NZ.
</p>

<h3>Acknowledgements:</h3>

<p>
Car pictures are from Wikimedia Commons:<br />
    <a href="http://commons.wikimedia.org/wiki/File:Audi-90-sedan.jpg">http://commons.wikimedia.org/wiki/File:Audi-90-sedan.jpg</a><br />
    <a href="http://commons.wikimedia.org/wiki/File:Mazda2_Sport.JPG">http://commons.wikimedia.org/wiki/File:Mazda2_Sport.JPG</a><br />

    <a href="http://commons.wikimedia.org/wiki/File:Keinath_C5.jpg">http://commons.wikimedia.org/wiki/File:Keinath_C5.jpg</a><br />
    <a href="http://commons.wikimedia.org/wiki/File:206cc.jpg">http://commons.wikimedia.org/wiki/File:206cc.jpg</a><br />
    <a href="http://commons.wikimedia.org/wiki/File:Hummer_HX_NY.jpg">http://commons.wikimedia.org/wiki/File:Hummer_HX_NY.jpg</a><br />
    <a href="http://commons.wikimedia.org/wiki/File:2007_Honda_Fit_5.JPG">http://commons.wikimedia.org/wiki/File:2007_Honda_Fit_5.JPG</a><br />
    <a href="http://commons.wikimedia.org/wiki/File:Peugeot_404_Familiale_1968.jpg">http://commons.wikimedia.org/wiki/File:Peugeot_404_Familiale_1968.jpg</a><br />
    <a href="http://commons.wikimedia.org/wiki/File:2nd-Infiniti-I30.jpg">http://commons.wikimedia.org/wiki/File:2nd-Infiniti-I30.jpg</a><br />

    <a href="http://commons.wikimedia.org/wiki/File:Riley_of_1930s_or_1940s.JPG">http://commons.wikimedia.org/wiki/File:Riley_of_1930s_or_1940s.JPG</a><br />
</p>



HERE;


$thePage = new pageCustomer('About | Quality Cars', 'About us', $pageContent);
echo $thePage->render();


?>