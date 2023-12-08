<?php view('partials/header.php') ?>
<?php view('partials/nav.php') ?>

<main class="container mt-3 bg-white rounded rounded-3 p-sm-5 py-4 px-2">
    <h2>نام تیم</h2>
    <div class="mb-4">
        <form class="d-flex gap-2" action="/teams/update?id=<?= $team['id'] ?>" method="POST">
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
            <button class="nav-link active" id="players-tab" data-bs-toggle="tab" data-bs-target="#players"
                    type="button" role="tab" aria-controls="home" aria-selected="true">لیست بازیکنان
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="sessions-tab" data-bs-toggle="tab" data-bs-target="#sessions" type="button"
                    role="tab" aria-controls="profile" aria-selected="false">لیست جلسات
            </button>
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
                <?php foreach ($players as $player) : ?>
                    <tr class="text-center align-middle">
                        <td><b><?= $player['id'] ?></b></td>
                        <td><?= $player['first_name'] ?></td>
                        <td><?= $player['last_name'] ?></td>
                        <td class="align-middle">
                            <div class="d-flex flex-lg-row flex-column gap-1 align-middle h-100">
                                <a class="btn btn-success btn-sm w-100"
                                   href="/players?id=<?= $player['id'] ?>">گزارشات</a>
                                <form class="d-inline-block mb-0 w-100"
                                      action="/players/delete?teamId=<?= $team['id'] ?>&playerId=<?= $player['id'] ?>"
                                      method="POST">
                                    <button type="submit" class="btn btn-danger btn-sm w-100">حذف</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr class="text-center align-middle">
                    <form action="players/create?teamId=<?= $team_id ?>" method="POST">
                        <td>
                            <b>#</b>
                        </td>
                        <td>
                            <input name="firstName" class="form-control text-center" type="text" required/>
                        </td>
                        <td>
                            <input name="lastName" class="form-control text-center" type="text" required/>
                        </td>
                        <td>
                            <button type="submit" class="btn btn-primary">افزودن</button>
                        </td>
                    </form>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="tab-pane fade" id="sessions" role="tabpanel" aria-labelledby="sessions-tab">
            <h4>لیست جلسات</h4>

          <?php if (count($sessions) > 0): ?>
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
                  <?php foreach ($sessions as $session) : ?>
                      <tr class="text-center align-middle">
                          <td><b><?= $session['id'] ?></b></td>
                          <td><?= $session['title'] ?></td>
                          <td>
                              <b><?= $formatter->format(date_create($session['date'])) ?></b>
                          </td>
                          <td>
                              <div class="d-flex flex-lg-row flex-column gap-1">
                                  <a class="btn btn-success btn-sm w-100" href="/sessions?id=<?= $session['id'] ?>">گزارشات</a>
                                  <button
                                          data-bs-toggle="modal"
                                          data-bs-target="#staticBackdrop"
                                          data-session-id="<?= $session['id'] ?>"
                                          data-session-title="<?= $session['title'] ?>"
                                          type="submit"
                                          class="delete-session-btn btn btn-danger btn-sm mb-0 w-100">حذف
                                  </button>
                              </div>
                          </td>
                      </tr>
                  <?php endforeach; ?>
                  </tbody>
              </table>
          <?php endif; ?>
          <?php if (count($sessions) === 0): ?>
              <p>هیچ جلسه ای ساخته نشده است.</p>
          <?php endif; ?>

            <hr class="my-4"/>

            <form class="mt-4 border py-3 px-4" action="sessions/create?teamId=<?= $team['id'] ?>" method="POST">
                <h5 class="text-center mb-3"><b>افزودن جلسه</b></h5>
                <div class="row">
                    <div class="col-sm-4 mb-sm-0 mb-2">
                        <label class="mb-1" for="title">عنوان جلسه</label>
                        <input class="form-control" type="text" name="title" id="title" required>
                    </div>
                    <div class="col-sm-4 mb-sm-0 mb-2">
                        <label class="mb-1" for="date">تاریخ جلسه</label>
                        <input
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
                <button class="btn btn-primary w-100 mt-3">افزودن</button>
            </form>
        </div>
        <!-- <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div> -->
    </div>

    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">هشدار</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="deleteContent" class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">بستن</button>
                    <button
                        id="deleteSession"
                        type="button"
                        class="btn btn-danger"
                    >حذف
                    </button>
                </div>
            </div>
        </div>
    </div>

</main>

<script>
  $(document).ready(function () {
    $("input[name='firstName']").trigger("focus")
  })

  const nameInput = $("#teamName");
  const inputValue = nameInput.val();

  nameInput.on("keyup", function (e) {
    const currentValue = e.target.value;

    if (inputValue !== currentValue && currentValue !== "") {
      $("#editTeamBtn").removeAttr('disabled')
    } else {
      $("#editTeamBtn").attr('disabled', 1)
    }
  })

  let sessionId;
  $(".delete-session-btn").on("click", function (e) {
    sessionId = e.currentTarget.dataset.sessionId;
    const {sessionTitle} = e.currentTarget.dataset;

    $("#deleteContent").html(`
      <p class="h6 mb-0">آیا از حذف جلسه <b>"${sessionTitle}"</b> اطمینان دارید؟</p>
    `)
  })

  $("#deleteSession").on("click", function () {
    $.ajax({
      url: '/sessions/delete',
      type: 'DELETE',
      data: JSON.stringify({session_id: sessionId}),
      success: function (r) {
        console.log(r)
        //location.reload();
      }
    })
  })
</script>