<?php

//session_start();

class captcha {

  //set property
  private $number1;
  private $number2;
  private $operator;

  function setCaptcha() {
    //set random number
    $this->number1 = rand(0, 9);
    $this->number2 = rand(0, 9);

    //set math operator list
    $listoperator = array("+", "-", "x");
    //select random operator
    $this->operator = $listoperator[rand(0, 2)];
  }

  function generateCaptcha() {
    //set number and operator
    $this->setCaptcha();

    //count the result
    if ($this->operator == "+") {
      $result = $this->number1 + $this->number2;
    } elseif ($this->operator == "-") {
      $result = $this->number1 - $this->number2;
    } else {
      $result = $this->number1 * $this->number2;
    }

    //set the result in session
    $_SESSION['result'] = $result;
  }

  function showCaptcha() {
    $var = "<span class='num-capture pull-left'>" . _t('What is the result of') . " <b>" . $this->number1 . $this->operator . $this->number2 . "</b> ?</span>";
    return $var;
  }

  function resultCaptcha() {
    return $_SESSION['result'];
  }

}
