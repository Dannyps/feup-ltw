<html>
  <head>
    <title>EventNetwork</title>
    <meta charset="UTF-8">
  </head>
  <body>
    <h2>Login</h2>
      <form action="database/action_register.php" method="post">
        <input name="username" type="text" placeholder="Username"/>
        <input name="password" type="password" placeholder="Password"/>
        <input name="fullName" type="text" placeholder="Name"/>
        <input name="city" type="text" placeholder="City"/>
        <input id="register" type="button" value="Register"/>
      </form>
  </body>
  <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
  <script type="text/javascript" src="scripts/authentication.js"></script>
</html>
