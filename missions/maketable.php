<?php
/**
 * HTML Table Generator for PHP PDO Database Queries
 *
 * This script allows a PHP developer to easily create professional-looking and standards-compliant
 * (X)HTML tables from results of PDO database queries while maintaning fine control over table's
 * style and markup.
 *
 * @copyright Copyright (c) 2015, Iaroslav Vassiliev <iaroslav.vassiliev@gmail.com>
 * @license http://opensource.org/licenses/MIT The MIT (X11) license
 * @author Iaroslav Vassiliev <iaroslav.vassiliev@gmail.com>
 * @version 1.0
 */

/**
 * Function makes HTML table from results of PDO database query.
 * PDO is a modern interface used to access various database systems (MySQL, SQLite,
 * MS SQL Server and 8 others) in a unified manner, see http://php.net/manual/en/book.pdo.php.
 *
 * Minimal usage example:
 * <code>
 * include_once 'maketable.php';
 * echo maketable( $pdo_connection->query( 'SELECT `name`, `address` FROM `clients`' ) );
 * </code>
 *
 * Advanced usage example with complete PDO code:
 * <code>
 * include_once 'maketable.php';
 * $sql = 'SELECT `name`, `address`, `orders_number` FROM `clients`';
 * try {
 *     $conn = new PDO( 'mysql:host=MY_HOST;dbname=MY_DATABASE', 'MY_USERNAME', 'MY_PASSWORD' );
 *     $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
 *     echo maketable(
 *         $executed_pdo_statement = $conn->query( $sql ),
 *         $column_headers = array("Client's name", 'Address', 'Number of orders'),
 *         $column_align = array('left', 'left', 'center'),
 *         $first_indent = "\t\t\t",
 *         $indent = "\t",
 *         $id = 'clients-table',
 *         $class = 'strict-blue',
 *         $style = 'padding: 0px; margin: 0px;',
 *         $caption = 'Clients',
 *         $column_classes = array('name', 'address', 'number'),
 *         $even_row_class = 'tinted',
 *         $footer_columns = array('', '', 'Total: SUM()')
 *     );
 * } catch( PDOException $e ) {
 *     echo '<p>DATABASE ERROR:<br/>' . $e->getMessage() . '<br/>SQL query: ' . $sql . '</p>';
 * }
 * $conn = null;
 * </code>
 *
 * @param PDOStatement $executed_pdo_statement
 *     The PDOStatement object returned by PDO::query() method,
 *     or PDOStatement object with prepared query on which ->execute() method was called.
 *     The only required parameter.
 * @param mixed $column_headers
 *     A string array containing headers for table columns.
 *     If $column_headers parameter is set to true (the default),
 *     then the function will try to get column headers from PDOStatement object.
 *     To omit headers row completely set $column_headers to false.
 * @param mixed $column_align
 *     A string array containing text alignment directives for table columns that will be added
 *     in style attribute to every cell.
 *     Allowed values for array elements are 'left', 'right' and 'center'.
 *     If $column_align parameter is set to true, than all textual columns will be left-aligned
 *     and all other columns will be center-aligned.
 *     Set $column_align to false for default alignment.
 * @param string $first_indent
 *     An indent that will be inserted between the beginning of the line and the <table> tag.
 *     Default is four spaces '    '.
 * @param string $indent
 *     An indent to separate <table>..<tr>..<td> tags. It can be a space ' ', a tab "\t", etc.
 *     Default is double space '  '.
 * @param string $id
 *     A value of id attribute that will be added to <table> tag.
 *     You can use it to distinguish one table from another in CSS.
 *     Default is empty string (no id).
 * @param string $class
 *     A value of class attribute that will be added to <table> tag.
 *     You can use it to apply your own CSS styles.
 *     Default class name is 'auto-generated'.
 *     Pass empty string '' to omit class specification for the table.
 * @param string $style
 *     A value of style attribute that will be added to <table> tag.
 *     Default is empty string (no styles).
 * @param string $caption
 *     Table caption.
 *     Default is empty string (no caption).
 * @param mixed $column_classes
 *     A string array containing classes that will be added to every cell in every column:
 *     first element of array to the cells of first column, second element of array
 *     to the cells of second column, etc.
 *     If $column_classes parameter is set to true, classes 'col-1', 'col-2', etc. will be added.
 *     Default is false (no classes).
 * @param string $even_row_class
 *     A name of class that will be added to every even row of the table. This allows
 *     a browser to use different colors for odd and even rows, if table style has such option.
 *     If $even_row_class parameter is set to true, class 'tinted' will be added.
 *     Default is empty string (no class).
 * @param mixed $column_footers
 *     A string array containing labels for table footer columns and optionally
 *     functions to calculate the numeric values, e.g., array('Total: SUM()', 'Average: AVG()').
 *     Allowed functions are: SUM(), AVG(), MIN(), MAX(), COUNT().
 *     These would be replaced by actual values.
 *     Only COUNT() function may be applied to non-numeric data.
 *     Providing any label forces the table to be divided into <thead>, <tfoot> and <tbody>.
 *     Default is false (no footer).
 * @return string
 *     Returns fully formatted table: '<table>...</table>'.
 */
function maketable(
	$executed_pdo_statement,
	$column_headers = true,
	$column_align = false,
	$first_indent = '    ',
	$indent = '  ',
	$id = '',
	$class = 'auto-generated',
	$style = '',
	$caption = '',
	$column_classes = false,
	$even_row_class = '',
	$column_footers = false
)
{
	// Some settings for very fine tuning
	$output_message_if_result_is_empty = true;
	$add_row_classes_to_footer = false;
	$add_row_classes_to_header = false;
	$add_row_alignments_to_footer = false;
	$add_row_alignments_to_header = false;
	$avg_function_float_precision = 2;
	$format_bool_values_nicely = true;


	// Check if statement was executed successfully
	$error_code = $executed_pdo_statement->errorCode();
	if( $error_code === null )
	{
		$error = 'Database query must be executed prior to calling maketable() function.';
		return $first_indent . '<p class="error">ERROR: ' . $error . '</p>' . "\r\n";
	}
	else if( $error_code[0] !== '0' || $error_code[1] !== '0' )
	{
		$error = $executed_pdo_statement->errorInfo()[2];
		return $first_indent . '<p class="error">ERROR: ' . $error . '</p>' . "\r\n";
	}


	// Fetch result set
	$result = $executed_pdo_statement->fetchAll( PDO::FETCH_NUM );
	if( $output_message_if_result_is_empty && !$result )
	{
		return $first_indent . '<p class="no-data-message">No data available.</p>' . "\r\n";
	}
	$row_count = count( $result );


	// Initialize arrays that must be auto-filled
	if( $column_headers === true || $column_headers === 'auto' )
	{
		$column_headers = array();
	}
	if( $column_align === true || $column_align === 'auto' )
	{
		$column_align = array();
	}


	// Define common data formats
	$column_format_keywords = array(
		'text'    => array( 'str', 'char', 'text', 'vargraphic', 'binary', 'lob' ),
		'numeric' => array( 'int', 'float', 'num', 'decimal', 'real', 'double', 'long', 'money' ),
		'boolean' => array( 'bool', 'bit' ),
		'time'    => array( 'time', 'date', 'duration', 'interval', 'year' )
	);
	$column_format = array();


	// Get columns info and column headers from database if they are not provided explicitly
	$column_count = $executed_pdo_statement->columnCount();
	for( $col = 0; $col < $column_count; $col++ )
	{
		$column_info = $executed_pdo_statement->getColumnMeta( $col );

		if( is_array( $column_info ) )
		{
			// Get column headers from PDOStatement object
			if( is_array( $column_headers ) && !isset( $column_headers[ $col ] ) )
			{
				if( !function_exists( 'mb_strtoupper ' ) )
				{
					$column_headers[ $col ] = ucfirst( $column_info['name'] );
				}
				else
				{
					$len = mb_strlen( $column_info['name'], 'UTF-8' );
					$column_headers[ $col ] =
						mb_strtoupper( mb_substr( $column_info['name'], 0, 1, 'UTF-8' ), 'UTF-8' ) .
						mb_substr( $column_info['name'], 1, $len, 'UTF-8' );
				}
			}

			// Check if format detection is really needed to align text or to format boolean values
			if( ( is_array( $column_align ) && !isset( $column_align[ $col ] ) )
				|| $format_bool_values_nicely )
			{
				// Try to detect column format
				$column_type = '';
				if( isset( $column_info['native_type'] ) )
				{
					$column_type .= ' ' . $column_info['native_type'];
				}
				if( isset( $column_info['driver:decl_type'] ) )
				{
					$column_type .= ' ' . $column_info['driver:decl_type'];
				}
				foreach( $column_format_keywords as $format => $keywords )
				{
					if( !isset( $column_format[ $col ] ) )
					{
						foreach( $keywords as $keyword )
						{
							if( stripos( $column_type, $keyword ) !== false )
							{
								$column_format[ $col ] = $format;
								break;
							}
						}
					}
				}

				// If type detection was unsuccessful try values in 'pdo_type'
				// Although values in 'pdo_type' seem to be the least precise
				if( !isset( $column_format[ $col ] ) && isset( $column_info['pdo_type'] ) )
				{
					switch( $column_info['pdo_type'] )
					{
						case PDO::PARAM_LOB:
						case PDO::PARAM_STR:
							$column_format[ $col ] = 'text';
						case PDO::PARAM_INT:
							$column_format[ $col ] = 'number';
						case PDO::PARAM_BOOL:
							$column_format[ $col ] = 'boolean';
					}
				}

				// If user desires, align textual data to the left, other data to the center
				if( is_array( $column_align ) && !isset( $column_align[ $col ] ) )
				{
					if( $column_format[ $col ] === 'text' )
					{
						$column_align[ $col ] = 'left';
					}
					else
					{
						$column_align[ $col ] = 'center';
					}
				}

				// Format boolean values nicely if allowed
				if( $format_bool_values_nicely && $column_format[ $col ] === 'boolean' )
				{
					for( $row = 0; $row < $row_count; $row++ )
					{
						if( $result[ $row ][ $col ] )
						{
							$result[ $row ][ $col ] = '✔';
						}
						else
						{
							$result[ $row ][ $col ] = '';
						}
					}
				}
			}
		}
		// Show error message if $column_info is required but ->getColumnMeta() is not supported
		else
		{
			if( is_array( $column_headers ) && count( $column_headers ) == 0 )
			{
				$error = 'Unable to get column headers from database query. ' .
					'Please, provide the headers explicitly in $column_headers array.';
				return $first_indent . '<p class="error">ERROR: ' . $error . '</p>' . "\r\n";
			}
			if( is_array( $column_align ) && count( $column_align ) == 0 )
			{
				$error = 'Unable to get column data types from database query. ' .
					'Please, specify the alignment explicitly in $column_align array.';
				return $first_indent . '<p class="error">ERROR: ' . $error . '</p>' . "\r\n";
			}
		}
	}


	// Auto-fill parameters if required
	if( $column_classes === true )
	{
		$column_classes = array();
		for( $col = 0; $col < $column_count; $col++ )
		{
			$column_classes[] = 'col-' . ( $col + 1 );
		}
	}
	if( $even_row_class === true )
	{
		$even_row_class = 'tinted';
	}


	// Validate arguments
	foreach( array( 'column_headers', 'column_align', 'column_classes', 'column_footers' ) as $arg )
	{
		if( $$arg && count( $$arg ) != $column_count )
		{
			$error = 'Number of elements in $' . $arg . ' array doesn\'t match ' .
				'the number of columns in the database query result set.';
			return $first_indent . '<p class="error">ERROR: ' . $error . '</p>' . "\r\n";
		}
	}


	// Setup indentation
	$row_indent = $first_indent . $indent;
	$cell_indent = $first_indent . $indent . $indent;
	if( $column_footers )
	{
		$row_indent .= $indent;
		$cell_indent .= $indent;
	}


	// Add opening <table ...> tag
	$table = $first_indent . '<table';
	if( $id )
	{
		$table .= ' id="' . $id . '"';
	}
	if( $class )
	{
		$table .= ' class="' . $class . '"';
	}
	if( $style )
	{
		$table .= ' style="' . $style . '"';
	}
	$table .= ">\r\n";


	// Add <caption> tag if specified
	if( $caption )
	{
		$table .= $first_indent . $indent .
			'<caption>' . htmlspecialchars( $caption ) . '</caption>' . "\r\n";
	}


	// Add column headers if required
	if( $column_headers != null )
	{
		if( $column_footers )
		{
			$table .= $first_indent . $indent . '<thead>' . "\r\n";
		}
		$table .= $row_indent . '<tr>' . "\r\n";
		for( $col = 0; $col < $column_count; $col++ )
		{
			$table .= $cell_indent . '<th';
			if( $add_row_classes_to_header && $column_classes )
			{
				$table .= ' class="' . $column_classes[ $col ] . '"';
			}
			if( $add_row_alignments_to_header && $column_align )
			{
				$table .= ' style="text-align:' . $column_align[ $col ] . '"';
			}
			$table .= '>' . htmlspecialchars( $column_headers[ $col ] ) . '</th>' . "\r\n";
		}
		$table .= $row_indent . '</tr>' . "\r\n";
		if( $column_footers )
		{
			$table .= $first_indent . $indent . '</thead>' . "\r\n";
		}
	}


	// Format column footers if required
	if( $column_footers )
	{
		for( $col = 0; $col < $column_count; $col++ )
		{
			if( strpos( $column_footers[ $col ], '()' ) !== false )
			{
				$sum = 0;
				$count = 0;
				$min = PHP_INT_MAX;
				$max = ~PHP_INT_MAX;
				foreach( $result as $row )
				{
					if( is_numeric( $row[ $col ] ) )
					{
						if( $row[ $col ] < $min )
						{
							$min = $row[ $col ];
						}
						if( $row[ $col ] > $max )
						{
							$max = $row[ $col ];
						}
						$sum += $row[ $col ];
					}
					$count++;
				}
				$column_footers[ $col ] = str_replace(
					array( 'SUM()', 'COUNT()', 'MIN()', 'MAX()', 'AVG()' ),
					array( $sum, $count, $min, $max,
						round( $sum / $count, $avg_function_float_precision ) ),
					$column_footers[ $col ]
				);
			}
		}
	}


	// Add footers if specified; according to XHTML schema <tfoot> section must precede <tbody>
	if( $column_footers )
	{
		$table .= $first_indent . $indent . '<tfoot>' . "\r\n";
		$table .= $row_indent . '<tr>' . "\r\n";
		for( $col = 0; $col < $column_count; $col++ )
		{
			$table .= $cell_indent . '<td';
			if( $add_row_classes_to_footer && $column_classes )
			{
				$table .= ' class="' . $column_classes[ $col ] . '"';
			}
			if( $add_row_alignments_to_footer && $column_align )
			{
				$table .= ' style="text-align:' . $column_align[ $col ] . '"';
			}
			$table .= '>' . htmlspecialchars( $column_footers[ $col ] ) . '</td>' . "\r\n";
		}
		$table .= $row_indent . '</tr>' . "\r\n";
		$table .= $first_indent . $indent . '</tfoot>' . "\r\n";
	}


	// Add data from result set
	if( $column_footers )
	{
		$table .= $first_indent . $indent . '<tbody>' . "\r\n";
	}
	for( $row = 0; $row < $row_count; $row++ )
	{
		if( $even_row_class && ( $row % 2 ) )
		{
			$table .= $row_indent . '<tr class="' . $even_row_class . '">' . "\r\n";
		}
		else
		{
			$table .= $row_indent . '<tr>' . "\r\n";
		}
		for( $col = 0; $col < $column_count; $col++ )
		{
			$table .= $cell_indent . '<td';
			if( $column_classes )
			{
				$table .= ' class="' . $column_classes[ $col ] . '"';
			}
			if( $column_align )
			{
				$table .= ' style="text-align:' . $column_align[ $col ] . '"';
			}
			$table .= '>' . htmlspecialchars( $result[ $row ][ $col ] ) . '</td>' . "\r\n";
		}
		$table .= $row_indent . "</tr>\r\n";
	}
	if( $column_footers )
	{
		$table .= $first_indent . $indent . '</tbody>' . "\r\n";
	}


	// Add closing </table> tag and return
	$table .= $first_indent . '</table>' . "\r\n";
	return $table;
}


// Some example nice table styles
// TO DO


/*
The MIT License (MIT)

Copyright (c) 2015, Iaroslav Vassiliev <iaroslav.vassiliev@gmail.com>

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*/
?>
