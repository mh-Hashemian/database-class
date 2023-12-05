<?php require 'views/partials/header.php' ?>
<?php require 'views/partials/nav.php' ?>

<main class="container mt-3 bg-white rounded rounded-3 p-sm-5 py-4 px-2">
  <form class="mt-4 border py-3 px-4" action="/sessions/create?teamId=<?= $team['id'] ?>" method="POST">
    <div class="row">
      <div class="col-sm-4 mb-sm-0 mb-2">
        <label class="mb-1" for="title">عنوان جلسه</label>
        <input 
          value="<?= $session['title'] ?>"
          class="form-control" 
          type="text" 
          name="title" 
          id="title" 
          required
        >
      </div>
      <div class="col-sm-4 mb-sm-0 mb-2">
        <label class="mb-1" for="date">تاریخ جلسه</label>
        <input 
          value="<?= $session['date'] ?>"
          class="form-control" 
          type="date" 
          name="date" 
          id="date"
          value="<?= date("Y-m-d"); ?>"
          min="<?= date("Y-m-d"); ?>"
          required
        >
      </div>
      <div class="col-sm-4 mb-sm-0 mb-2">
        <label class="mb-1" for="fee">هزینه ورودی</label>
        <div class="d-flex align-items-center gap-2">
          <input 
            value="<?= $session['entrance_fee'] ?>"
            class="form-control" 
            type="number" 
            name="fee" 
            id="fee"
            min="0"
            step="1000"
            required
          >
          <b>تومان</b>
        </div>
      </div>
    </div>
    <button id="editBtn" disabled class="btn btn-success w-100 mt-3">ویرایش</button>
  </form>
</main>

<script>
  const titleValue = $("#title").val();
  const dateValue = $("#date").val();
  const feeValue = $("#fee").val();

  $("#title").keyup(function(e) {
    const currentValue = e.target.value;

    if (titleValue !== currentValue && currentValue !== "") {
      $("#editBtn").removeAttr('disabled')
    } else {
      $("#editBtn").attr('disabled', true)
    }
  })

  $(".form-control").change(function(e) {
    const { value, id: targetId } = e.target;
    const currentValue = value.trim();

    if (targetId === 'date') {
      if (dateValue !== currentValue && currentValue !== "") {
        $("#editBtn").removeAttr('disabled')
      } else {
        $("#editBtn").attr('disabled', true)
      }
    } else if (targetId === 'fee') {
      if (feeValue !== currentValue && currentValue !== "") {
        $("#editBtn").removeAttr('disabled')
      } else {
        $("#editBtn").attr('disabled', true)
      }
    }
  })

  $("#editBtn").click(function() {
    const title = $("#title").val();
    const date = $("#date").val();
    const fee = $("#fee").val();

    $.ajax({
      url: '/sessions/update',
      type: 'PUT',
      contentType: 'application/json',
      data: JSON.stringify({
        session_id: "<?= $session_id ?>",
        title: title,
        date: date,
        entrance_fee: fee
      }),
      success: function(response) {
        location.reload()
      }
    })
  })

</script>