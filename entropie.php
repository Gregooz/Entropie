<?php

if(isset($_GET['var1']) == True){

echo "<div align=center><table border="."1px". ">";

for($i=0;$i<5;$i++){
	$y=0;
	echo "<tr>";
	echo "<td>". "<a href=?var1=". $_GET['var1'] . "&var2=". $i.$y .">". $i.$y++ . "</a></td>";
	echo "<td>". "<a href=?var1=". $_GET['var1'] . "&var2=". $i.$y .">". $i.$y++ . "</a></td>";
	echo "<td>". "<a href=?var1=". $_GET['var1'] . "&var2=". $i.$y .">". $i.$y++ . "</a></td>";
	echo "<td>". "<a href=?var1=". $_GET['var1'] . "&var2=". $i.$y .">". $i.$y++ . "</a></td>";
	echo "<td>". "<a href=?var1=". $_GET['var1'] . "&var2=". $i.$y .">". $i.$y++ . "</a></td>";
	echo "</tr>";


}
echo "</table>";
}

else {
echo "<table border="."1px". ">";


for($i=0;$i<5;$i++){
	$y=0;
	echo "<tr>";
	echo "<td>". "<a href=". "?var1=". $i.$y . ">". $i.$y++ . "</a></td>";
	echo "<td>". "<a href=". "?var1=". $i.$y . ">". $i.$y++ . "</a></td>";
	echo "<td>". "<a href=". "?var1=". $i.$y . ">". $i.$y++ . "</a></td>";
	echo "<td>". "<a href=". "?var1=". $i.$y . ">". $i.$y++ . "</a></td>";
	echo "<td>". "<a href=". "?var1=". $i.$y . ">". $i.$y++ . "</a></td>";
	echo "</tr>";


}
echo "</table></div>";

}


?>