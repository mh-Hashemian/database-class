<?php require("partials/header.php") ?>
<?php require("partials/nav.php") ?>

<main class="container mt-3 bg-white rounded rounded-3 p-5">
  <table class="table table-bordered">
    <thead>
      <tr class="text-center">
        <th>نام</th>
        <th>نام خانوادگی</th>
        <th>عملیات</th>
      </tr>
    </thead>
    <tbody>
        <tr class="text-center align-middle">         
          <td>
            <input
              class="name form-control text-center"
              id="playerFirstname"
              name="playerFirstname"
              type="text"
              value="<?= $player['first_name'] ?>"
            />
          </td>
          <td>
            <input
              class="name form-control text-center"
              id="playerLastname"
              name="playerLastname"
              type="text"
              value="<?= $player['last_name'] ?>"
            />
          </td>
          <td class="">
            <button id="editBtn" disabled type="submit" class="btn btn-success btn-sm">ویرایش</button>
            <form class="d-inline-block" action="delete-player?teamId=<?= $player['team_id'] ?>&playerId=<?= $player['id'] ?>" method="POST">
              <button class="btn btn-danger btn-sm">حذف</button>
            </form>
          </td>
        </tr>
    </tbody>
  </table>
</main>

<script>
  const firstnameValue = $("#playerFirstname").val();
  const lastnameValue = $("#playerLastname").val();

  $(".name").keyup(function(e) {
    const { value, id: targetId } = e.target;
    const currentValue = value.trim();
    
    if (targetId === 'playerFirstname') {
      if (firstnameValue !== currentValue && currentValue !== "") {
        $("#editBtn").removeAttr('disabled')
      } else {
        $("#editBtn").attr('disabled', true)
      }

    } else if (targetId === 'playerLastname') {
      if (lastnameValue !== currentValue && currentValue !== "") {
        $("#editBtn").removeAttr('disabled')
      } else {
        $("#editBtn").attr('disabled', true)
      }
    }
  })

  $("#editBtn").click(function() {
    $.post("/edit-player", {
      playerId: <?= $player_id ?>,
      firstname: $("#playerFirstname").val(),
      lastname: $("#playerLastname").val(),
    }, function(data, status) {
      location.reload();
    })
  })
</script>