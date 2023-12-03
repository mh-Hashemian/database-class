<?php require 'partials/header.php' ?>
<?php require 'partials/nav.php' ?>

<main class="container mt-3 bg-white rounded rounded-3 p-sm-5 py-4 px-2">
  <h2>نام تیم</h2>
  <div class="mb-4">
    <form class="d-flex gap-2" action="edit-team?id=<?= $team['id'] ?>" method="POST">
      <input
        name="teamName"
        id="teamName" 
        class="form-control"
        type="text" 
        value="<?= $team['name'] ?>" 
      />
      <button id="editTeamBtn" disabled class="btn btn-success">ویرایش</button>
    </form>
  </div>

  <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="players-tab" data-bs-toggle="tab" data-bs-target="#players" type="button" role="tab" aria-controls="home" aria-selected="true">لیست بازیکنان</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="sessions-tab" data-bs-toggle="tab" data-bs-target="#sessions" type="button" role="tab" aria-controls="profile" aria-selected="false">لیست جلسات</button>
    </li>
    <!-- <li class="nav-item" role="presentation">
      <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Contact</button>
    </li> -->
  </ul>
  <div class="tab-content py-3" id="myTabContent">
    <div class="tab-pane fade show active" id="players" role="tabpanel" aria-labelledby="players-tab">
      <h4>لیست بازیکنان</h4>
      <table class="table table-bordered">
        <thead>
          <tr class="text-center">
            <th>شناسه</th>
            <th>نام</th>
            <th>نام خانوادگی</th>
            <th>عملیات</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($players as $player) : ?>
            <tr class="text-center align-middle">
              <td><b><?= $player['id'] ?></b></td>
              <td><?= $player['first_name'] ?></td>
              <td><?= $player['last_name'] ?></td>
              <td class="align-middle">
                <div class="d-flex flex-lg-row flex-column gap-1 align-middle h-100">
                  <a class="btn btn-success btn-sm w-100" href="/player?id=<?= $player['id']?>">گزارشات</a>
                  <form class="d-inline-block mb-0 w-100" action="delete-player?teamId=<?= $team['id'] ?>&playerId=<?= $player['id'] ?>" method="POST">
                    <button type="submit" class="btn btn-danger btn-sm w-100">حذف</button>
                  </form>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
          <tr class="text-center align-middle">
            <form action="create-player?teamId=<?= $team_id ?>" method="POST">
              <td>
                <b>#</b>
              </td>
              <td>
                <input name="firstName" class="form-control text-center" type="text" required />
              </td>
              <td>
                <input name="lastName" class="form-control text-center" type="text" required />
              </td>
              <td>
                <button class="btn btn-primary">افزودن</button>
              </td>
            </form>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="tab-pane fade" id="sessions" role="tabpanel" aria-labelledby="sessions-tab">
      <h4>لیست جلسات</h4>

      <table class="table table-bordered">
        <thead>
          <tr class="text-center">
            <th>شناسه</th>
            <th>عنوان</th>
            <th>تاریخ</th>
            <th>عملیات</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($sessions as $session) : ?>
            <tr class="text-center align-middle">
              <td><b><?= $session['id'] ?></b></td>
              <td><?= $session['title'] ?></td>
              <td>
                <b><?= $formatter->format(date_create($session['date'])) ?></b>
              </td>
              <td>
                <div class="d-flex flex-lg-row flex-column gap-1">
                  <a class="btn btn-success btn-sm w-100" href="/session?id=<?= $player['id']?>">گزارشات</a>
                  <form class="d-inline-block mb-0 w-100" action="delete-player?teamId=<?= $team['id'] ?>&playerId=<?= $player['id'] ?>" method="POST">
                    <button type="submit" class="btn btn-danger btn-sm w-100">حذف</button>
                  </form>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <!-- <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div> -->
  </div>
</main>

<script>
  const inputValue = $("#teamName").val();

  $("#teamName").keyup(function(e) {
    const currentValue = e.target.value;
    
    if (inputValue !== currentValue && currentValue !== "") {
      $("#editTeamBtn").removeAttr('disabled')
    } else {
      $("#editTeamBtn").attr('disabled', true)
    }
  })
</script>