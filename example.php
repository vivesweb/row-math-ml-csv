<?php
/** example.php of use row_math_ml_csv.class.php class
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
*/

require_once 'row_math_ml_csv.class.php';

// Un normal uses, the data will be from .csv
// In this example we use an array of data as the same way it was .csv data

$arr_values = [
				['10', 	'  "dirty string enclosed by double quotes"   ', 	'0', 		'This is a string text', '2021-10-10', '192.168.1.1', '', 'null', null, 'na', 'nan', '-', 'string with, comma'],
				['-20', 	'test string', 									'-11.32', 	'This is a string text', '2021-10-11', '192.168.1.2', '', 'null', null, 'na', 'nan', '-', ''],
				['2.2', null, 												'na', 		'This is a string text', '2021-10-12', '192.168.1.3', '', 'null', null, 'na', 'nan', '-', '']
			];
			
$row_math_ml_csv = new row_math_ml_csv( $arr_values[0] ); // Get first row values

echo 'Type of col 4: '.$row_math_ml_csv->cols[4]->type().PHP_EOL; // Echo 'date'

echo 'Col 4 is Date?: ';

if( $row_math_ml_csv->cols[4]->is('date') ){
	echo 'true';
} else{
	echo 'false';
	}
	
echo PHP_EOL;
echo PHP_EOL;

unset( $row_math_ml_csv );





// Simulate loop reading .csv and reuse the class structure

$num_cols = count( $arr_values[0] );

$row_math_ml_csv = new row_math_ml_csv( array_fill(0, $num_cols, '0') ); // Initialize it with empty values

// Echo all available properties
echo PHP_EOL;
echo 'Properties. Names & default values:'.PHP_EOL;

// Get array of properties of one row. No matter what row is. All have the same type of properties
foreach($row_math_ml_csv->cols[0]->get_structure() as $key_name => $value_propertie ){
	echo $key_name.' => '.$value_propertie.PHP_EOL;
}

echo PHP_EOL;
echo PHP_EOL;
echo PHP_EOL;

foreach( $arr_values as $row_key => $row_values){
	// Set the values of the row reusing the class
	$row_math_ml_csv->re_set_data_struct( $row_values );
	
	echo 'Row id['.$row_key.']. Original Values: ';
	echo implode( ',', $row_values );
	
	$arr_cleaned_values = [];
	foreach($row_values as $key_value => $value){
		$arr_cleaned_values[] = $row_math_ml_csv->cols[ $key_value ]->value();
	}
	
	echo PHP_EOL;
	
	echo 'Row id['.$row_key.']. Cleaned Values: ';
	echo implode( ',', $arr_cleaned_values );
	
	echo PHP_EOL;
	
	echo 'Row id['.$row_key.']. Num Empty Cols: '.$row_math_ml_csv->num_empty_cols().'/'.$num_cols.'. Percentage Empty Cols: '.$row_math_ml_csv->perc_empty_cols().'%'.PHP_EOL;
	
	echo PHP_EOL;
	
	foreach($row_values as $key_col_value => $col_value){
		$value_parsed = $row_math_ml_csv->cols[ $key_col_value ]->value();
		echo 'Row id['.$row_key.'] Col['.$key_col_value.'] => ('.$value_parsed.'). Properties: ';
		
		foreach($row_math_ml_csv->cols[ $key_col_value ]->get_properties() as $key_name => $value_propertie ){
			echo $key_name.' => '.$value_propertie.',';
		}
	
	    echo PHP_EOL;
		
		echo 'Row id['.$row_key.'] Col['.$key_col_value.'] => ('.$value_parsed.'). True Properties: ';
		foreach($row_math_ml_csv->cols[ $key_col_value ]->arr_true_properties() as $key_name => $value_propertie ){
			echo $key_name.' => '.$value_propertie.',';
		}
		echo PHP_EOL;
		echo PHP_EOL;
	}
	
	echo PHP_EOL;
	
	
	// random col id
	$random_col_id = rand(0, $num_cols-1);
	$value_parsed = $row_math_ml_csv->cols[ $random_col_id ]->value();
	
	echo 'Properties of random col['.$random_col_id.']'.PHP_EOL;
	echo PHP_EOL;
	echo 'Row id['.$row_key.'] Col['.$random_col_id.'] => ('.$value_parsed.'). Is string???: '.(($row_math_ml_csv->cols[ $random_col_id ]->is('string'))?'true':'false').PHP_EOL;
	echo 'Row id['.$row_key.'] Col['.$random_col_id.'] => ('.$value_parsed.'). Is str_with_commas???: '.(($row_math_ml_csv->cols[ $random_col_id ]->is('str_with_commas'))?'true':'false').PHP_EOL;
	echo 'Row id['.$row_key.'] Col['.$random_col_id.'] => ('.$value_parsed.'). Is numeric???: '.(($row_math_ml_csv->cols[ $random_col_id ]->is('numeric'))?'true':'false').PHP_EOL;
	echo 'Row id['.$row_key.'] Col['.$random_col_id.'] => ('.$value_parsed.'). Is empty???: '.(($row_math_ml_csv->cols[ $random_col_id ]->is('empty'))?'true':'false').PHP_EOL;
	echo 'Row id['.$row_key.'] Col['.$random_col_id.'] => ('.$value_parsed.'). Is empty_null???: '.(($row_math_ml_csv->cols[ $random_col_id ]->is('empty_null'))?'true':'false').PHP_EOL;
	echo 'Row id['.$row_key.'] Col['.$random_col_id.'] => ('.$value_parsed.'). Is empty_nan???: '.(($row_math_ml_csv->cols[ $random_col_id ]->is('empty_anyway'))?'true':'false').PHP_EOL;
	echo 'Row id['.$row_key.'] Col['.$random_col_id.'] => ('.$value_parsed.'). Is empty_anyway???: '.(($row_math_ml_csv->cols[ $random_col_id ]->is('empty_anyway'))?'true':'false').PHP_EOL;
	echo 'Row id['.$row_key.'] Col['.$random_col_id.'] => ('.$value_parsed.'). Is date???: '.(($row_math_ml_csv->cols[ $random_col_id ]->is('date'))?'true':'false').PHP_EOL;
	echo 'Row id['.$row_key.'] Col['.$random_col_id.'] => ('.$value_parsed.'). Is ip???: '.(($row_math_ml_csv->cols[ $random_col_id ]->is('ip'))?'true':'false').PHP_EOL;
	echo 'Row id['.$row_key.'] Col['.$random_col_id.'] => ('.$value_parsed.'). Is zero???: '.(($row_math_ml_csv->cols[ $random_col_id ]->is('zero'))?'true':'false').PHP_EOL;
	echo 'Row id['.$row_key.'] Col['.$random_col_id.'] => ('.$value_parsed.'). Is positive???: '.(($row_math_ml_csv->cols[ $random_col_id ]->is('positive'))?'true':'false').PHP_EOL;
	echo 'Row id['.$row_key.'] Col['.$random_col_id.'] => ('.$value_parsed.'). Is negative???: '.(($row_math_ml_csv->cols[ $random_col_id ]->is('negative'))?'true':'false').PHP_EOL;
	echo 'Row id['.$row_key.'] Col['.$random_col_id.'] => ('.$value_parsed.'). Is float???: '.(($row_math_ml_csv->cols[ $random_col_id ]->is('float'))?'true':'false').PHP_EOL;
	echo 'Row id['.$row_key.'] Col['.$random_col_id.'] => ('.$value_parsed.'). Is integer???: '.(($row_math_ml_csv->cols[ $random_col_id ]->is('integer'))?'true':'false').PHP_EOL;
	
	echo PHP_EOL;
	echo PHP_EOL;
	echo PHP_EOL;
}

unset( $row_math_ml_csv );


// Basic usage of the class, only for clean data and reuse it without do any calc
$config = []; // ['do_math_calcs', 'do_struct']. Empty do not calcs and no not do structure actions, but is usefull for transform dirty data to cleaned data.
$row_key = 0;

$row_math_ml_csv = new row_math_ml_csv( $arr_values[$row_key], $config ); // Get first row values

echo 'Use the class for get only cleaned values without do any calc:'.PHP_EOL;

$arr_cleaned_values = [];
foreach($row_math_ml_csv->cols as $col){
	$arr_cleaned_values[] = $col->value();
}

echo 'Row id['.$row_key.']. Cleaned Values: ';
echo implode( ',', $arr_cleaned_values );
echo PHP_EOL;

unset( $row_math_ml_csv );
?>