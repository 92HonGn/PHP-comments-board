<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>會員登入</title>
  <script
    src="js/all.js"
    defer
  ></script>
</head>

<body>
  <div class="login-message"></div>
  <div class="login-title">
    <h1>登入</h1>
  </div>
  <div class="login-panel">
    <form
      action=''
      method='POST'
    >
      <input
        class="login-input"
        name="username"
        type="text"
        placeholder="帳號"
      />
      <input
        class="login-input"
        name="password"
        type="password"
        placeholder="密碼"
      />
      <input
        class="login-btn"
        type='submit'
        value="登入"
      />
    </form>
  </div>
  <div class="login-info">
    <a href="register.php">首次登入，請按此註冊</a>
  </div>
</body>

</html>