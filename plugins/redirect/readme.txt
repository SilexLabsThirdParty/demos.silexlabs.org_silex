notes for redirect plugin
----------------------------------------------------------------
This is a redirection plugin for Silex. 

To install it drop the "redirect/" folder in the silex plugins folder, and then activate the plugin in your manager, for the whole Silex server or for a given publication.

The parameters :
- Address to redirect to
  > This is the address where you want to redirect the user.
- Cases when to do the redirection
  > Values can be "mobile", "desktop", "html5", "flash","no-html5", "no-flash" or "always", in order to edirect when the browser does or does not support HTML5 and Flash or always redirect.

