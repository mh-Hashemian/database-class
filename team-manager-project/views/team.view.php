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
            <button class="nav-link" id="players-tab" data-bs-toggle="tab" data-bs-target="#players"
                    type="button" role="tab" aria-controls="home" aria-selected="true">لیست بازیکنان
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="sessions-tab" data-bs-toggle="tab" data-bs-target="#sessions"
                    type="button"
                    role="tab" aria-controls="profile" aria-selected="false">لیست جلسات
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="reports-tab" data-bs-toggle="tab" data-bs-target="#reports" type="button"
                    role="tab" aria-controls="reports" aria-selected="false">گزارشات
            </button>
        </li>
    </ul>
    <div class="tab-content py-3" id="myTabContent">
        <div class="tab-pane fade" id="players" role="tabpanel" aria-labelledby="players-tab">
            <h4>لیست بازیکنان</h4>
            <table class="table table-bordered mt-4">
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

            <hr class="my-4"/>


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


        </div>

        <div class="tab-pane fade show active" id="reports" role="tabpanel" aria-labelledby="reports-tab">
            <!--            <h4>گزارش ماهانه</h4>-->
            <div class="alert alert-warning">تمامی گزارشات ارائه شده مربوط به ماه جاری هستند.</div>
            <h4>تراز مالی</h4>
            <table class="table table-bordered">
                <thead>
                <tr class="text-center">
                    <th>درآمد تیم</th>
                    <th>مبلغ بستانکاری</th>
                </tr>
                </thead>
                <tbody>
                    <tr class="text-center">
                        <td><b><?= $financialBalance['total_team_income'] > 0 ? convertToPersianNumber($financialBalance['total_team_income']) : convertToPersianNumber(0) ?></b> تومان</td>
                        <td><b><?= $financialBalance['total_team_income'] > 0 ? convertToPersianNumber($financialBalance['total_players_debts']) : convertToPersianNumber(0) ?></b> تومان</td>
                    </tr>
                </tbody>
            </table>

            <hr class="my-4">

            <h4 class="mt-4">میانگین درآمد در هر جلسه</h4>
            <table class="table table-bordered">
                <thead>
                <tr class="text-center">
                    <th>تعداد جلسات برگزار شده</th>
                    <th>میانگین درآمد به ازای هر جلسه</th>
                </tr>
                </thead>
                <tbody>
                <tr class="text-center">
                    <td><b><?= convertToPersianNumber($averageIncomePerSession['sessions_count']) ?></b></td>
                    <td><b><?= $averageIncomePerSession['average_amount_per_session'] > 0 ? convertToPersianNumber($averageIncomePerSession['average_amount_per_session']) : convertToPersianNumber(0) ?></b> تومان</td>
                </tr>
                </tbody>
            </table>

            <hr class="my-4">

            <h4 class="mt-4">گزارش درآمد</h4>
            <div x-data="date()" class="d-flex align-items-center mt-3 px-2">
                <span>از</span>
                <input
                        x-ref="fromDateInput"
                        x-model="dates.fromDate"
                        class="form-control mx-3"
                        type="date"
                />
                <span>تا</span>
                <input
                        x-ref="toDateInput"
                        x-model="dates.toDate"
                        class="form-control ms-3"
                        type="date"
                />
                <button @click="setUrl" class="btn btn-primary ms-2">گزارش</button>
            </div>

            <canvas id="paymentsChart"></canvas>

            <hr class="my-4">

            <?php if (count($topActivePlayers) > 0): ?>
            <h4 class="mt-4">فعالترین بازیکنان</h4>
            <table class="table table-bordered mt-3">
                <thead>
                <tr class="text-center">
                    <th>شناسه</th>
                    <th>نام</th>
                    <th>نام خانوادگی</th>
                    <th>مقام</th>
                    <th>دفعات حضور</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($topActivePlayers as $player) : ?>
                    <tr class="text-center align-middle">
                        <td><b><?= $player['id'] ?></b></td>
                        <td><?= $player['first_name'] ?></td>
                        <td><?= $player['last_name'] ?></td>
                        <td><?= convertToPersianNumber($player['rnk']) ?></td>
                        <td><?= convertToPersianNumber($player['presence_count']) ?></td>
                        <td>
                            <div class="d-flex flex-lg-row flex-column gap-1">
                                <a class="btn btn-success btn-sm w-100" href="/players?id=<?= $player['id'] ?>">گزارشات</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
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

  function date() {
    return {
      dates: {
        fromDate: "<?= $fromDate ?>",
        toDate: "<?= $toDate ?>"
      },
      init() {
        this.$refs.fromDateInput.max = this.dates.toDate
        this.$refs.toDateInput.min = this.dates.fromDate
      },
      setUrl() {
        const url = window.location.href
        const urlParams = new URLSearchParams(url)
        const teamId = urlParams.get('id')
        newUrl = `${window.location.origin}${window.location.pathname}?&id=${teamId}&from=${this.dates.fromDate}&to=${this.dates.toDate}`
        location.replace(newUrl)
      }
    }
  }

  const activeTabId = localStorage.getItem('activeTabId') ?? 'reports-tab'
  const navLinks = $(".nav-link")
  navLinks.each(function (i, link) {
    link.onclick = function (e) {
      localStorage.setItem('activeTabId', e.target.id)
    }
    if (this.id === activeTabId) {
      this.classList.add('active')
      $(".tab-pane").each(function (i, pane) {
        if (link.dataset['bsTarget'] === '#' + pane.id) {
          pane.classList.add('show', 'active')
          return
        }
        pane.classList.remove('show', 'active')
      })
      return
    }
    this.classList.remove('active')
  })

  const paymentsJson = '<?= $incomePerSession ?>'
  const incomePerSession = JSON.parse(paymentsJson)
  const xValues = [];
  const yValues = [];
  for (const _p of incomePerSession) {
    xValues.push(_p.date)
    yValues.push(+_p.amount_paid)
  }

  new Chart("paymentsChart", {
    type: "line",
    data: {
      labels: xValues,
      datasets: [{
        backgroundColor: "rgba(0,0,255,1)",
        borderColor: "rgba(0,0,255,0.1)",
        label: 'مبلغ جمع آوری شده',
        font: 'Vazirmatn',
        data: yValues
      }]
    },
    options: chartOptions
  });
  Chart.defaults.font.family = "Vazirmatn"

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
      success: function () {
        location.reload();
      }
    })
  })
</script>