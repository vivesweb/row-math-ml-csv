<?php
/** col_math_ml_csv
 *  
 * Class for manage cols structures in csv's
 * 
 * Used normally for Neural Networks, Deep learning, Machine learning, Intelligence Artificial, ....
 *
 * 
 * @author Rafael Martin Soto
 * @author {@link https://www.inatica.com/ Inatica}
 * @blog {@link https://rafamartin10.blogspot.com/ Blog Rafael Martin Soto}
 * @since September 2021
 * @version 1.0.0
 * @license GNU General Public License v3.0
 * 
 * @param mixed $value // Value of col
*/

class col_math_ml_csv
{
	private $col_value			= null;
	private $col_numeric_value	= null;
	private $structure 			= [ 'empty' => false, 'empty_null' => false, 'empty_nan' => false, 'empty_anyway' => false, 'string' => false, 'ip' => false, 'date' => false, 'numeric' => false, 'zero' => false, 'str_with_commas' => false, 'positive' => false, 'negative' => false, 'float' => false, 'integer' => false ];
	
	private $array_nan 			= array( 'na', 'nan');
	
	private $array_empty 		= array( '', '-'); // It takes into account if the value is empty or has a dash '-'. In any case it will be understood as empty

	private $do_struct			 = true;
	
    public function __construct( $value = null, $do_struct = true ) {
		$this->do_struct = $do_struct;

		if( isset($value) && !is_null($value) ){
        	$this->set_value_struct( $value );
        }
	} // / __construct
    
    
    
	/**
	 * Set value & structure
	 *
	 * @param mixed $value
	 */
    public function set_value_struct( $value ) {
		// Set value cleaned
        $this->col_value = $this->clean_str( (string)$value );
		
		// Set Structure
		$this->set_arr_struct( );
	} // / set_value_struct()
    
    
    
	/**
	 * Set do_struct
	 *
	 * @param boolean  $do_struct
	 */
    public function set_do_struct( $do_struct = true ) {
		$this->do_struct = $do_struct;
	} // / set_do_struct()
    
    
    
	/**
	 * Set Array structure
	 */
    private function set_arr_struct( ) {
		if( !$this->do_struct ) return;

		$data_value = $this->col_value;
		
		// Init 'empty_anyway'. Ensure to have at first of array 'empty_anyway'
		// On loops to see the values, we need first if is 'empty_anyway' | 'str_with_commas'
		$this->structure['empty_anyway']	= false; // !!! DON'T TOUCH !!!. Need to be initialized at the beginning for priority over individually empty!!!!
		$this->structure['str_with_commas']	= false; // !!! DON'T TOUCH !!!. Need to be initialized at the beginning for priority individually strings!!!!
		
		$this->structure['numeric'] 		= is_numeric( $data_value );
		
		if( $this->structure['numeric'] ){
			$strval_data_value = strval( $data_value );
			
			$this->structure['zero'] 		= ( $strval_data_value == 0 );
			$this->structure['postive'] 	= ( $strval_data_value > 0 );
			$this->structure['negative'] 	= ( $strval_data_value < 0 );
			$this->structure['integer']     = ((int) $data_value == (float)$data_value);
			$this->structure['float'] 		= !$this->structure['integer'];
		}
		
		$this->structure['string'] 			= !$this->structure['numeric'];
		
		if( $this->structure['string'] ){
			// string types. Can by empty, empty_nan, empty_null, IP, Date or String
			$this->structure['postive'] = $this->structure['negative'] = $this->structure['float'] = $this->structure['integer'] = $this->structure['zero'] = false;
			
			$this->structure['empty'] 		= (  in_array($data_value, $this->array_empty)  );
			$this->structure['empty_nan'] 	= (  in_array($data_value, $this->array_nan)  );
			$this->structure['empty_null'] 	= ( $data_value == 'null' || is_null($data_value) );
			
			$this->structure['empty_anyway']	= $this->value_is_empty_anyway( );
			
			if( !$this->structure['empty_anyway'] ){
				// Have some Value. Can be String, IP or Date
				$ip = ip2long($data_value);
				$this->structure['ip']		= ($ip !== false && $ip != -1);
				
				if( $this->structure['ip'] ){
					// Is IP field, then is not string or Date field
					$this->structure['string'] = $this->structure['str_with_commas']  = $this->structure['date'] = false;
				} else {
					// Can be Date
					$this->structure['date'] 	= $this->is_date( $data_value );
					if( $this->structure['date'] ) {
						// Is Date field, then is not string field
						$this->structure['string'] = $this->structure['str_with_commas'] = false;
					} else {
						// Is String
						
						// Check if String has commas
						$this->structure['str_with_commas'] = (strpos($data_value, ',') !== false);					
					}
				}
				
			} else {
				// Is empty. Then cannot be IP or Date or String
				$this->structure['ip'] = $this->structure['date'] =  $this->structure['string'] = $this->structure['str_with_commas'] = false;
			}
		} else {
			// Is number. Cannot Be empty, empty_nan, empty_null, empty_anyway, IP, Date or String (Note. 'string' & 'str_with_commas' is setted before)
			$this->col_numeric_value =  (($this->structure['integer'])?intval($data_value):floatval($data_value));
			$this->structure['ip'] = $this->structure['date'] = $this->structure['empty'] = $this->structure['empty_nan'] = $this->structure['empty_null'] = $this->structure['empty_anyway'] = false;
		}
	} // / set_arr_struct()
	
	
	
	/**
	* Get if a value struct is Empty Anyway ('', 'na', 'nan', null, 'null')
	*
	* @return boolean true|false
	*/
    private function value_is_empty_anyway(  ){
		return ( $this->structure['empty'] || $this->structure['empty_nan'] || $this->structure['empty_null']);
	} // value_is_empty_anyway()
	
	
	
	/**
	* Get col_value in numeric format
	*
	* @return mixed $col_numeric_value
	*/
    public function numeric_value( ){
		return $this->col_numeric_value;
	} // numeric_value()
	
	
	
	/**
	* Get col_value in numeric format. Is synonymous of numeric_value( )
	*
	* @return mixed $this->numeric_value()
	*/
    public function numeric_val( ){
		return $this->numeric_value();
	} // numeric_value()
	
	
	
	/**
	* Get boolean propertie of param col struct by id & param name
	* Ex. is('numeric'), is('date'),  is('ip'), is('empty_null'), is('empty_anyway'), ....
	*
	* @param int $id_col
	* @param string $param_name // see $this->structure for properties availables
	* @return boolean true|false
	*/
    public function is( $param_name ){
		return $this->structure[$param_name];
	} // is()
	
	
	
	/**
	* Get type propertie col struct state of id
	*
	* Be careful.
	* For empty values ['' | 'null' | null | 'na' | 'nan'], it will return 'empty_anyway'
	* For strings it will return 'str_with_commas' if is string and includes commas or otherwise return 'string'
	* To see if it is a concrete type, use the is () method instead
	*
	* @return string $type // see $this->structure for properties availables
	*/
    public function type( ){
		$type = '';
		
		foreach( $this->structure as $key_type => $value_is_true){
			if( $value_is_true ){
				$type = $key_type;
				break; // Exit foreach
			}
		} // /foreach key param
		
		return $type;
	} // type()
	
	
	
	/**
	* Get string array of true col properties
	*
	* @return array $arr_true_properties
	*/
    public function arr_true_properties( ){
		$arr_true_properties = [];
		
		foreach( $this->structure as $key_type => $value_is_true){
			if( $value_is_true ){
				$arr_true_properties[] = $key_type;
			}
		} // /foreach key propertie
		
		return $arr_true_properties;
	} // arr_true_properties()
	
	
	
	/**
	* Get array properties
	*
	* @return array $structure
	*/
    public function get_properties( ){
		return $this->structure;
	} // get_properties()
	
	
	
	/**
	* Get array of structure. Is synonymous of get_properties( )
	*
	* @return array $structure
	*/
    public function get_structure( ){
		return $this->get_properties( );
	} // get_structure()
	
	
	
	/**
	* Get value
	*
	* @return string $value
	*/
    public function value( ){
		return $this->col_value;
	} // value()
	
	
	
	/**
	* Get val. Is synonymous of value( )
	*
	* @return string $value
	*/
    public function val( ){
		return $this->value( );
	} // val()
    
	
	
	/**
	* Method to clean a string
	*
	* Some strings delimiters it with "" or with ''. Clean it.
	* Cannot use str_replace because it replace inside the string
	* Cannot use preg_replace because is slow
	*
	* @param string $str_to_clean
	* @return string $str_cleaned
	*/
	private function clean_str( $str_to_clean ){
		// Trim
		$str_to_clean = trim( $str_to_clean );
		
		// Remove first & last chars ['|"]
		if( in_array( substr($str_to_clean, 0, 1) , [ '"', '\'' ]) ){
			$str_to_clean = substr($str_to_clean, 1); // Remove first char
			if( in_array( substr($str_to_clean, -1, 1) , [ '"', '\'' ]) ){
				$str_to_clean = substr($str_to_clean, 0, -1); // Remove last char
			}
			
		}
		return $str_to_clean;
	}// /clean_str()

	
	
	/**
	* Return if a String is a valid date
	*
	* @param string $date_str
	* @return bool $is_date;
	*/
    private function is_date( $date_str ){
 	 	return (bool)strtotime( $date_str );
    }
	
} // /row_math_ml_csv_struct class
?>