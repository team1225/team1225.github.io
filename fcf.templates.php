<?php
// Built with the Form Creator from www.freecontactform.com
// Built on: 2020-11-01 10:34:56
// Creator version: 1.2.2
// Code version: 1.3

$form_template = '<!doctype html>
    <html lang=\"en\">
    <head>
        <meta charset=\"utf-8\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">
        <link href=\"fcf-assets/css/fcf.default.css\" rel=\"stylesheet\">
        <!-- {CSS-Theme} -->
        <title>Contact - Standard</title>
    </head>
    <body>
    <div class=\"fcf-form-wrap\">
    <div id=\"fcf-form\">
        <form class=\"fcf-form-class\" method=\"post\" action=\"fcf-assets/fcf.process.php\">
        <!-- {SiteKey-Hidden} -->
    <h1><span style=\"font-style: normal; font-weight: 400;\">Contact Form</span></h1><div class=\"field\">
        <label for=\"Name\" class=\"label has-text-weight-normal\">Your name</label>
        <div class=\"control\">
            <input type=\"text\" name=\"Name\" id=\"Name\" class=\"input is-full-width\" maxlength=\"60\" data-validate-field=\"Name\">
        </div>
    </div>
    <div class=\"field\">
        <label for=\"Email\" class=\"label has-text-weight-normal\">Your email address</label>
        <div class=\"control\">
            <input type=\"email\" name=\"Email\" id=\"Email\" class=\"input is-full-width\" maxlength=\"100\" data-validate-field=\"Email\">
        </div>
    </div>
    <div class=\"field\">
        <label for=\"Topic\" class=\"label has-text-weight-normal\">What can we help you with?</label>
        <div class=\"control\">
            <div class=\"select is-fullwidth\">
                <select name=\"Topic\" id=\"Topic\" data-validate-field=\"Topic\">
                    <option value=\"\" selected>Choose..</option>
    <option value=\"Sales\">Sales</option>
    <option value=\"Technical Support\">Technical Support</option>
    <option value=\"General Inquiry\">General Inquiry</option>
    <option value=\"Other\">Other</option>
    </select>
            </div>
        </div>
    </div>
    <div class=\"field\">
        <label for=\"Message\" class=\"label has-text-weight-normal\">Your message</label>
        <div class=\"control\">
        <textarea name=\"Message\" id=\"Message\" class=\"textarea\" maxlength=\"3000\" rows=\"10\" data-validate-field=\"Message\"></textarea>
        </div>
    </div>
    <div class=\"field\">
        <legend class=\"label has-text-weight-normal\"></legend>
        <div class=\"control\">
            <div>
        <label for=\"Sign-up-1\">
            <input type=\"checkbox\" name=\"Sign-up\" id=\"Sign-up-1\" value=\"Sign-up\">
            Tick here to sign-up to our newsletter
        </label>
        </div>
    
        </div>
    </div>
    <div id=\"fcf-status\" class=\"fcf-status\"></div>
    <div class=\"field\">
        <div class=\"buttons\">
        <button id=\"fcf-button\" type=\"submit\" class=\"button is-link is-medium is-fullwidth\">Send Message</button>
        </div>
    </div>
    </form>
        </div>
        <div id=\"fcf-thank-you\" style=\"display:none\">
            <!-- Thank you message goes below -->
            <strong>Thank you</strong>
            <p>Thanks for contacting us, We will get back in touch with you soon.</p>
            <!-- Thank you message goes above -->
        </div>
    </div>
    <!-- {JS-Validate} -->
    </body>
    </html>
    ';

$css_template = '
    .fcf-form-wrap {
        max-width:500px;
        padding:30px;
        border-radius:4px;
        background-color: #FFFFFF;
    }
    #fcf-form {
        background-color: #FFFFFF;
        color: #363636;
    }
    #fcf-thank-you {
        color: #363636;
    }
    .label {
        color: #363636;
    }
    strong {
        color: #363636;
    }
    .input, .textarea, .select select {
        background-color: #FFFFFF;
        border-color: #DBDBDB;
        color: #363636;
    }
    .input:focus,.textarea:focus,.select select:focus,
    .input:active,.textarea:active,.select select:active,
    .input:hover,.textarea:hover,.select select:hover {
        border-color: #DBDBDB;
        box-shadow: none;
    }
    .file-label:hover .file-cta {
        background-color: #276CDA;
        color: #FFFFFF;
    }
    .file-label:hover .file-name {
        border-color: #DBDBDB;
    }
    .file-label:active .file-cta {
        background-color: #276CDA;
        color: #FFFFFF;
    }
    .file-label:active .file-name {
        border-color: #cfcfcf;
    }
    .file-cta {
        background-color: #3273DC;
        border-color: #DBDBDB;
        color: #FFFFFF;
    }
    .file-name {
        background-color: #FFFFFF;
        border-color: #DBDBDB;
    }
    .button.is-link {
        background-color: #3273DC;
        color: #FFFFFF;
    }
    .button.is-link:hover {
        background-color: #276CDA;
        color: #FFFFFF;
    }
    .button.is-link[disabled] {
        background-color: #276CDA;
        border-color: transparent;
        box-shadow: none;
    }
    ';

$form_valjs = '{
  "Name": {
    "required": true,
    "maxLength": 60
  },
  "Email": {
    "required": true,
    "maxLength": 100,
    "email": true
  },
  "Topic": {
    "required": true
  },
  "Message": {
    "required": true,
    "maxLength": 3000
  },
  "Sign-up": {
    "required": false
  }
}';

$rules = '$rules = array(
  "Name" => array(
    "required" => true,
    "label" => "Your name",
    "maxLength" => 60
  ),
  "Email" => array(
    "required" => true,
    "label" => "Your email address",
    "maxLength" => 100,
    "email" => true
  ),
  "Topic" => array(
    "required" => true,
    "label" => "What can we help you with?"
  ),
  "Message" => array(
    "required" => true,
    "label" => "Your message",
    "maxLength" => 3000
  ),
  "Sign-up" => array(
    "required" => false
  )
);';

$email_html = '<tr>
        <td style="color: #000000; font-family: Arial, sans-serif; font-size: 14px; font-weight:bold">
            Your name
        </td>
        <td style="color: #153643; font-family: Arial, sans-serif; font-size: 14px;">
            {Name}
        </td>
    </tr><tr>
        <td style="color: #000000; font-family: Arial, sans-serif; font-size: 14px; font-weight:bold">
            Your email address
        </td>
        <td style="color: #153643; font-family: Arial, sans-serif; font-size: 14px;">
            {Email}
        </td>
    </tr><tr>
        <td style="color: #000000; font-family: Arial, sans-serif; font-size: 14px; font-weight:bold">
            What can we help you with?
        </td>
        <td style="color: #153643; font-family: Arial, sans-serif; font-size: 14px;">
            {Topic}
        </td>
    </tr><tr>
        <td style="color: #000000; font-family: Arial, sans-serif; font-size: 14px; font-weight:bold">
            Your message
        </td>
        <td style="color: #153643; font-family: Arial, sans-serif; font-size: 14px;">
            {Message}
        </td>
    </tr><tr>
        <td style="color: #000000; font-family: Arial, sans-serif; font-size: 14px; font-weight:bold">
            
        </td>
        <td style="color: #153643; font-family: Arial, sans-serif; font-size: 14px;">
            {Sign-up}
        </td>
    </tr>';

$email_text = '
Your name: {Name}
Your email address: {Email}
What can we help you with?: {Topic}
Your message: {Message}
: {Sign-up}';