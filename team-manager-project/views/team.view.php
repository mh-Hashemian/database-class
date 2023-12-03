<?php require 'partials/header.php' ?>
<?php require 'partials/nav.php' ?>

<main class="container mt-3 bg-white rounded rounded-3 p-5">
  <h2>نام تیم</h2>
  <div class="">
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
  <hr class="mt-3" />
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
          <td class="">
            <a class="btn btn-success btn-sm" href="/player?id=<?= $player['id']?>">گزارشات</a>
            <form class="d-inline-block" action="delete-player?teamId=<?= $team['id'] ?>&playerId=<?= $player['id'] ?>" method="POST">
              <button type="submit" class="btn btn-danger btn-sm">حذف</button>
            </form>
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