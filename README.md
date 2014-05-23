FTP-Site-Request
================

This is an html form intended to be placed on an FTP server that is designed to serve files to outside entities for a limited amount if time. Users access this from through the intranet and enter a username, password, and date of expiration. On the date of expiration, the user’s credentials will stop working but the account is not actually deleted. The folder and data are not deleted either but the server is not intended to be used for file storage, just temporary sharing so we tell the user the files will be deleted.

The fields are validated with JavaScript, so JavaScript is required. Only browsers that support the HTML5 date type will work (currently only Chrome). If JavaScript is disabled or the date field is not supported, the user will not be able to access the form and an error message will be given. This is not the most secure setup but the form should only be accessible from the intranet so it is okay.

Upon submittal, a PHP script is executed. The PHP script sanitizes the inputs (just to be safe). It then runs a batch script to create the user account and corresponding folder which the user automatically has read/write privileges on because of the name and location.

Because the batch script requires administrator privileges, it cannot be called directly. Instead, a shortcut must be created that is set to call the script with administrator privileges. The batch script should be moved outside the publicly served director.

The PHP script then sends an email to the IT Department to notify of a successful or failed FTP site creation. No action is required from the IT department for a successful execution. The most common reason for a failure is that the user account already exists.
