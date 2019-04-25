<?php

// echo $email_config_set_name;

// Form attributes
//$form_attributes = array('enctype' => 'multipart/form-data');
$email_list = array(
  'name'      => 'email_list',
  'id'        => 'email_list'
);
$email_template = array(
  'name'      => 'email_template',
  'id'        => 'email_template'
);


echo form_open_multipart('newsletter/send');
?>
<p>
Email list:<br>
<?php
echo form_upload($email_list);
?>

</p>
<p>
email template (HTML):<br>
<?php
echo form_upload($email_template);
?>
</p>
<p>
<?php
echo form_submit('newsletter_submit', 'Lähetä!');
echo form_close();
?>
</p>
