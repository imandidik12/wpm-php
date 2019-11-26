#WPM-PHP

This is php package for calculating Weigthed product model for php.

<h1>
Please use this if you already know what WPM.
</h1>

How to use : 
<ol>
<li>
<strong>
Make an alternatives in a multidimensional array
</strong>
<div>
$dataset1 = [<br/>[42,66006,60,75,2.355],<br/>[50,90000,72,60,1.421],<br/>[63,91500,65,80,2.585]<br/>];<br>
$alternatives = [<br/>'A1'=>$dataset[0],<br/>'A2'=>$dataset[1],<br/>'A3'=>$dataset[2]<br/>];
</div>
</li>
<li>
<strong>
Make the recommedation preferences values for all the alternatives
</strong>
<div>
$wp = [5, 3, 4, 4, 2];
</div>
</li>
</ol> 