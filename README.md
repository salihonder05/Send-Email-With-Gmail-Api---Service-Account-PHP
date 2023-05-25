## **PHP Script With Composer Package (Google Client)**

 1. Get the Google Client Library (Ensure that php is in your system's path > Install Composer > Install the library composer require google/apiclient:^2.0)
 2. Enable Gmail API (Google Developer console > Library > Search 'Gmail API' > Enable (if already enabled, you'll see the manage button)
 3. Create Service Account (Google Developer console > IAM & Admin > Service Accounts > Click 'Create Service Account' > Fill in Step 1 as usual > For Step 2, I set my service account as project owner. > Step 3 I skipped.)
 4. Create a key (Google Developer console > IAM & Admin > Service Accounts > Click on the 'Actions' menu for your newly created service account > Create Key > JSON > Store this in a spot that your code can access.)
 5. Set up domain-wide delegation (Google Admin > Security > API Permissions > Scroll all the way down to find 'Manage Domain-wide Delegation' > Click 'Add New' > Enter the Client ID found in the json file you just downloaded > Enter in the scopes you need. For sending emails through gmail, look under 'Authorization' here.)
 6. Enable domain-wide delegation (Google Developer console > IAM & Admin > Service Accounts > Click on newly created service account > Click 'Edit' > Show Domain-wide Delegation > Enable G-Suite Domain-wide Delegation)
 7. If you have followed and completed these steps, you are all set to continue to the code portion! (Php-Client.php)


## **Laravel App With Composer Package (Google Client)**

 - Install Google Client Library with this code `composer require google/apiclient`
 - Make a controller with `php artisan make:controller MailController`
 - Paste codes from MailController.php
 - Put credentials.json file in to /storage/app directory.
 - Add route for execute codes from browser/url : `Route::get('/send_email', [MailController::class, 'send_email']);` ( if you want use server side, you can. A api->endpoint, A POST service etc.)
 - If you use Google Workspace, you must enable domain-wide delegation for following oAuth scopes: 
	 - `"https://mail.google.com/",
	   "https://www.googleapis.com/auth/gmail.compose",
	   "https://www.googleapis.com/auth/gmail.modify",
	   "https://www.googleapis.com/auth/gmail.send"
 - All oAuth Scopes are here : [Google oAuth Scopes List](https://developers.google.com/identity/protocols/oauth2/scopes?hl=tr#gmail)	
 - 

**Other Documents:**

 1. [Domain-wide delegation doc from Google (TR) ](https://support.google.com/a/answer/162106?hl=tr#zippy=,bir-istemci-i%C3%A7in-alan-genelinde-yetki-ayarlar%C4%B1n%C4%B1-yapma)
 2. [Domain Wide Delegation doc from Google (TR) 2](https://developers.google.com/cloud-search/docs/guides/delegation?hl=tr)
