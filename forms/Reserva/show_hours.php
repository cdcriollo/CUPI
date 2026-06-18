<?php
function getSelectTimer()
{
	
	$horas = 10;
	$min="00";
	echo '<option value="07:00:00">07:00</option>';
	echo '<option value="07:30:00">07:30</option>';
	echo '<option value="08:00:00">08:00</option>';
	echo '<option value="08:30:00">08:30</option>';
	echo '<option value="09:00:00">09:00</option>';
	echo '<option value="09:30:00">09:30</option>';
	
	
	while($horas < 24)
	{?>		
		
			<option value="<?php echo $horas.':00'.':00' ?>"><?php echo $horas.':00' ?></option>

           <option value="<?php echo $horas.':30'.':00' ?>"><?php echo $horas.':30' ?></option>
          
           <?php 
		   
		   $horas++;	
          
		 
		 
	}
}

?>