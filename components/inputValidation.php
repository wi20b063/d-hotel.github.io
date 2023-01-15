<?php

function genericValidation(&$genericErr, &$genericPostField)
{
    if (empty($genericPostField) && strlen($genericPostField) < 1) {
        $genericErr = "Input ist erforderlich";
        return false;
    } else {
        return true;
    }
}

function pwd_equalValidation($newPwd, $newPwdrepeat, &$newPasswordRepeatedErr)
{
    if (strcmp($newPwd, $newPwdrepeat) == 0) {
        return true;
    } else {
        $newPasswordRepeatedErr = "Passwörter stimmen nicht überein...";
        return false;
    }
}

//check existing pwd vs pwd provided. used within Session 
function pwd_verify($pwd, &$oldPasswordErr)
{
    if (isset($_SESSION["password"]) && strlen($_SESSION["password"]) > 0) {
        if (strcmp(md5($pwd), $_SESSION["password"]) == 0) {
            return true;
        }
    }
    $oldPasswordErr = "Aktuelles Passwort ungültig";
    return false;
}

//validate the complexity for passwords: can be extended if necessary 
function pwd_verifyNewPwd($currPwd, $newPwd, &$newPasswordErr)
{
    $validPwd = true;
    $pwdLeng = 6;
    $pwdRegNum = "#[0-9]+#";
    $pwdRegUpp = "#[A-Z]+#";
    $pwdRegLow = "#[a-z]+#";
    $temp = md5($currPwd);
    if (!pwd_verify($currPwd, $oldPasswordErr)) {
        $validPwd = false;
    }
    if (strlen($newPwd) < $pwdLeng) {
        $newPasswordErr = $newPasswordErr . "Passwort muss mindestens $pwdLeng Zeichen lang sein. ";
        $validPwd = false;
    }
    if (!preg_match($pwdRegLow, $newPwd)) {
        $newPasswordErr = $newPasswordErr . "Passwort benötigt mindestens einen Kleinbuchstaben. ";
        $validPwd = false;
    }
    if (!preg_match($pwdRegUpp, $newPwd)) {
        $newPasswordErr = $newPasswordErr . "Passwort benötigt mindestens einen Grossbuchstaben. ";
        $validPwd = false;
    }
    if (!preg_match($pwdRegNum, $newPwd)) {
        $newPasswordErr = $newPasswordErr . "Passwort benötigt mindestens eine Ziffer. ";
        $validPwd = false;
    } else {
        return true;
    }
    return false;
}

/* function emailValidation($emailErr){
if (empty($_POST["mail"])) {
$emailErr = "Email ist erforderlich";
return false;
} else {
// $email = test_input($_POST["mail"]);
return true;
}
}
function userValidation($usernameErr){
if (empty($_POST["mail"])) {
$usernameErr = "Username ist erforderlich";
return false;
} else {
// $username = test_input($_POST["username"]);
return true;
}
} */








?>