<?php

$lang =  [
  'app_required' => 'الحقل مطلوب',
  'app_added_success' => 'تمت الإضافة بنجاح',
  'app_are_you_sure' => 'هل أنت متأكد؟',
  'app_confirm' => 'تأكيد',
  'app_back' => 'تراجع',
  'app_some_errors' => "تم اكتشاف بعض الأخطاء ، يرجى المحاولة مرة أخرى.",
  'app_updated' => "تم التحديث بنجاح",
  'app_delete' => "حذف",
  'app_deleted' => "تم الحذف",
  'app_error' => "خطأ",
  'app_are_you_sure_want' => "هل أنت متأكد أنك تريد",
  'question' => "؟",
  'password_sent' => "تم إرسال رابط إعادة تهيئة كلمة المرور بنجاح",
];

echo '<script>';
foreach($lang as $k=>$v)
{
  echo 'var '.$k. ' = "'.$v.'";';
}
echo '</script>';

return $lang;