<?php
/**
 * Clase: soporteWS
 * 
 * Autor: Orlando Brea
 * 
 * Descripcion: Metodos de ayuda para poder trabajar con WebServices
 *              permite convertir un objeto en un vector o un vector
 *              de objetos en un vector de vector.
 *              
 * Uso: Crear una instancia de la clase y luego llamar a convertirAVectorParaWS 
 *      pasando como parametro el objeto/vector de objetos que uno quiere convertir.
 *      
 * Importante: Al convertir un objeto, utiliza los nombres de las variables como llaves (keys)
 *             del vector.
 *             
 */
class SoporteWS {
	/**
	 * Convierte el objeto pasado como parametro a un vector para poder ser
	 * retornado por un webservice
	 */
	public function convertirAVectorParaWS($elementoAConvertir) {
		if (is_array($elementoAConvertir))
			return $this->vectorAVectorDeObjetos($elementoAConvertir);
		else
			return $this->objetoAVector($elementoAConvertir);
	}
	public function convertirDeVectorDesdeWS($vector, $nombreClaseObjeto) {
		if (is_array($vector[0])) {
			return $this->convertirVectorDeVectorAObjeto($vector, $nombreClaseObjeto);
		} else {
			return $this->convertirVectorAObjeto($vector, $nombreClaseObjeto);
		}
	}
	
	
	/**
	 * Convierte un vector en objeto (las llaves, keys, del vector deben corresponder
	 * con el nombre de las propiedades del objeto)
	 * @param object $vector vector de entrada
	 * @param object $nombreClaseObjeto nombre de la clase del objeto al cual se le deben
	 *                					asignar los valores del vector
	 * @return objeto con las propiedades asignadas con los valores del vector
	 */
	function convertirVectorAObjeto($vector, $nombreClaseObjeto) {
		$objRespuesta = new $nombreClaseObjeto();
		foreach ($vector as $key => $value) {
			$objRespuesta->$key = $value;
		}
		return $objRespuesta;
	}
	
	/**
	 * Convierte un vector de vector, en un vector de objetos
	 * @param object $vector
	 * @param object $nombreClaseObjeto
	 * @return vector de objetos
	 */
	function convertirVectorDeVectorAObjeto($vector, $nombreClaseObjeto) {
		$vectorRespuesta = array();
		foreach ($vector as $key => $value) {
			$vectorRespuesta[$key] = $this->convertirVectorAObjeto($value, $nombreClaseObjeto);
		}
		return $vectorRespuesta;		
	}
	
	
	function objetoAVector($objeto) {
		$nombreClase = get_class($objeto);
		$rta = get_class_vars($nombreClase);
		foreach ($rta as $key => $value) {
			$rta[$key] = $objeto->$key;
		}
		return $rta;
	}
	function vectorAVectorDeObjetos($vector) {
		$rta = array();
		foreach ($vector as $key => $value) {
			$rta[$key] = $this->objetoAVector($value);
		}
		return $rta;
	}
}

?>