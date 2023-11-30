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