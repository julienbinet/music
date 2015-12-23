function ConfirmDelete(){

	var supr = confirm("Êtes-vous sûr de vouloir supprimer ?");
	console.log('valeur supr = ' + supr);
	if (supr)
		return true;
	else
		return false;

}