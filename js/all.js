;
(function () {
  document.querySelector('.login-btn').addEventListener('click', function () {
    const username = document.querySelector('[placeholder=帳號]');
    const password = document.querySelector('[placeholder=密碼]');

    if (checkRequired(username) && checkRequired(password)) {
      const xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
          if (xhr.status === 200) {
            console.log(xhr.responseText);
            if (xhr.responseText === 'error') {
              showMessage('', '帳號/密碼錯誤');
              $(".alert").alert();
            }
            if (xhr.responseText === 'ok') {
              showMessage('', '登入成功');
              document.location.href = '../index.php';
            }
          } else {
            showMessage('', '伺服器發生錯誤');
          }
        } else {
          showMessage('', '通訊中...');
        }
      }
      xhr.open('POST', 'check_login.php', true);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr.send('username=' + username.value + '&password=' + password.value);
    } else {
      if (!checkRequired(username)) showMessage(username, '以上皆為必填項目');
      if (!checkRequired(password)) showMessage(password, '以上皆為必填項目');
    }
  })

  function checkRequired(field) {
    return field.value === '' ? false : true;
  }

  function showMessage(field, message) {
    const result = document.querySelector('.login-message');
    result.textContent = message;
    result.style.visibility = 'visible';
  }
})()