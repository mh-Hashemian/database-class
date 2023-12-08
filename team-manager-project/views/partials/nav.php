<?php require 'header.php'; ?>

<header class="bg-white container rounded-3 mt-3 py-3 px-4 d-flex align-items-center justify-content-between">
  <a class="link-unstyled" href="/"><h2>مدیریت سانس</h2></a>
  <nav>

  </nav>
  <div class="user-info d-flex align-items-center gap-2">
    <span>
      <?= $_SESSION['user']['first_name'] 
      . ' ' . 
      $_SESSION['user']['last_name'] ?>
    </span>
 
    <div class="dropdown">
      <img class="avatar cursor-pointer" src="images/user.png" alt="تصویر کاربر">
      
      <ul class="dropdown-menu mt-1">
        <li><a class="dropdown-item" href="#">اطلاعات کاربری</a></li>
        <div class="dropdown-divider"></div>
        <li>
          <a class="dropdown-item text-danger d-flex justify-content-between" href="/logout">
            <span>خروج</span>
            <img width="24px" src="images/exit.svg" alt="خارج شدن">
          </a>
        </li>
      </ul>
    </div>
  </div>
</header>

<script>
  $(".avatar").click(function() {
    $(".dropdown-menu").toggle();
  })

  $(document).click(function() {
    const dropdown = $(".dropdown-menu")
    const toggleBtn = $(".avatar");

    if (!toggleBtn.is(event.target) && !dropdown.is(event.target) && dropdown.has(event.target).length === 0) {
      dropdown.hide();
    }
  }) 
</script>