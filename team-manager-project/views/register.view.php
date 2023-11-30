<?php require 'partials/header.php'; ?>

<div class="col-lg-4 col-sm-6 col-9 px-4 py-4 bg-light mx-auto my-auto mt-5 border">
  <h2 class="fw-bold text-center mb-4">ثبت نام</h2>

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

  <form id="registerForm" method="POST" action="/register" class="">
    <div class="mb-2 row">
      <div class="col-sm mb-sm-0 mb-2">
        <input 
          value="<?= isset($_POST['firstName']) ? $_POST['firstName'] : '' ;  ?>" 
          id="firstName" 
          name="firstName" 
          type="text" 
          class="form-control" 
          placeholder="نام" 
          required 
        />
      </div>
      <div class="col-sm">
        <input 
          value="<?= isset($_POST['lastName']) ? $_POST['lastName'] : '' ;  ?>"
          id="lastName" 
          name="lastName" 
          type="text" 
          class="form-control" 
          placeholder="نام خانوادگی" 
          required 
        />
      </div>
    </div>
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
    <div class="mb-2">
      <input 
        value="<?= isset($_POST['passwordRepeat']) ? $_POST['passwordRepeat'] : '' ;  ?>"
        id="passwordRepeat" 
        name="passwordRepeat" 
        type="password" 
        class="form-control" 
        placeholder="تکرار گذرواژه" 
        required 
      />
    </div>
    <button id="registerBtn" type="submit" class="btn btn-primary w-100">ثبت نام</button>
  </form>

  <a class="mt-2 text-center d-block" href="/login">صفحه ورود</a>
</div>