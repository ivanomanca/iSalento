<?php
/**
 * Classe padre dei Beans
 */
class Isp_Db_Beaner_Bean	{

	public $bean_ntt;		//entitˆ alla quale si riferisce il bean
	public $related_beans;	// beans correlati
    public $Lang;			// lingua con la quale viene settato il bean
	public $IDs;			// array degli id del bean
	public $beaner; 		// istanza del beaner

	public function __construct($bean_ntt, $r_beans, $Lang, $IDs, $from_ntt){
		// ricavo l'istanza del beaner
		$this->beaner = Isp_Db_Beaner::getInstance();

		//setto tutte le variabili di stato
		$this->IDs = $IDs;
		$this->Lang = $Lang;
		$this->bean_ntt = $bean_ntt;
		$this->related_beans = $r_beans;

		// istanzia l'oggettino principale
		$this->$bean_ntt = $this->beaner->build(	$this->Lang,
													$this->bean_ntt,
													$this->IDs,
													$from_ntt);

		// se si vuole il bean completo, allora produco anche i bean correlati
		if ($from_ntt == $bean_ntt) {
			$this->get_related();
		}
	}

	/**
	 * Funzione che ricava i beans correlati in base all'array
	 *
	 * @param array $related_beans
	 */
	private function get_related(){
		foreach ($this->related_beans as $bean_to_get){
			// istanzia la variabile del bean corrispondente

			$this->$bean_to_get = $this->beaner->build(	$this->Lang,
														$bean_to_get,
														$this->IDs,
														$this->bean_ntt);
		}
	}
}
