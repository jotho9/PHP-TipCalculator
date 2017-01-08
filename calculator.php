<!DOCTYPE html>
<html>

<head>
  <title>Tip Calculator</title>
  
  <link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
  <link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
   <?php
         
         // define variables and set to empty values
          $bill_amount = 0;
          $tip_percent = 0;
          $custom_percent = 0;
          $bill_split = 0;
          $tip = $total = '';
          $tip_id = array(10,15,20,0);
          $bill_text_color = 'w3-text-black';
          $bill_textbox_color = 'w3-border-black';
          $custom_text_color = 'w3-text-black';
          $custom_textbox_color = 'w3-border-black';
          $split_text_color = 'w3-text-black';
          $split_textbox_color = 'w3-border-black';

          // functions for calculating and displaying results 
         function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
            
         }

         function checkedRadio($data) {
           if(isset($_POST["tip_percent"]) && $_POST["tip_percent"] == $data){
            $isChecked = 'checked';
            return $isChecked;
           } 
           else {
            return '';
           }
          
          }
         function displayTipResult() {
          if(isset($_POST['tip_percent']) && test_input($_POST['tip_percent']) != 0) {
            return test_input($GLOBALS['tip_percent'])/100 * test_input($GLOBALS['bill_amount']);
          }
          else {
            return test_input($GLOBALS['custom_percent'])/100 * test_input($GLOBALS['bill_amount']);
          }
          
         }

         function displayTotal() {
          if(isset($_POST['tip_percent']) && test_input($_POST['tip_percent']) != 0) {
            return test_input($GLOBALS['tip_percent'])/100 * test_input($GLOBALS['bill_amount']) + test_input($GLOBALS['bill_amount']);

          }
           else {
            return test_input($GLOBALS['custom_percent'])/100 * test_input($GLOBALS['bill_amount']) + test_input($GLOBALS['bill_amount']);

           }
         }

         function displayTipEach() {
          return displayTipResult()/test_input($GLOBALS['bill_split']);
         }

         function displayTotalEach() {
          if($GLOBALS['tip_percent'] == 0 && ($GLOBALS['custom_percent'] > 0)) {
            return displayTotal()/test_input($GLOBALS['bill_split']);
          }
          elseif ($GLOBALS['tip_percent'] != 0) {
            return displayTotal()/test_input($GLOBALS['bill_split']);
          }
          else {
            return 0;
          }

          
         }

         function displayResults() {
          echo "<ul class='w3-ul'>".
               "<li>Tip: $".displayTipResult()."<li>".
               "<li>Total: $".displayTotal()."<li>";
          if(isset($GLOBALS['bill_split']) && test_input($GLOBALS['bill_split']) > 0) {

               echo "<li>Tip Each: $".displayTipEach()."<li>".
               "<li>Total Each: $".displayTotalEach()."<li>";
          }
               echo "</ul>";
         }


       
         // This code snippet will execute when the form is submitted. All required fields will be filtered and validated.
         if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            if(isset($_POST['bill_amount']) && filter_var(test_input($_POST["bill_amount"]), FILTER_VALIDATE_FLOAT) && !(test_input($_POST["bill_amount"]) <= 0)) {
                $bill_amount = test_input($_POST["bill_amount"]);
                 
              } 
              else {
                $bill_amount = 0;
                $bill_text_color = 'w3-text-red';
                $bill_textbox_color = 'w3-border-red';

              }
            
            if(isset($_POST['tip_percent']) && filter_var(test_input($_POST["tip_percent"]), FILTER_VALIDATE_FLOAT)){
              $tip_percent = test_input($_POST["tip_percent"]);
              
            } 

            if(isset($_POST['custom_percent']) && filter_var(test_input($_POST["custom_percent"]), FILTER_VALIDATE_FLOAT) && !(test_input($_POST["custom_percent"]) <= 0)){
              $custom_percent = test_input($_POST["custom_percent"]); 
            }
            else {
              $custom_percent = 0;
              if($GLOBALS['tip_percent'] == 0){
                $custom_text_color = 'w3-text-red';
                $custom_textbox_color = 'w3-border-red';
              }
            }
            
            if(isset($_POST['bill_split']) && filter_var(test_input($_POST["bill_split"]), FILTER_VALIDATE_INT) && !(test_input($_POST["bill_split"]) < 0)) {
              $bill_split = test_input($_POST["bill_split"]);
            }
            else {
              $bill_split = 0;
              $split_text_color = 'w3-text-red';
              $split_textbox_color = 'w3-border-red';
            }
          
         }
      ?>


    <header class="w3-container">
    	<h1>TipCalculator</h1>
    </header>

    <div class="w3-card-4, w3-half">
      <header class="w3-container w3-gray w3-text-white">
        <h2 class="w3-center">Tip Calculator</h2>
      </header>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
        <div class="w3-row, w3-section w3-margin-left ">
          <label class="w3-label, w3-inline,w3-validate <?php echo $bill_text_color;?>" for="bill_amount">Bill Subtotal: $</label>
          <input class="w3-input, w3-border <?php echo $bill_textbox_color;?>" type="text" style="width: 30%" name="bill_amount" 
          value="<?php echo $bill_amount ?>">
        </div>
        <div class="w3-row w3-section w3-margin-left">Tip Percentage: <br>
          <?php
          for($i = 0; $i < 4; ++$i){
            $checked = checkedRadio($tip_id[$i]);
            if($tip_id[$i] != 0) {
            echo "<input class='w3-radio' type='radio' name='tip_percent'".$checked." value='".$tip_id[$i]."'>
             <label class='w3-margin-right' for='".$tip_id[$i]."'>".$tip_id[$i]."%</label>";
            }
          else {
            echo "<br><input class='w3-radio w3-section' type='radio' name='tip_percent'".$checked." value='".$tip_id[$i]."'>
          <label class='w3-margin-right ".$custom_text_color."' for='Custom'>Custom Tip:</label>
          <input class='w3-input, w3-border ".$custom_textbox_color."' type='text' style='width: 30%' name='custom_percent' value='".$custom_percent."'>%";
            }
           }
          ?>
        </div>
        <div class="w3-row, w3-section w3-margin-left">
        <label class="w3-label, w3-inline,w3-validate <?php echo $split_text_color;?>" for="bill_amount">Bill Split: </label>
        <input class="w3-input, w3-border <?php echo $split_textbox_color;?>" type="text" style="max-width: 30%" name="bill_split"  
        value="<?php echo $bill_split ?>"> persons(s)
        </div>
        <br><input class="w3-section w3-margin-left" type="submit" name="Submit"><br>
        <div>
          <?php if(isset($_POST['Submit'])) {
           displayResults();
          }?>
        </div>
      </form>
    </div>
</body>

</html>



