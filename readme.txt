=== Privacy WP Lite for GDPR ===
Contributors: scott.deluzio
Tags: privacy, gdpr, user data
Tested up to: 5.1.1
Stable tag: 1.1.0
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl.html

This plugin provides a simple way to edit some of the privacy related GDPR settings available in WordPress.

== Description ==
Privacy WP provides a simple to use interface to edit some of the privacy related GDPR settings available inside of WordPress.

By default, WordPress has made a few assumptions for you when dealing with GDPR user data exports. Privacy WP allows you to edit the default assumptions made by WordPress.

**Editable Privacy Options**

* GDPR Export File Expiration: WordPress will automatically remove the export files your users request three days after they are generated. This plugin lets you set a different length of time if you need it to expire in more/less time.
* Confirmation Messages: After a user clicks the link in the email to confirm that they want to export or erase their data WordPress shows a confirmation message to the user on your site. These messages are pretty generic, so if you would like to provide more information to your users, you can do so with this plugin!
* GDPR Export Data Email: When your users request their data, it is sent to them in an email that is pretty generic. If you would like to include more information to the user, this plugin makes it easy to do.

**Self-Serve Export and Erase Requests**

* Allow your site users to initiate an export or erase request on their own with a simple to use form.
* Add the `[PrivacyRequestForm]` shortcode to a page on your site, and the GDPR export/erase form will be show to users who visit that page.
* The form functions the same way as the form in the back end for administrators, except it allows the user to enter their own details into the form.
* Users will have to confirm their email address before the export or erase request is processed. Once it is confirmed, the site administrator will receive an email indicating that a new export or erase request has been initiated.
* From there, the site administrator can process the request using the tools built into WordPress.

**Export or Erase Data From Third Party Sites**

When you receive a GDPR export or erase request, you need to export or erase the user's data from anywhere it is stored - not just your website.

While the export/erase tools built-in to WordPress are great for the data that is stored on your site, they are not able to access data from third party sites.

[Upgrade to Privacy WP pro](https://privacywp.com/downloads/privacy-wp/?utm_source=privacy-wp-lite&utm_medium=readme) to be able to export and erase data from third party sites like MailChimp, ConvertKit, Stripe, Drip, SendGrid, Help Scout, and Insightly CRM.

Think of it as a "bridge" that connects your website to the other sites where your user's data is stored.

== Screenshots ==

1. Change the number of days before the export file expires. WordPress default expiration length is 3 days.
2. Edit the confirmation notices shown to users on your site who request that their data is exported or erased.
3. Edit the email sent to users who are requesting an export of their data.
4. Use the `[PrivacyRequestForm]` shortcode to display a self-service form on your website for visitors to initiate an export or erase request. The form initiates the request, it doesn't allow data to be exported or erased without an administrator verifying the request. This form does the same thing as what an administrator would do when entering a user's email address on the export/erase admin page.


== Changelog ==
= 1.1.0 =
* Include front end self-service form for export and erase requests.
= 1.0.1 =
* Include information about third party services in Privacy WP Pro.
= 1.0.0 =
* Initial Release

== Upgrade Notice ==
= 1.1.0 =
* Include front end self-service form for export and erase requests.