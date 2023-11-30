<?php require 'partials/header.php'; ?>

<div class="col-lg-4 col-sm-6 col-9 px-4 pt-4 bg-light mx-auto my-auto mt-5 border">
  <h2 class="fw-bold text-center mb-4">ورود</h2>

  <?php if (count($errors)) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      <ul>
        <?php foreach ($errors as $error) : ?>
          <li><?= $error ?></li>
        <?php endforeach; ?>
      </ul>
    </div>

    <script>
      var alertList = document.querySelectorAll('.alert');
      alertList.forEach(function(alert) {
        new bootstrap.Alert(alert)
      })
    </script>

  <?php endif ?>

  <form id="loginForm" method="POST" action="/login" class="">
    <div class="mb-2">
      <input 
        value="<?= isset($_POST['email']) ? $_POST['email'] : '' ;  ?>"
        id="email" 
        name="email" 
        type="text" 
        class="form-control" 
        placeholder="آدرس ایمیل" 
        required 
      />
    </div>
    <div class="mb-2">
      <input 
        value="<?= isset($_POST['password']) ? $_POST['password'] : '' ;  ?>"
        id="password" 
        name="password" 
        type="password" 
        class="form-control" 
        placeholder="گذرواژه" 
        required 
      />
    </div>
    <button id="loginBtn" type="submit" class="btn btn-primary w-100">ورود به سایت</button>
  </form>

  <div class="d-flex justify-content-between mt-4">
      <p class="text-sm">حساب کاربری ندارید؟</p>
      <a href="/register">ثبت نام کنید</a>
    </div>
</div>