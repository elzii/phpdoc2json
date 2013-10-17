<?php 

/**
 * Pretty Print
 * @since 1.0
 * @param [$string]
 * @author Alexander Zizzo
 */
function pp($data)
{
  print '<pre style="border:1px solid #999;padding:5px;">';
  print_r($data);
  print '</pre>';
}

/**
 * This is an example function
 * @since 1.0
 * @author Alexander Zizzo
 */
function exampleFunction_1()
{
  $test = 0;
}

/**
 * This is an example function 2
 * @since 1.0
 * @author Alexander Zizzo
 */
function exampleFunction_2()
{
  $test = 0;
}


/**
 * This is an example function 3
 * @since 1.0
 * @author Alexander Zizzo
 * @example /path/to/example
 * @see element
 * @copyright ELZI 2013
 * @todo design JSON output
 */
function exampleFunction_3()
{
  $test = 0;
}

/**
 * This is an example function 4
 * @since 1.0
 * @author Alexander Zizzo
 */
function exampleFunction_4()
{
  $test = 0;
}














function get_function_names() {
  # The Regular Expression for Function Declarations
  $functionFinder = '/function[\s\n]+(\S+)[\s\n]*\(/';
  # Init an Array to hold the Function Names
  $functionArray = array();
  # Load the Content of the PHP File
  $fileContents = file_get_contents(__FILE__);
  # Apply the Regular Expression to the PHP File Contents
  preg_match_all( $functionFinder , $fileContents , $functionArray );

  # If we have a Result, Tidy It Up
  if( count( $functionArray )>1 ){
    # Grab Element 1, as it has the Matches
    $functionArray = $functionArray[1];
  }
  return $functionArray;
}
function create_docblock_array( $args = NULL ) {

  $FUNCTION_NAMES = get_function_names();
  $FUNC_COMM      = array();
  $DOC_BLOCK      = array();

  foreach( $FUNCTION_NAMES as $key => $func ) {
    $FUNC_COMM[$func] = new ReflectionFunction($func);
  }

  foreach( $FUNC_COMM as $key => $doc ) {

    $commblock = $doc->getDocComment();

    if ( $commblock ) {
      // clean up data
      $commblock             = preg_replace('/[\*]+/', '', $commblock);
      $commblock             = preg_replace('/[\/]+/', '', $commblock);
      $commblock_split       = explode("\n", $commblock);
      $commblock_split       = str_replace(array("\r","\n"), '', $commblock_split);
      $commblock_split_clean = array_filter($commblock_split);

      foreach ($commblock_split_clean as $k => $c) {
        if ( empty($c) || is_null($c) || $c === '' || strlen($c) < 2 ) {
          // print $c . 'empty string';
          unset($commblock_split_clean[$k]);
        } 
      }
      $DOC_BLOCK[$key] = $commblock_split_clean;
    }
  }
  return $DOC_BLOCK;
}


pp(create_docblock_array());

$json_arr = json_encode(create_docblock_array(), true);

pp($json_arr);