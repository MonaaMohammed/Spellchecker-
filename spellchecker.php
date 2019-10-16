<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="spellcheck.css"> 
</head> 
<body>
    
<div class= "header">
    <h1> 
       Spell Check 
</h1> 
 
<div class="container"> 
           <form method="post"> 
          <h2> Type your text below to check your spellings   </h2> <br> <br> 
           <textarea name="t1" placeholder="paste content here to spell checker"></textarea> <br> <br> 
     
           <input type="submit"  value="check spellings" name ="search" >
         </form> 
<?php
  if(isset($_POST['search']) && !empty($_POST['t1']))
  {
   // splide string when it found space 
  $text =array_filter(explode(" " , $_POST['t1'])) ; 
  foreach ($text as $texts)
   {
  if (binarysearch($texts) == true)
  
             print_r("The string " . $texts ." is spelled correctly.<br>");
     else 
             print_r("Sorry, the string "  . $texts . " is misspelled." ); 
    
     }
       }
?>
</div> 
</div> 



 <?php
  
//tests if a word $text exists in the word list
function binarysearch($text) {
 $text = strtolower($text);  //covert the tested word into lower case
 $words= file("WordList.txt"); //get dictionary words in an array 
    $lowerbound =0; 
    $upperbound =count($words); 
    while($lowerbound <= $upperbound ){ 
        $position   = intval(($lowerbound + $upperbound)/2) ;
        $w1 = $words[$position];
        $w2 = substr($w1,0,strlen($w1)-2);
     if ($text < $w2 )
     {
          $upperbound= $position - 1 ;
     }
     else if($text > $w2 ) {
            $lowerbound = $position + 1;
    }
  else{
     return true;
    
  }
    }// end of while 
 
    binarysearchLetter($text);
  return false;
   
 } 
$suggestions; //the array that will hold the 5 closest words
//$n = 0; //number of words in the $suggestions array
function hammingDistance($st1,$st2){
   if(strlen($st1) < strlen($st2)){
      $minLen = strlen($st1);
      $maxLen = strlen($st2);
   }
   else{
      $minLen = strlen($st2);
      $maxLen = strlen($st1);
   }

   $M = 0;
   for($i= 0; $i < $minLen; $i++){
      if($st1[$i] == $st2[$i])
         $M++;
   }
   return $maxLen - $M;
}
 
//put the cursor in the start of the list of words starting with letter $ch using binary search
function binarysearchLetter($text) {
   //covert the tested word into upper case
   $ch = strtoupper($text[0]);
   //get dictionary words in an array
   $words= file("WordList.txt");
      $lowerbound =0; 
      $upperbound =count($words); 
      while($lowerbound <= $upperbound ){ 
          $position   = intval(($lowerbound + $upperbound)/2) ;
          $w1 = $words[$position];
          $w2 = substr($w1,0,strlen($w1)-2);
          $w2 = strtoupper($w2);
       if ($ch < $w2 )
       {
            $upperbound= $position - 1 ;
       }
       else if($ch > $w2 ) {
              $lowerbound = $position + 1;
      }
    else{
       $mis = 1;
       $n = 0;
       while($mis < strlen($text)-1 && $n < 5){
         $k = $position+1;
         while($words[$k][0] == strtolower($ch)){
            $w = substr($words[$k],0,strlen($words[$k])-2);
            if(hammingDistance($text,$w) === $mis){
               $suggestions[$n] = $w;
               $n++;
            }
            if($n == 5){
               break;
            }
            $k++;
         }
         $mis++;
      }
      foreach ($suggestions as $suggestion){    
    echo $suggestion;
      echo "<br>";
   }
       return true;
    }
      }// end of while
    return false;
   }
?>   
</body>
       </html>