# row-math-ml-csv

# Check row data from csv to extract number & percentage of emtpy, null, na, nan values, extract the type of the value (string, numeric, date, ip, emtpy, null, na, nan).

## V.1.0.0

This class is designed to work with csv data rows, but you can to check any array of data that you need.

You can use this class for clean .csv data too.

When working with datasets, before entering them into the neural network for deep learning, you need to review the data to classify it. You need to know if there are empty, null, erroneous values, if the content is of type numeric, string, date, ip, Zero values is a lot of important to see inconsistent data, string with commas are also important because the value can be a decimal number saparate with ',' instead of '.', .... This class row-math-ml-csv does this work for us.

## Data engineering support Class in PHP that extract properties in .csv files of datasets ML rows to detect errors. It will help you to get a consistent datasets.

What it does:
- Extract the type/s of each col of the row [ 'empty', 'empty_null', 'empty_nan', 'empty_anyway', 'string', 'ip', 'date', 'numeric', 'zero', 'str_with_commas', 'positive', 'negative', 'float', 'integer' ]
- Calc the number of empty cols in a row
- Calc the percentage of empty cols in a row
- Clean the data: Trim the data and clear '' or "" enclosures of each col


# REQUERIMENTS:
 
 - A minimum (minimum, minimum, minimum requeriments is needed). Tested on:
 		
    - Simple Raspberry pi (B +	512MB	700 MHz ARM11) with Raspbian Lite PHP7.3 (i love this gadgets)  :heart_eyes:
   
    - VirtualBox Ubuntu Server 20.04.2 LTS (Focal Fossa) with PHP7.4.3

    - Mac OS X - 10.11.6.15G31 (Darwin) with PHP5.5.36
 
 
  # FILES:
 There are 3 files:
 
 *row_math_ml_csv.class.php* -> **Master class**. This file is the main file that you need to include in your code.
 
 *col_math_ml_csv.class.php* -> **Child class**. Individual cols of the Master class. Is included in row_math_ml_csv.class.php.
 
 *example.php* -> **Code with example use of the class**
 
 
 # INSTALLATION:
 A lot of easy :smiley:. It is written in PURE PHP. Only need to include the files. Tested on basic PHP installation
 
         require_once( 'row_math_ml_csv.class.php' );
 
 # BASIC USAGE:

 - 1.- Get an array with the values of the csv. We can use a simple array as an example
 
       $arr_values = ['10', '  "dirty string enclosed by double quotes"   ', '0', 'This is a string text', '2021-10-10', '192.168.1.1', '', 'null', null, 'na', 'nan', '-', 'string with, comma'];

 - 2.- Create the Class with the Values:

        $row_math_ml_csv = new row_math_ml_csv( $arr_values );
        
 - 3.- Get the type of col 4:

        echo $row_math_ml_csv->cols[4]->type(); // Echo 'date'
        
 - 4.- col 4 is date???:

        $row_math_ml_csv->cols[4]->is('date'); // return true
        
# USE ONLY FOR GET DATA CLEANED:

 - Next example show how to use the class for get values cleaned without do any type of calc on cols:
 
       // Basic usage of the class, only for clean data and reuse it without do any calc
       $config = []; // ['do_math_calcs', 'do_struct']. Empty do not calcs and not do structure actions, but is usefull for transform dirty data to cleaned data.
       $row_key = 0; // in our example we want to see $arr_values[0]. $row_key mean id[0]
       
       $row_math_ml_csv = new row_math_ml_csv( $arr_values[$row_key], $config ); // Get first row values
       
       echo 'Use the class for get only cleaned values without do any calc:'.PHP_EOL;
       
       $arr_cleaned_values = [];
       foreach($row_math_ml_csv->cols as $col){
           $arr_cleaned_values[] = $col->value();
       }

       echo 'Row id['.$row_key.']. Cleaned Values: ';
       echo implode( ',', $arr_cleaned_values );
       echo PHP_EOL;

# WHAT INFORMATION CAN I USE?
'empty': The field is empty. Either has no value or contains '-'

'empty_null': The field contains a NULL value

'empty_nan': The field contains an invalid numeric value NA or NAN

'empty_anyway': It helps us to know if it is empty in any previous way. These fields help us to be alert if our dataset contains empty or null data and to be able to act on them.

'string': The value in a string. In Machine Learning string fields cannot be handled directly. They have to be eliminated or transformed into features

'ip': The value is an IP. We can break it down if we are interested

'date': The value is a date. It is a very important piece of information to know, since dates are very important in Machine learning and can be broken down into many characteristics

'numeric': The value contains a numeric value. It is the ideal thing to be able to use in Machine learning

'zero': The value is a number 0. You have to be careful, since there are values that may seem to be correct, but a 0 could indicate a wrong value or that there is no value in that field

'str_with_commas': The value contains a string with commas. We must be careful if we have passed numbers with ',' to separate the decimals instead of using '.'

'positive': The value is a positive number

'negative': The value is a negative number

'float': Value is a floating point number

'integer': Value is an integer

# AVAILABLE PROPERTIES (each value can have 1 or more properties).

        [ 'empty', 'empty_null', 'empty_nan', 'empty_anyway', 'string', 'ip', 'date', 'numeric', 'zero', 'str_with_commas', 'positive', 'negative', 'float', 'integer' ]

# METHODS:

 - *row_math_ml_csv( $arr_alues, $config = ['do_math_calcs', 'do_struct'] ):* Create new class object with array of values:

        $row_math_ml_csv = new row_math_ml_csv( $arr_alues );
        
        // $config is an array of ['do_math_calcs', 'do_struct']. Empty [] do not calcs and not do structure actions, but is usefull for transform dirty data to cleaned data. 'do_math_calcs' is the default. If not set, the class do not do math calcs. 'do_struct' check for types of values. If not set, the class do not do any type of process in the struct. If you activate 'do_math_calcs', 'do_struct' is activated automatically.
        
        $row_math_ml_csv = new row_math_ml_csv( $arr_alues, [] );
        
 - *set_math_calcs( true|false ):* Set the class to do or no Math Calcs. The class calculate the number of empty rows and it percentage. Calcs spend valuable time on loops. It can be disabled if we don't need these operation math for speed it. Note: You can specify it too when create the class.

        $row_math_ml_csv->set_math_calcs( false );
        
 - *unset_data( ):* Unset the data and Structure of the class.

        $row_math_ml_csv->unset_data( );
        
 - *prepare_data_struct( $num_cols ):* Create the structure of the data for use later. The use of this method is for reuse the class and gain speed.

        $row_math_ml_csv->prepare_data_struct( $num_cols );
        
 - *set_data_struct( $arr_data, $num_cols = 0 ):* Set the data and structure. If you gives $num_cols, the system use it value. If not then the class calculate with count($arr_data).

        $row_math_ml_csv->set_data_struct( $arr_alues );
        
 - *re_set_data_struct( $arr_data ):* Set the data without touch structure, only changes the values of the structure created before. Is similar to set_data_struct(), but in this case, the system reuses the structure created previously for gain speed.

        $row_math_ml_csv->re_set_data_struct( $arr_alues );
        
 - *num_empty_cols( ):* return int. Get the number of empty cols in the row.

        $row_math_ml_csv->num_empty_cols( );
        
 - *perc_empty_cols( ):* return float. Get the number in % (from 0 to 1) of empty cols in the row.

        $row_math_ml_csv->perc_empty_cols( );
        
        // Examples:
        // 0.05 = 5%
        // 0.3 = 30%
        // 0.6 = 60%
        // 1 = 100%
        
 - *cols[id]->is( $propertie ):* Return [true|false] Get if col[id] is $propertie. See Available Properties

        $row_math_ml_csv->cols[3]->is( 'numeric' ); // return false in the example because col[3] is 'This is a string text', and is not numeric, is 'string'
        
 - *cols[id]->type( ):* Return String. Get the type col[id]. See Available Properties. If is string, it returns 'string_anyway'. If is empty ('', null, 'null', 'na', 'nan', '-') then return 'empty_anyway'. To check a specific property, use *col[id]->is( $propertie )*.

        $row_math_ml_csv->cols[2]->type( ); // return something like 'numeric'
        
 - *cols[id]->arr_true_properties( ):* Return array of properties string of a col. Get the properties that have [true] value

        $row_math_ml_csv->cols[2]->arr_true_properties( ); // return something like ['numeric', 'zero']
        
 - *cols[id]->get_properties( ):* Return array of all available properties with their values.

        $row_math_ml_csv->cols[2]->get_properties( ); // return something like [ 'empty' => false, 'empty_null' => false, 'empty_nan' => false, 'empty_anyway' => false, 'string' => false, 'ip' => false, 'date' => false, 'numeric' => true, 'zero' => true, 'str_with_commas' => false, 'string_anyway' => false, 'positive' => false, 'negative' => false, 'float' => false, 'integer' => false ]
        
 - *cols[id]->get_structure( ):* Is synonymous of get_properties( ).
        
 - *cols[id]->value( ):* Return the trim((string)value) & parsed without enclosure "" or ''

        echo $row_math_ml_csv->cols[1]->value( ); // See next line of the example
        
        dirty string enclosed by double quotes
        
 - *cols[id]->val( ):* Is synonymous of value( ).
        
 - *cols[id]->numeric_value( ):* Return the value in numeric format (float|integer)

        echo $row_math_ml_csv->cols[0]->numeric_value value( ); // See next line of the example
        
        10
        
 - *cols[id]->numeric_val( ):* Is synonymous of numeric_value( ).
        
 - *is( $propertie ):* Return [true|false] Return if all values of row are $propertie. See Available Properties

        echo $row_math_ml_csv->is( 'string' ); // in the example return false. There are numbers, ip, date, empties, ....
        
 - *num_cols():* Return integer. Return the number of cols in the row

        echo $row_math_ml_csv->num_cols(); // in the example return 13
        
 - *values():* Return array of cleaned string values in the row

        $arr_values_cleaned = $row_math_ml_csv->values();
        echo implode( ',', $arr_values_cleaned ); // Return ['10', 'dirty string enclosed by double quotes', '0', 'This is a string text', '2021-10-10', '192.168.1.1', '', 'null', 'null', 'na', 'nan', '-', 'string with, comma']
        
 - *strtolower_values():* Return array of strtolower(cleaned string) values in the row

        $arr_values_cleaned = $row_math_ml_csv->strtolower_values();
        echo implode( ',', $arr_values_cleaned ); // Return ['10', 'dirty string enclosed by double quotes', '0', 'this is a string text', '2021-10-10', '192.168.1.1', '', 'null', 'null', 'na', 'nan', '-', 'string with, comma']
        
  - *get_properties( ):* Return array of all available properties with their values.

        $row_math_ml_csv->get_properties( ); // return something like [ 'empty' => false, 'empty_null' => false, 'empty_nan' => false, 'empty_anyway' => false, 'string' => false, 'ip' => false, 'date' => false, 'numeric' => true, 'zero' => true, 'str_with_commas' => false, 'string_anyway' => false, 'positive' => false, 'negative' => false, 'float' => false, 'integer' => false ]
        
 - *get_structure( ):* Is synonymous of get_properties( ).
 
 **Of course. You can use it freely :vulcan_salute::alien:**
 
 By Rafa.
 
 
 @author Rafael Martin Soto
 
 @author {@link http://www.inatica.com/ Inatica}
 
 @blog {@link https://rafamartin10.blogspot.com/ Rafael Martin's Blog}
 
 @since September 2021
 
 @version 1.0.0
 
 @license GNU General Public License v3.0
