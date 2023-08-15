<?php

$lang =  [
  'app_required' => 'feild is required',
  'app_added_success' => 'Created Successfully',
  'app_are_you_sure' => "Are You Sure?",
  'app_confirm' => 'Confirm',
  'app_back' => 'Go Back',
  'app_some_errors' => "some errors has been found, please try again",
  'app_updated' => "Updated Successfully",
  'app_delete' => "Delete",
  'app_deleted' => "Deleted",
  'app_error' => "Error",
  'app_are_you_sure_want' => "Are You Sure You Want To",
  'question' => "?",
  'password_sent' => "We have emailed your password reset link!",
];

echo '<script>';
foreach($lang as $k=>$v)
{
  echo 'var '.$k. ' = "'.$v.'";';
}
echo '</script>';

return $lang;