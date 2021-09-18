# row-math-ml-csv

# Check row data from csv to extract number & percentage of emtpy, null, na, nan values, extract the type of the value (string, numeric, date, ip, emtpy, null, na, nan).

## V.1.0.0

This class is designed to work with csv data rows, but you can to check any array of data that you need.

When working with datasets, before entering them into the neural network for deep learning, you need to review the data to classify it. You need to know if there are empty, null, erroneous values, if the content is of type numeric, string, date, ip, Zero values is a lot of important to se inconsistent data and the class return a propertie for zeros, string with commas are also important because the value can be a number saparate with ',' instead of '.', .... This class row-math-ml-csv does this work for us

## Data engineering support Class in PHP that extract properties in .csv files of datasets ML rows to detect errors. It will help you to get a consistent datasets.

What do:
- Extract the type of each col in row [ 'empty', 'empty_null', 'empty_nan', 'empty_anyway', 'string', 'ip', 'date', 'numeric', 'zero', 'str_with_commas', 'string_anyway']
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
 
       $Values = ['10', '  "dirty string enclosed by double quotes"   ', '0', 'This is a string text', '2021-10-10', '192,168.1.1', '', 'null', null, 'na', 'nan', '-', 'string with, comma'];

 - 2.- Create the Class with the Values and draw the table:

        $row_math_ml_csv = new row_math_ml_csv( $Values );
        
 - 3.- Get the type of col 3:

        echo $row_math_ml_csv->col[3]->type(); // Echo 'date'
        
 - 4.- col 3 is date???:

        $row_math_ml_csv->col[3]->is('date'); // return true


 
 **Of course. You can use it freely :vulcan_salute::alien:**
 
 By Rafa.
 
 
 @author Rafael Martin Soto
 
 @author {@link http://www.inatica.com/ Inatica}
 
 @blog {@link https://rafamartin10.blogspot.com/ Rafael Martin's Blog}
 
 @since September 2021
 
 @version 1.0.1
 
 @license GNU General Public License v3.0
