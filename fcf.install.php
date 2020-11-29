<?php
// FreeContactForm.com Installer
// October 2020
define('INSTALLFILE', 'fcf.install.php');
define('CONFIGFILE', 'fcf-assets/fcf.config.php');
define('JSFILE', 'fcf-assets/js/fcf.form.js');
define('THEMEFILE', 'fcf-assets/css/fcf.default-custom.css');
define('EMAILINHTMLFILE', 'fcf-assets/email-templates/fcf.email-in.htm');
define('EMAILINTEXTFILE', 'fcf-assets/email-templates/fcf.email-in.txt');
define('EMAILOUTHTMLFILE', 'fcf-assets/email-templates/fcf.email-out.htm');
define('EMAILOUTTEXTFILE', 'fcf-assets/email-templates/fcf.email-out.txt');
define('TEMPLATEFILE', 'fcf.templates.php');
define('FORMFILE', 'fcf.form.htm');
define('ABSPATH', dirname(__FILE__) . '/');

error_reporting(E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING | E_RECOVERABLE_ERROR);

if (!isset($_POST['LicenseKey'])) {
    echo '<!DOCTYPE html>
    <head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Form installer from FreeContactForm.com</title>
    <link href="fcf-assets/css/fcf.install.min.css" rel="stylesheet">
    </head>
    <body>';
}

if (file_exists(ABSPATH . CONFIGFILE)) {
    installAlreadyCompleted();
}

$fields = array(
    "LicenseKey",
    "ETo",
    "EToName",
    "EFrom",
    "EFromName",
    "ESubject",
    "ThankYouPage",
    "UseAutoResponse",
    "AutoResponseSubject",
    "AutoResponseFrom",
    "AutoResponseFromName",
    "UseSMTP",
    "SMTPHost",
    "SMTPUser",
    "SMTPPass",
    "SMTPAuth",
    "SMTPPort",
    "SMTPSecure",
    "SiteKey",
    "SecretKey",
    "JsValidate"
);

$config_template = "<?php
// ************************************
// This file is part of a package from:
// www.freecontactform.com
// See license for details
// October 2020
// ************************************


// ***********
// LICENSE KEY
// ***********
define('KEY', '{LicenseKey}');


// *********************
// FORM FIELD VALIDATION
// *********************
{JsValidate}


// ******************
// THANK YOU PAGE
// ******************
define('THANK_YOU_PAGE','{ThankYouPage}');


// **************************
// EMAIL TEMPLATES - INCOMING
// **************************
define('EMAIL_TEMPLATE_IN_HTML', 'fcf.email-in.htm');
define('EMAIL_TEMPLATE_IN_TEXT', 'fcf.email-in.txt');


// *******************************
// EMAIL TEMPLATES - AUTO-RESPONSE
// *******************************
define('EMAIL_TEMPLATE_OUT_HTML', 'fcf.email-out.htm');
define('EMAIL_TEMPLATE_OUT_TEXT', 'fcf.email-out.txt');

define('SEND_AUTO_RESPONSE', '{UseAutoResponse}'); // YES OR NO
define('EMAIL_OUT_SUBJECT', '{AutoResponseSubject}');
define('EMAIL_OUT_TO', 'FIELD:Email');
define('EMAIL_OUT_TO_NAME', 'FIELD:Name');
define('EMAIL_OUT_FROM', '{AutoResponseFrom}');
define('EMAIL_OUT_FROM_NAME', '{AutoResponseFromName}');


// *************
// EMAIL MESSAGE
// *************
define('EMAIL_TO', '{ETo}');
define('EMAIL_TO_NAME', '{ETo}');

define('EMAIL_TO_CC', '');
define('EMAIL_TO_CC_NAME', '');

define('EMAIL_TO_BCC', '');
define('EMAIL_TO_BCC_NAME', '');

define('EMAIL_FROM', '{EFrom}');
define('EMAIL_FROM_NAME', '{EFrom}');

define('EMAIL_REPLY_TO', 'FIELD:Email');
define('EMAIL_REPLY_TO_NAME', 'FIELD:Email');

define('EMAIL_SUBJECT_BEFORE', '');
define('EMAIL_SUBJECT', \"{ESubject}\");
define('EMAIL_SUBJECT_AFTER', '');



// ***************
// EMAIL TRANSPORT
// ***************
define('USE_SMTP', '{UseSMTP}'); // YES or NO
define('SMTP_HOST', '{SMTPHost}');
define('SMTP_USER', '{SMTPUser}');
define('SMTP_PASS', '{SMTPPass}');
define('SMTP_AUTH', '{SMTPAuth}');
define('SMTP_SECURE', '{SMTPSecure}'); // STARTTLS, SMTPS (port 465) or empty
define('SMTP_PORT', '{SMTPPort}');
define('SMTP_DEBUG', 'NO'); // YES or NO


// ************
// reCAPTCHA V3
// ************
define('RECAPTCHA_SITEKEY', '{SiteKey}');
define('RECAPTCHA_SECRETKEY', '{SecretKey}');
define('RECAPTCHA_SCORE', '0.5');
define('RECAPTCHA_ACCEPT_LOW_SCORE', 'NO'); // YES or NO



// **************************
//    DON'T CHANGE BELOW
// USED FOR VALIDATION CHECKS
// **************************
define('A', 'Rm9ybSBwcm92aWRlZCBieSB3d3cuZnJlZWNvbnRhY3Rmb3JtLmNvbQ==');
define('B', 'Rm9ybSBwcm92aWRlZCBieSA8YSBocmVmPSJodHRwczovL3d3dy5mcmVlY29udGFjdGZvcm0uY29tIj5GcmVlQ29udGFjdEZvcm0uY29tPC9hPg==');
define('C', 'Rm9ybSBwcm92aWRlZCBieSA8YSBocmVmPSJodHRwczovL3d3dy5mcmVlY29udGFjdGZvcm0uY29tIiB0YXJnZXQ9Il9ibGFuayI+RnJlZUNvbnRhY3RGb3JtLmNvbTwvYT4=');
define('D', 'Y29uZ3JhdHVsYXRpb25zIGZvciBiZWluZyBjbGV2ZXIh');
define('E', 'OGZlR3dSYkh3MjhGbg==');
define('F', 'RlJFRQ==');";

$js_recaptcha_start = "var sitekey = document.getElementById('recaptcha-sitekey').value;
        grecaptcha.execute(sitekey, {action:'contactform'}).then(function(token) {
        values.append('recaptcha-token', token);";

$js_recaptcha_stop = "});";

$js_val_template = "new JustValidate('.fcf-form-class', {
    rules: {JsRules},
    colorWrong: '#dc3545',
    focusWrongField: true,
    submitHandler: function(cform, values, ajax) {
        {JsRecaptchaStart}
        var button_value = getButtonValue('fcf-button');
        disableButton('fcf-button');
        ajax({
            url: cform.getAttribute('action'),
            method: 'POST',
            data: values,
            async: true,
            callback: function(response) {
                var done = false;
                if(response.indexOf('Fail:') == 0) {
                    // configration problem
                    showFailMessage(response);
                    enableButon('fcf-button', button_value);
                    done = true;
                }

                if(response.indexOf('Error:') == 0) {
                    // validation problem
                    showErrorMessage(response);
                    enableButon('fcf-button', button_value);
                    done = true;
                }

                if(response.indexOf('Success') == 0) {
                    showSuccessMessage(response);
                    done = true;
                }

                if(response.indexOf('URL:') == 0) {
                    doRedirect(response);
                    done = true;
                }

                if(response.indexOf('Debug:') == 0) {
                    showDebugMessage(response);
                    enableButon('fcf-button', button_value);
                    done = true;
                }

                if(done == false) {
                    showErrorMessage('Error:Sorry, an unexpected error occurred. Please try later.');
                    enableButon('fcf-button', button_value);
                }

            }
        });
    {JsRecaptchaStop}
    },
});

// Attach handler to each file upload fields
const fileInputs = document.querySelectorAll('input[type=file]');
fileInputs.forEach(function(fileInput) {
    fileInput.onchange = () => {
        if (fileInput.files.length > 0) {
          const fileName = document.querySelector('#file-upload-' + fileInput.getAttribute('id') +' .file-name');
          if(fileName) {
            fileName.textContent = fileInput.files[0].name;
          }
        }
    };
});

function getButtonValue(id) {
    return document.getElementById(id).innerText;
}

function disableButton(id) {
    document.getElementById(id).innerText = 'Please wait...';
    document.getElementById(id).disabled = true;
}

function enableButon(id, val) {
    document.getElementById(id).innerText = val;
    document.getElementById(id).disabled = false;
}

function showFailMessage(message) {
    var display = '<strong>Unexpected errors. </strong>(form has been misconfigured)<br>';
    display += message.substring(5);
    document.getElementById('fcf-status').innerHTML = display;
}

function showErrorMessage(message) {
    var display = '<strong>Validation problem:</strong><br>';
    display += message.substring(6);
    document.getElementById('fcf-status').innerHTML = display;
}

function showDebugMessage(message) {
    var display = '<strong>Debug details.</strong><br>(Please remember to switch off DEBUG mode when done!)<br>';
    display += message.substring(6);
    document.getElementById('fcf-status').innerHTML = display;
}

function showSuccessMessage(message) {
    var message = '<br><br>' + message.substring(8);
    var content = document.getElementById('fcf-thank-you').innerHTML;
    document.getElementById('fcf-thank-you').innerHTML = content + message;
    document.getElementById('fcf-status').innerHTML = '';
    document.getElementById('fcf-form').style.display = 'none';
    document.getElementById('fcf-thank-you').style.display = 'block';
}

function doRedirect(response) {
    var url = response.substring(4);
    window.location.href = url;
}";


$error_strings = array();

if (isset($_POST['LicenseKey'])) {
    installForm($config_template, $js_recaptcha_start, $js_recaptcha_stop, $js_val_template, $fields);
    exit();
}


function installForm($config_template, $js_recaptcha_start, $js_recaptcha_stop, $js_val_template, $fields) {

    global $error_strings;

    if ($_POST['UseAutoResponse'] == "") {
        $_POST['UseAutoResponse'] = "NO";
        $_POST['AutoResponseSubject'] = "";
        $_POST['AutoResponseFrom'] = "";
        $_POST['AutoResponseFromName'] = "";
    } else {
        $_POST['UseAutoResponse'] = "YES";
        if($_POST['AutoResponseFrom'] == "") {
            $_POST['AutoResponseFrom'] = $_POST['EFrom'];
            $_POST['AutoResponseFromName'] = $_POST['EFrom'];
        }
    }

    if ($_POST['UseSMTP'] == "") {
        $_POST['UseSMTP'] = "NO";
        $_POST['SMTPHost'] = "";
        $_POST['SMTPUser'] = "";
        $_POST['SMTPPass'] = "";
        $_POST['SMTPAuth'] = "";
        $_POST['SMTPPort'] = "";
    } else {
        $_POST['UseSMTP'] = "YES";
        if ($_POST['SMTPPort'] == 465) {
            $_POST['SMTPSecure'] = "SMTPS";
        } else {
            $_POST['SMTPSecure'] = "STARTTLS";
        }
        if (strlen($_POST['SMTPUser']) > 0 && strlen($_POST['SMTPPass']) > 0) {
            $_POST['SMTPAuth'] = "YES";
        } else {
            $_POST['SMTPAuth'] = "NO";
        }
    }

    if ($_POST['UseReCaptcha'] == "") {
        $_POST['SiteKey'] = "";
        $_POST['SecretKey'] = "";
    }

    include TEMPLATEFILE;
    $_POST['JsValidate'] = $rules;

    $search = array("{JsRules}", "{JsRecaptchaStart}", "{JsRecaptchaStop}");
    if (trim($_POST['SecretKey']) != "" && trim($_POST['SiteKey']) != "") {
        $replace = array($form_valjs, $js_recaptcha_start, $js_recaptcha_stop);
    } else {
        $replace = array($form_valjs, "", "");
    }
    createFile($search, $replace, $js_val_template, ABSPATH . JSFILE);

    // Create Email templates
    $html_email_template = '<!doctype html>
    <html>
    <head>
        <title>new message</title>
        <meta name="viewport" content="width=device-width">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body style="margin: 10; padding: 10;">
        <table border="0" cellpadding="8" cellspacing="0">
        <tr>
            <td colspan="2" style="color: #000000; font-family: Arial, sans-serif; font-size: 14px;">
                {EmailTemplateMessage}
            </td>
            <td colspan="2" style="color: #000000; font-family: Arial, sans-serif; font-size: 14px;">
                &nbsp;
            </td>
        </tr>
        {EmailTemplateHtml}
        </table>
    </body>
    </head>
    </html>';

    $text_email_template = '{EmailTemplateMessage}
    
    {EmailTemplateText}';

    $email_template_message = "New message from website form is below.";
    $email_template_message_ar = "Thank you for your message, we will be in touch soon.";

    // html in
    $search = array("{EmailTemplateMessage}", "{EmailTemplateHtml}");
    $replace = array($email_template_message, stripslashes($email_html));
    createFile($search, $replace, $html_email_template, ABSPATH . EMAILINHTMLFILE);

    // text in
    $search = array("{EmailTemplateMessage}", "{EmailTemplateText}");
    $replace = array($email_template_message, stripslashes($email_text));
    createFile($search, $replace, $text_email_template, ABSPATH . EMAILINTEXTFILE);

    // html out
    $search = array("{EmailTemplateMessage}", "{EmailTemplateHtml}");
    $replace = array($email_template_message_ar, stripslashes($email_html));
    createFile($search, $replace, $html_email_template, ABSPATH . EMAILOUTHTMLFILE);

    // text out
    $search = array("{EmailTemplateMessage}", "{EmailTemplateText}");
    $replace = array($email_template_message_ar, stripslashes($email_text));
    createFile($search, $replace, $text_email_template, ABSPATH . EMAILOUTTEXTFILE);


    // Create PHP Config
    setDefaults($fields);
    $search = getSearch($fields);
    $replace = getReplace($fields);
    createFile($search, $replace, $config_template, ABSPATH . CONFIGFILE);


    // Create Custom CSS (Theme)
    $theme_file_created = false;
    if(strlen(trim($css_template)) > 1) {
        createFile('', '', stripslashes($css_template), ABSPATH . THEMEFILE);
        $theme_file_created = true;
    }


    // Create Form
    if($theme_file_created) {
        $theme_replace = '<link href="'.THEMEFILE.'" rel="stylesheet">';
    } else {
        $theme_replace = '';
    }

    $form_sitekey_hidden = "";
    $form_sitekey_js = '<script src="fcf-assets/js/fcf.just-validate.min.js"></script>
    <script src="fcf-assets/js/fcf.form.js"></script>';
    if (trim($_POST['SecretKey']) != "" && trim($_POST['SiteKey']) != "") {
        $form_sitekey_hidden = '<input type="hidden" id="recaptcha-sitekey" value="' . $_POST['SiteKey'] . '">';
        $form_sitekey_js = '<script src="https://www.google.com/recaptcha/api.js?render=' . $_POST['SiteKey'] . '" async defer></script>
            <script src="fcf-assets/js/fcf.just-validate.min.js"></script>
            <script src="fcf-assets/js/fcf.form.js"></script>';
    }
    $search = array('<!-- {SiteKey-Hidden} -->', '<!-- {JS-Validate} -->', '<!-- {CSS-Theme} -->');
    $replace = array($form_sitekey_hidden, $form_sitekey_js, $theme_replace);
    createFile($search, $replace, stripslashes($form_template), ABSPATH . FORMFILE);

    if (count($error_strings) > 0) {
        echo "Fail:<br><ul>";
        foreach ($error_strings as $es) {
            echo "<li>$es</li>";
        }
        echo "</ul>";
        exit();
    } else {
        installCompleted();
    }
}


function createFile($search, $replace, $template, $filename) {
    global $error_strings;
    $file_contents = str_replace($search, $replace, $template);
    if (!$handler = fopen($filename, "wb")) {
        $error = true;
    } else {
        if (!fwrite($handler, trim($file_contents))) {
            $error = true;
        }
        fclose($handler);
    }
    if ($error) {
        $viewable_code = nl2br(str_replace("<", "&lt;", $file_contents));
        $error_strings[] = "Cannot write your file to: $filename - Please change the directory permissions to allow write access.<br /><br /> 
      If you prefer, you can create the file using the code below:<br /><br />" . $viewable_code . "<br /><br />Save the above code to a new file at: $filename";
    }
}


function setDefaults($fields) {
    foreach ($fields as $field) {
        if (!isset($_POST[$field])) {
            $_POST[$field] = "";
        }
    }
}

function getSearch($fields) {
    $search = array();
    foreach ($fields as $field) {
        $search[] = '{' . $field . '}';
    }
    return $search;
}

function getReplace($fields) {
    $replace = array();
    foreach ($fields as $field) {
        $replace[] = $_POST[$field];
    }
    return $replace;
}

function installCompleted() {
    echo "Success";
    exit();
}

function installAlreadyCompleted() {
    echo '<div class="fcf-body" style="width:730px;text-align: center;">
            <p>&nbsp;</p>
            <h3 class="fcf-h3">Your form has already been installed</h3>
            <p>&nbsp;</p>
            <p>To install again:</p>
            <p>Delete your forms configuration file at: <em>'.CONFIGFILE.'</em></p>
            <p>Then, <a href="'.INSTALLFILE.'">run the installer</a></p>
            <p>&nbsp;</p>
            <p><a href="fcf.form.htm" class="fcf-btn fcf-btn-primary fcf-btn-lg" style="text-decoration:none">View your form</a></p>
            <p>&nbsp;</p>
        </div>
        </body>
        </html>';
    exit();
}
?>


<style>
    #AutoResponseSettings,
    #UseSMTPSettings,
    #UseReCaptchaSettings {
        display: none;
    }
</style>


<div class="fcf-body" style="min-width:730px;width:730px;border:0px;padding-top:10px">

    <div id="fcf-form">
        <h3 class="fcf-h3">FCF - Form installation</h3>

        <div style="padding:20px;margin-bottom:10px;border-radius: 0.35rem;background-color:whitesmoke;">
            <p>For detailed instructions on how to install, visit the <a class="fcf-newwindow" href="https://www.freecontactform.com/form-guides/form-installation-pro" target="_blank">Installation Guide</a></p>
            <p>If you would like to have this installed for you, please <a class="fcf-newwindow" href="https://www.freecontactform.com/contact" target="_blank">Get in Touch</a></p>
        </div>

        <form id="fcf-form-id" class="fcf-form-class" method="post" action="<?php echo INSTALLFILE; ?>" autocomplete="off">


            <div class="fcf-body">

                <!-- LICENSE KEY -->
                <div class="fcf-form-group">
                    <label for="LicenseKey" class="fcf-label">License Key</label>
                    <div class="fcf-input-group">
                        <input type="text" id="LicenseKey" name="LicenseKey" class="fcf-form-control" data-validate-field="LicenseKey">
                    </div>
                </div>

                <h4>Email message:</h4>

                <div class="fcf-form-group">
                    <label for="ETo" class="fcf-label">To address</label>
                    <div class="fcf-input-group">
                        <input type="text" id="ETo" name="ETo" class="fcf-form-control" data-validate-field="ETo" autocomplete="off">
                    </div>
                </div>

                <!-- <div class="fcf-form-group">
                    <label for="EToName" class="fcf-label">To name (optional)</label>
                    <div class="fcf-input-group">
                        <input type="text" id="EToName" name="EToName" class="fcf-form-control" data-validate-field="EToName" autocomplete="off">
                    </div>
                </div> -->

                <div class="fcf-form-group">
                    <label for="EFrom" class="fcf-label">From</label>
                    <div class="fcf-input-group">
                        <input type="text" id="EFrom" name="EFrom" class="fcf-form-control" data-validate-field="EFrom" autocomplete="off">
                    </div>
                </div>

                <!-- <div class="fcf-form-group">
                    <label for="EFromName" class="fcf-label">From name (optional)</label>
                    <div class="fcf-input-group">
                        <input type="text" id="EFromName" name="EFromName" class="fcf-form-control" data-validate-field="EFromName" autocomplete="off">
                    </div>
                </div> -->

                <div class="fcf-form-group">
                    <label for="ESubject" class="fcf-label">Subject</label>
                    <div class="fcf-input-group">
                        <input type="text" id="ESubject" name="ESubject" class="fcf-form-control" data-validate-field="ESubject" autocomplete="off">
                    </div>
                </div>

                <h4>After Form Submission:</h4>
                <div class="fcf-form-group">
                    <label for="ThankYouPage" class="fcf-label">Page redirect (optional)</label>
                    <div class="fcf-input-group">
                        <input type="text" id="ThankYouPage" name="ThankYouPage" class="fcf-form-control" data-validate-field="ThankYouPage" autocomplete="off">
                    </div>
                </div>

            </div>



            <!-- USE AUTO-RESPONSE EMAIL -->
            <div class="fcf-checkbox">
                <label>
                    <input name="UseAutoResponse" type="checkbox" data-validate-field="UseAutoResponse"><i class="helper"></i>
                    Send auto-reponse email?
                </label>
            </div>

            <div class="fcf-body" id="AutoResponseSettings">

                <h4>Email Auto-Respond:</h4>

                <div class="fcf-form-group">
                    <label for="AutoResponseSubject" class="fcf-label">Subject</label>
                    <div class="fcf-input-group">
                        <input type="text" id="AutoResponseSubject" name="AutoResponseSubject" class="fcf-form-control" data-validate-field="AutoResponseSubject" value="Thanks for your message">
                    </div>
                </div>

                <div class="fcf-form-group">
                    <label for="AutoResponseFrom" class="fcf-label">From address</label>
                    <div class="fcf-input-group">
                        <input type="text" id="AutoResponseFrom" name="AutoResponseFrom" class="fcf-form-control" data-validate-field="AutoResponseFrom">
                    </div>
                </div>

                <!-- <div class="fcf-form-group">
                    <label for="AutoResponseFromName" class="fcf-label">From name (optional)</label>
                    <div class="fcf-input-group">
                        <input type="text" id="AutoResponseFromName" name="AutoResponseFromName" class="fcf-form-control" data-validate-field="AutoResponseFromName">
                    </div>
                </div> -->


            </div><!-- /auto-reponse-->







            <!-- USE SMTP -->
            <div class="fcf-checkbox">
                <label>
                    <input name="UseSMTP" type="checkbox" data-validate-field="UseSMTP"><i class="helper"></i>
                    Use SMTP for email?
                </label>
            </div>


            <div class="fcf-body" id="UseSMTPSettings">
                <h4>Email transport:</h4>

                <div class="fcf-form-group">
                    <label for="SMTPHost" class="fcf-label">Host</label>
                    <div class="fcf-input-group">
                        <input type="text" id="SMTPHost" name="SMTPHost" class="fcf-form-control" data-validate-field="SMTPHost">
                    </div>
                </div>

                <div class="fcf-form-group">
                    <label for="SMTPUser" class="fcf-label">Username</label>
                    <div class="fcf-input-group">
                        <input type="text" id="SMTPUser" name="SMTPUser" class="fcf-form-control" data-validate-field="SMTPUser">
                    </div>
                </div>

                <div class="fcf-form-group">
                    <label for="SMTPPass" class="fcf-label">Password</label>
                    <div class="fcf-input-group">
                        <input type="text" id="SMTPPass" name="SMTPPass" class="fcf-form-control" data-validate-field="SMTPPass">
                    </div>
                </div>

                <div class="fcf-form-group">
                    <label for="SMTPPort" class="fcf-label">Port</label>
                    <div class="fcf-input-group">
                        <input type="number" id="SMTPPort" name="SMTPPort" class="fcf-form-control" data-validate-field="SMTPPort">
                    </div>
                </div>

            </div><!-- /use smtp -->








            <!-- USE reCAPTCHA -->
            <div class="fcf-checkbox">
                <label>
                    <input name="UseReCaptcha" type="checkbox" data-validate-field="UseReCaptcha"><i class="helper"></i>
                    Use reCAPTCHA V3?
                </label>
            </div>


            <div class="fcf-body" id="UseReCaptchaSettings">
                <h4>reCAPTCHA:</h4>

                <div class="fcf-form-group">
                    <label for="SiteKey" class="fcf-label">Sitekey</label>
                    <div class="fcf-input-group">
                        <input type="text" id="SiteKey" name="SiteKey" class="fcf-form-control" data-validate-field="SiteKey">
                    </div>
                </div>

                <div class="fcf-form-group">
                    <label for="SecretKey" class="fcf-label">Secretkey</label>
                    <div class="fcf-input-group">
                        <input type="text" id="SecretKey" name="SecretKey" class="fcf-form-control" data-validate-field="SecretKey">
                    </div>
                </div>

            </div><!-- /use recaptcha-->



            <div id="fcf-status" class="fcf-status"></div>

            <div class="fcf-form-group">
                <button type="submit" id="fcf-button" class="fcf-btn fcf-btn-info fcf-btn-lg fcf-btn-block">Install
                    Form</button>
            </div>

        </form>
    </div>




    <div id="fcf-thank-you" style="text-align: center;">
        <p>&nbsp;</p>
        <h1>Congratulations!</h1>
        <h3 class="fcf-h3">Your form has been installed</h3>
        <p>&nbsp;</p>
        <p><a href="fcf.form.htm" class="fcf-btn fcf-btn-primary fcf-btn-lg" style="text-decoration:none">View your form</a></p>
        <p>&nbsp;</p>
    </div>


</div>

<script src="fcf-assets/js/fcf.just-validate.min.js"></script>
<script src="fcf-assets/js/fcf.install.min.js"></script>
<script src="https://code.jquery.com/jquery-3.0.0.min.js" type="text/javascript"></script>

<script>
    var UseAutoResponse = document.querySelector("input[name=UseAutoResponse]");
    var UseSMTP = document.querySelector("input[name=UseSMTP]");
    var UseReCaptcha = document.querySelector("input[name=UseReCaptcha]");

    UseAutoResponse.addEventListener('change', function() {
        if (this.checked) {
            document.getElementById('AutoResponseSettings').style.display = 'block';
        } else {
            document.getElementById('AutoResponseSettings').style.display = 'none';
        }
    });

    UseSMTP.addEventListener('change', function() {
        if (this.checked) {
            document.getElementById('UseSMTPSettings').style.display = 'block';
        } else {
            document.getElementById('UseSMTPSettings').style.display = 'none';
        }
    });

    UseReCaptcha.addEventListener('change', function() {
        if (this.checked) {
            document.getElementById('UseReCaptchaSettings').style.display = 'block';
        } else {
            document.getElementById('UseReCaptchaSettings').style.display = 'none';
        }
    });
</script>
</body>

</html>