
<?php
/**
 * Simple trait to use JSON like parameters from specified field in Laravel models
 * 
 * @author   Kirill Calkin <hello@nonamez.name>
 * @license  Beerware
 */
namespace App\Traits\Eloquent;

trait JSONParameters
{
	protected $parameters_field_name = 'parameters';

	public function getParameter($param, $default = NULL)
	{
		$parameters = (array) json_decode($this->{$this->parameters_field_name}, TRUE);
		
		$value = array_get($parameters, $param, $default);

		return $value;
	}
	
	public function setParameter($param, $value, $save = TRUE)
	{
		$parameters = json_decode($this->{$this->parameters_field_name}, TRUE);
		
		$parameters[$param] = $value;
		
		$this->{$this->parameters_field_name} = json_encode($parameters);
		
		if ($save) {
			$this->save();
		}
	}
	public function unsetParameter($param, $save = TRUE)
	{
		$parameters = json_decode($this->{$this->parameters_field_name}, TRUE);

		unset($parameters[$param]);
		
		$this->{$this->parameters_field_name} = json_encode($parameters);
		
		if ($save) {
			$this->save();
		}
	}
	
	public function setParameters(array $params, $save = TRUE)
	{
		$parameters = (array) json_decode($this->{$this->parameters_field_name}, TRUE);
		
		$parameters = array_merge($parameters, $params);
		
		$this->{$this->parameters_field_name} = json_encode($parameters);
		
		if ($save) {
			$this->save();
		}
	}
	
	public function incrementParameter($param, $save = TRUE)
	{
		$value = (int) $this->getParameter($param);
		
		$value++;
		
		$this->setParameter($param, $value, $save);
	}
}