function checkVar(e){
	e.preventDefault();
	for (var i = 0; i < 9; i++) {
		var1 = document.getElementById("val_"+i);
		var2 = document.getElementById("val_"+(i+1));
		if(var1.value.length != 0 && var2.value.length != 0){
			if(parseInt(var1.value) < parseInt(var2.value)){

			}
			else{
				alert('Checkear los valores ingresados');
				return false;
			}
		}
		else{

		}
	}
	document.getElementById("variants").submit();
	return true;
}