

<div id="amazon-root"></div>
<script type="text/javascript">

  window.onAmazonLoginReady = function() {
    amazon.Login.setClientId('amzn1.application-oa2-client.cd0157406e1f4c41b277037265856bbd');
  };
  (function(d) {
    var a = d.createElement('script'); a.type = 'text/javascript';
    a.async = true; a.id = 'amazon-login-sdk';
    a.src = 'https://api-cdn.amazon.com/sdk/login1.js';
    d.getElementById('amazon-root').appendChild(a);
  })(document);

</script>

<a href="#" id="LoginWithAmazon">
  <img border="0" alt="Login with Amazon"
    src="https://images-na.ssl-images-amazon.com/images/G/01/lwa/btnLWA_gold_156x32.png"
    width="156" height="32" />
</a>
<a id="Logout">Logout</a>

<script type="text/javascript">

  document.getElementById('LoginWithAmazon').onclick = function() {
    options = { scope : 'profile' };
    amazon.Login.authorize(options, 'https://staging.karmora.com/amazonlogin/handle_login.php');
    return false;
  };

</script>
<script type="text/javascript">
 document.getElementById('Logout').onclick = function() {
 amazon.Login.logout();
 };
</script>


