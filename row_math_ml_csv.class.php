<?php
/** row_math_ml_csv
 *  
 * Class for manage rows structures in csv
 * It clean values and prepare values properties
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
 * @param array $row_math_ml_csv
 * @param boolean $do_math_calcs
*/

require_once 'col_math_ml_csv.class.php';

class row_math_ml_csv
{
	public 	$cols			= null;
	private $structure 		= null;
	private $do_math_calcs 	= true;
	
    public function __construct( $arr_data = null, $do_math_calcs = true ) {
		date_default_timezone_set('Europe/Madrid'); // Required for some PHP versions. If not given raises a warning
		
		$this->do_math_calcs = $do_math_calcs;
		
		if( isset($arr_data) && !is_null($arr_data) ){
        	$this->set_data_struct( $arr_data );
        }
	} // / __construct
		
	
	
	/**
	 * Set row to do or not math calcs (num emtpy rows, perc empty rows, ....)
	 *
	 * @param bool $do_math_calcs;
	 */
    public function set_math_calcs( $do_math_calcs = true ){
 	 	$this->do_math_calcs = $do_math_calcs;
    } // /set_math_calcs()
	
	
	
	/**
	 * UNSet data & Structure
	 */
    public function unset_data_and_struct( ) {
		$this->cols			= null;
		$this->structure 	= null;
	} // /unset_data_and_struct()
    
	
	
	/**
	 * PREPARE data Structure with empty values
	 *
	 * @param int $num_cols
	 */
    public function prepare_data_struct( $num_cols ) {
		$this->set_data_struct( array_fill(0, $num_cols, '0'), $num_cols );
	} // /prepare_data_struct()
    
	
    
	/**
	 * Set data & structure
	 *
	 * @param array $arr_data
	 * @param int $num_cols
	 */
    public function set_data_struct( $arr_data, $num_cols = 0 ) {
		// Clear previous data
		$this->unset_data_and_struct( );
		
		// Set data values
        foreach( $arr_data as $value ){
			$this->cols[] = new col_math_ml_csv( $value ); // Create classes
		}
		
		$this->set_num_cols( $num_cols );
		
		if( $this->do_math_calcs ){
			$this->set_num_and_perc_empty_cols( );
		}
	} // / set_data_struct()
    
    
    
	/**
	 * RE_SET data & structure
	 * This method reuse structure array for improve speed
	 *
	 * Be carefully. It do not check if structure is SET previously!!!!!
	 * If you use this method in loops, You can:
	 *  - Call before prepare_data_struct( $num_cols ) method for prepare arrays
	 *  - When create row_math_ml_csv() class give an array_fill(0, count($row_values), '0' ) parameter as: new row_math_ml_csv( array_fill(0, count($row_values), '0' ) );
	 *
	 * Note: This method assume that all rows have the same count(cols)
	 *
	 * @param array $arr_data
	 */
    public function re_set_data_struct( $arr_data ) {		
		// RE Set data values
        foreach( $arr_data as $key => $value ){
			$this->cols[$key]->set_value_struct( $value ); // Reassign values
		}
		
		if( $this->do_math_calcs ){
			$this->set_num_and_perc_empty_cols( );
		}
	} // / re_set_data_struct()
	
	
	
	/**
	 * Set Num of Cols
	 *
	 * @param int $num_cols
	 */
    private function set_num_cols( $num_cols = 0 ) {
		$this->structure['num_cols'] = (($num_col == 0)?count( $this->cols ):$num_cols);
	} // / set_num_cols()
	
	
	
	/**
	 * Set Num & perc of Empty Cols
	 */
    private function set_num_and_perc_empty_cols( ) {
		$this->set_num_empty_cols();
		$this->set_perc_empty_cols();
	} // /set_num_and_perc_empty_cols()
	
	
    
	/**
	 * Set Num of Empty Cols
	 */
    private function set_num_empty_cols( ) {
		$num_empty_cols = 0;
		
		foreach( $this->cols as $col){
			if( $col->is('empty_anyway') ){
				++$num_empty_cols;
			}
		} // /foreach key_col
		
		$this->structure['num_empty_cols'] = $num_empty_cols;
	} // / set_num_empty_cols()
	
	
    
	/**
	 * Set % of empty Cols (from 0 to 1). Ex. 0.4 = 40% empty data, 0.05 = 5% Empty data
	 *
	 */
    private function set_perc_empty_cols( ) {
		// Ensure to have $this->structure['num_empty_cols']
		if( !isset($this->structure['num_empty_cols']) ){
			$this->set_num_empty_cols( );
		}
		
		$this->structure['perc_empty_cols'] = $this->structure['num_empty_cols'] / $this->structure['num_cols']; // The correct operation would be $num_empty_cols * 1 / $num_cols;
	} // / set_perc_empty_cols()
	
	
	    
	/**
	 * Get how Many empty cols are
	 *
	 * @return int $num_empty_cols
	 */
    public function num_empty_cols( ){
		// Ensure to have $this->structure['num_empty_cols']
		if( !isset($this->structure['num_empty_cols']) ){
			$this->set_num_empty_cols( );
		}
		
		return $this->structure['num_empty_cols'];
	} // /num_empty_cols()
	
	
	    
	/**
	 * Get how Many empty cols are (in %)
	 *
	 * @return ing $perc_empty_cols
	 */
    public function perc_empty_cols( ){
		// Ensure to have $this->structure['perc_empty_cols']
		if( !isset($this->structure['perc_empty_cols']) ){
			$this->set_perc_empty_cols( );
		}
		return $this->structure['perc_empty_cols'];
	} // /perc_empty_cols()
	
	
} // /row_math_ml_csv_struct class
?>