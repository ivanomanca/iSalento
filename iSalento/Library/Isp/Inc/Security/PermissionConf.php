<?php
class Permission {
   //	Gestione utenza generale;
   // Approvazione ruoli inferiori;
	const ROOT = 0;

	//	Cancellazione; modifiche tecniche;
	// Approvazione ruoli inferiori;
	const ADMIN = 1;

	//	Pubblicazione senza approvazione;
	//	Modifica e approvazione pubblicazioni;
	//	Approvazione e pubblicazione feedback;
	//	Modifica ruoli inferiori;
	const STAFF = 2;

	// Servizi aggiuntivi (inserimento pagine! + altri da definire);
	const PARTNER = 3;

	// Pubblicazione sotto approvazione (strutture, foto, articoli);
	// Modifica solo sui dati inseriti personalmente;
	const REGISTERED = 4;

	// Lettura 100%;
	// Feedback privati per lo staff (e pubblicati sotto approvazione);
	const GUEST = 5;
}
?>