<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <script
    src="js/all.js"
    defer
  ></script>
</head>

<body>
  <div class="login-message register-message"></div>
  <div class="register-title">
    <h1>註冊</h1>
  </div>
  <div class="register-panel">
    <form
      action=''
      method='POST'
    >
      <div class="register-title">選擇您的使用者名稱：</div>
      <input
        class="register-input"
        name="username"
        type="text"
        placeholder="帳號"
      />
      <div class="register-title">建立密碼：</div>
      <input
        class="register-input"
        name="password"
        type="password"
        placeholder="密碼"
      />
      <div class="register-title">選擇您的暱稱：</div>
      <input
        class="register-input"
        name="nickname"
        type="text"
        placeholder="暱稱"
      />
      <input
        class="register-btn"
        type="submit"
        value="註冊"
      />
    </form>
  </div>
  <div class="register-info">
    <a href="login.php">已有帳號? 請按此登入</a>
  </div>
</body>

</html>